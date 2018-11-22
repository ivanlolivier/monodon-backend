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
//        $this->authorize('me', dentist::class);

        $dentist = Auth::user();
        $visit = visit::find($request->visitId);

        $visit->dentist = $dentist;
        $visit->patient = $patient;

        $cda = (new cda)->generateforvisit($visit);

        return response()->json($cda, 201);
    }
}
