<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DentistController extends _Controller
{
    public function __construct()
    {
        $this->transformer = Dentist::transformer();
    }

    public function me()
    {
        $this->authorize('me', Dentist::class);

        /** @var Dentist $dentist */
        $dentist = Auth::user();

        $dentist->load('clinics');

        return $this->responseAsJson($dentist, 200, Dentist::transformer());
    }

    public function clinics()
    {
        $this->authorize('clinics', Dentist::class);

        /** @var Dentist $dentist */
        $dentist = Auth::user();

        $clinics = $dentist->clinics()->get();

        return $this->responseAsJson($clinics, 200, Clinic::transformer());
    }

    public function appointments()
    {
        /** @var Dentist $dentist */
        $dentist = Auth::user();

        $clinic_id = request()->header('CLINIC-ID');

        $appointments = $dentist->appointments()->with('patient')->where('clinic_id', $clinic_id)->get();

        return $this->responseAsJson($appointments, 200, Appointment::transformer());
    }

    public function updateMe(Request $request)
    {
        return $this->update(Auth::user(), $request);
    }

    public function update(Dentist $dentist, Request $request)
    {
        $dentist->fill($request->all());

        $dentist->save();

        return $this->responseAsJson($dentist);
    }
}
