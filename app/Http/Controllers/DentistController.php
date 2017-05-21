<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Clinic;
use App\Models\Dentist;
use Illuminate\Support\Facades\Auth;

class DentistController extends _Controller
{
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
}
