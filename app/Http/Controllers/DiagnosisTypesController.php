<?php

namespace App\Http\Controllers;

use App\Models\DiagnosisType;

class DiagnosisTypesController extends _Controller
{
    public function index()
    {
        $diagnosis_types = DiagnosisType::all();

        return $this->responseAsJson($diagnosis_types, 200, DiagnosisType::transformer());
    }
}
