<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CanUploadFiles;
use App\Http\Requests\StorePatient;
use App\Models\Clinic;
use App\Models\NotificationSent;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientController extends _Controller
{
    use CanUploadFiles;

    const STORAGE_PATH = '/patients';
    const STORAGE_DISC = 'local';

    public function __construct()
    {
        $this->transformer = Patient::transformer();
    }

    /**
     * Show patient (me)
     *
     * Shows logged patient's info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->responseAsJson(Auth::user());
    }

    /**
     * Show patient
     *
     * Shows a patient info specified by id
     *
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Patient $patient)
    {
        return $this->responseAsJson($patient);
    }

    /**
     * Creates patient
     *
     * Creates a new patient
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatient $request)
    {
        $patient = Patient::create($request->all());

        return $this->responseAsJson($patient, 201);
    }

    /**
     * Updates patient (me)
     *
     * Updates the information of the patient logged
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMe(StorePatient $request)
    {
        return $this->update(Auth::user(), $request);
    }

    /**
     * Updates patient
     *
     * Updates a patient's info specified by id
     *
     * @param Patient $patient
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Patient $patient, StorePatient $request)
    {
        $patient->fill(array_merge($request->except(['document', 'phones', 'tags', 'photo']), [
            'phones' => implode(';', $request->get('phones', [])),
            'tags'   => implode(';', $request->get('tags', [])),
        ]));

        if ($document = $request->get('document', false)) {
            $patient->document_type = $document['type'];
            $patient->document = $document['number'];
        }

        if ($base64_avatar = $request->get('photo', false)) {
            $avatar = base64_decode($base64_avatar, true);

            if ($avatar !== false) {
                $disk = Storage::disk(self::STORAGE_DISC);
                if ($patient->photo && $disk->exists($patient->photo)) {
                    $disk->delete($patient->photo);
                }

                $filename = $patient->id . '-' . time() . '.jpg';

                $patient->photo = $this->saveFile($filename, $avatar);
            }
        }

        $patient->update();

        return $this->responseAsJson($patient);
    }

    public function photoMe()
    {
        return $this->photo(Auth::user());
    }

    public function photo(Patient $patient)
    {
        if (!$patient->photo) {
            abort(404);
        }

        return response()->download(storage_path() . '/app/' . $patient->photo, null, [], null);
    }

    public function clinicsMe()
    {
        return $this->clinics(Auth::user());
    }

    public function clinics(Patient $patient)
    {
        return $this->responseAsJson($patient->clinics, 200, Clinic::transformer());
    }

    public function clinicMe(Clinic $clinic)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        if (!$patient->clinics->contains($clinic->id)) {
            return $this->responseAsJson(['message' => 'You can\'t access to the information of this clinic'], 403);
        }

        $clinic->last_visit = $patient->lastVisitInClinic($clinic)->with('dentist')->first();

        return $this->responseAsJson($clinic, 200, Clinic::transformer());
    }

    public function information(Request $request)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $patient->informations()->create(['information' => $request->get('information')]);

        return $this->responseAsJson([], 201);
    }
    
    public function notifications()
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $notifications = $patient->notificationsSent()->with('scheduled')->get();

        return $this->responseAsJson($notifications, 200, NotificationSent::transformer());
    }
}
