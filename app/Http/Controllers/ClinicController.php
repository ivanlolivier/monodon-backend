<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CanUploadFiles;
use App\Http\Requests\StoreClinic;
use App\Mail\InvitationForDentistToJoinClinic;
use App\Mail\InvitationForDentistToRegisterAndJoinClinic;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Invitation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ClinicController extends _Controller
{
    use CanUploadFiles;

    const STORAGE_PATH = '/clinics';
    const STORAGE_DISC = 'public';

    public function __construct()
    {
        $this->transformer = Clinic::transformer();
    }

    /**
     * Shows clinic
     *
     * Shows the information of a clinic specified by id
     *
     * @param Clinic $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Clinic $clinic)
    {
        $this->authorize('show', $clinic);

        return $this->responseAsJson($clinic);
    }

    /**
     * Creates clinic
     *
     * Creates a new clinic
     *
     * @param StoreClinic $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClinic $request)
    {
        $clinic = Clinic::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        return $this->responseAsJson($clinic, 201);
    }

    /**
     * Updates a clinic
     *
     * Updates a clinic
     *
     * @param Clinic $clinic
     * @param StoreClinic $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Clinic $clinic, StoreClinic $request)
    {
        $this->authorize('update', $clinic);

        $clinic->fill([
            'name'    => $request->get('name', null),
            'address' => $request->get('address', null),
            'phones'  => implode(';', $request->get('phones', [])),
            'email'   => $request->get('email', null)
        ]);

        if ($base64_logo = $request->get('logo', false)) {
            $logo = base64_decode($base64_logo, true);

            if ($logo !== false) {
                $disk = Storage::disk(self::STORAGE_DISC);

                if ($clinic->logo && $disk->exists($clinic->logo)) {
                    $disk->delete($clinic->logo);
                }

                $filename = $clinic->id . '-' . time() . '.jpg';

                $clinic->logo = $this->saveFile($filename, $logo);
            }
        }

        $clinic->update();

        return $this->responseAsJson($clinic);
    }

    public function patients(Clinic $clinic)
    {
        $this->authorize('patients', $clinic);

        $patients = $clinic->patients()->get();

        return $this->responseAsJson($patients, 200, Patient::transformer());
    }

    public function dentists(Clinic $clinic)
    {
        $this->authorize('dentists', $clinic);

        $dentists = $clinic->dentists()->get();

        return $this->responseAsJson($dentists, 200, Dentist::transformer());
    }

    public function sendInvitationToDentist(Clinic $clinic, Request $request)
    {
        $this->authorize('invite_dentist', $clinic);

        $this->validate($request, [
            'email' => ['required']
        ]);

        $invitation = new Invitation(['email' => $request->get('email')]);
        $invitation->clinic()->associate($clinic);
        $invitation->employee()->associate($request->user());
        $invitation->generateToken();
        $invitation->save();

        $dentist = Dentist::where('email', $request->get('email'));

        $email = $dentist->exists() ?
            new InvitationForDentistToJoinClinic($invitation, $clinic, $request->user(), $dentist) :
            new InvitationForDentistToRegisterAndJoinClinic($invitation, $clinic, $request->user());

        Mail::to($request->get('email'))->send($email);

        return $this->responseAsJson([], 201);
    }

}
