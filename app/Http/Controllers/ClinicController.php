<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CanUploadFiles;
use App\Http\Requests\CreateDentistRequest;
use App\Http\Requests\StoreClinicRequest;
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

    public function show(Clinic $clinic)
    {
        $this->authorize('show', $clinic);

        return $this->responseAsJson($clinic);
    }

    public function store(StoreClinicRequest $request)
    {
        $clinic = Clinic::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        return $this->responseAsJson($clinic, 201);
    }

    public function update(Clinic $clinic, StoreClinicRequest $request)
    {
        $this->authorize('update', $clinic);

        $coordinates = $request->get('coordinates', false);

        $clinic->fill([
            'name'      => $request->get('name', null),
            'address'   => $request->get('address', null),
            'phones'    => $request->get('phones', ''),
            'email'     => $request->get('email', null),
            'latitude'  => $coordinates ? $coordinates['latitude'] : null,
            'longitude' => $coordinates ? $coordinates['longitude'] : null
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

    public function invitations(Clinic $clinic)
    {
        $this->authorize('see_invitations', $clinic);

        $invitations = $clinic->invitations()->where('accepted', '!=', true)->get();

        return $this->responseAsJson($invitations, 200, Invitation::transformer());
    }

    public function updateInvitation(Clinic $clinic, $token, Request $request)
    {
        if (!$token) {
            return $this->responseAsJson(['errors' => 'TOKEN_IS_MANDATORY'], 400);
        }

        /** @var Invitation $invitation */
        if (!$invitation = $clinic->invitations()->where('token', $token)->first()) {
            return $this->responseAsJson(['errors' => 'INVALID_TOKEN'], 403);
        }

        if ($request->get('status') == 'reject') {
            $invitation->reject();
        }

        return $this->responseAsJson($invitation, 200, Invitation::transformer());
    }

    public function invitation(Clinic $clinic, $token)
    {
        if (!$token) {
            return $this->responseAsJson(['errors' => 'TOKEN_IS_MANDATORY'], 400);
        }

        /** @var Invitation $invitation */
        if (!$invitation = $clinic->invitations()->where('token', $token)->first()) {
            return $this->responseAsJson(['errors' => 'INVALID_TOKEN'], 403);
        }

        $invitation->load('clinic')->load('dentist')->load('employee');

        return $this->responseAsJson($invitation, 200, Invitation::transformer());
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

        $email = new InvitationForDentistToRegisterAndJoinClinic($invitation, $clinic, $request->user());

        if ($dentist->exists()) {
            /** @var Dentist $dentist */
            $dentist = $dentist->first();

            if ($dentist->worksOn($clinic)) {
                return $this->responseAsJson(['errors' => 'DENTIST_ALREADY_WORKS_IN_CLINIC'], 400);
            }

            $invitation->dentist()->associate($dentist);
            $invitation->save();

            $email = new InvitationForDentistToJoinClinic($invitation, $clinic, $request->user(), $dentist);
        }


        Mail::to($request->get('email'))->send($email);

        return $this->responseAsJson([], 201);
    }

    public function linkDentist(Clinic $clinic, Request $request)
    {
        if (!$token = $request->headers->get('MONODON-INVITATION-TOKEN')) {
            return $this->responseAsJson(['errors' => 'TOKEN_IS_MANDATORY'], 400);
        }

        /** @var Invitation $invitation */
        if (!$invitation = $clinic->invitations()->where('token', $token)->first()) {
            return $this->responseAsJson(['errors' => 'INVALID_TOKEN'], 403);
        }

        //        if ($request->get('dentist') != $invitation->dentist_id) {
        //            return $this->responseAsJson(['errors' => 'INVALID_DENTIST_ID'], 400);
        //        }

        $clinic->dentists()->attach($invitation->dentist_id);

        $invitation->accept();

        return $this->responseAsJson([]);
    }

    public function registerDentistAndJoinClinic(Clinic $clinic, CreateDentistRequest $request)
    {
        if (!$token = $request->headers->get('MONODON-INVITATION-TOKEN')) {
            return $this->responseAsJson(['errors' => 'TOKEN_IS_MANDATORY'], 400);
        }

        /** @var Invitation $invitation */
        if (!$invitation = $clinic->invitations()->where('token', $token)->first()) {
            return $this->responseAsJson(['errors' => 'INVALID_TOKEN'], 403);
        }

        $dentist = Dentist::create($request->all());
        $dentist->auth()->create($request->only(['email', 'password']));

        $clinic->dentists()->attach($dentist->id);

        $invitation->accept();

        return $this->responseAsJson($dentist, 201, Dentist::transformer());
    }

}
