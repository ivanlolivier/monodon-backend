<?php

namespace App\Http\Controllers;

use App\Models\PredefinedDiagnosis;

class DiagnosisTypesController extends _Controller
{
    public function index()
    {
        $diagnosis_types = PredefinedDiagnosis::all();

        return $this->responseAsJson($diagnosis_types, 200, PredefinedDiagnosis::transformer());
    }
}
