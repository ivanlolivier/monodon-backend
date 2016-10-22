<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->transformer = Patient::transformer();
    }

    public function show()
    {
        return $this->responseAsJson(Auth::user());
    }
}
