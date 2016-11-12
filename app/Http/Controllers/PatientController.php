<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CanUploadFiles;
use App\Http\Requests\StorePatient;
use App\Models\Patient;
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
}
