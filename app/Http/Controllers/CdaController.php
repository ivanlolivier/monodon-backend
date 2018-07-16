<?php

namespace App\Http\Controllers;

use App\Models\CDA;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GenerateCdaRequest;
use App\Models\Patient;
use App\Models\Visit;

class CdaController extends _Controller
{
    public function generate(Patient $patient, GenerateCdaRequest $request)
    {
//        $this->authorize('me', Dentist::class);

        $dentist = Auth::user();
        $visit = Visit::find($request->visitId);

        $visit->dentist = $dentist;
        $visit->patient = $patient;

        $cda = (new CDA)->generateForVisit($visit);

        return response()->json($cda, 201);
    }
}
