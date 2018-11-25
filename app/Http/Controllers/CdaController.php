<?php

namespace App\Http\Controllers;

use App\Models\CDA;
use App\Http\Requests\GenerateCdaRequest;
use App\Models\Patient;
use App\Models\Visit;

class CdaController extends _Controller
{
    public function generate(Patient $patient, GenerateCdaRequest $request)
    {
//        $this->authorize('me', dentist::class);

        $visit = Visit::with('dentist')->with('patient')->find($request->visitId);

        $visit->dentist = $visit->dentist;
        $visit->patient = $visit->patient;

        $cda = (new cda)->generateforvisit($visit);

        return response()->json($cda, 201);
    }
}
