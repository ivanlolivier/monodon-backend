<?php

namespace App\Http\Controllers;

use App\Model\Clinic;

class ClinicController extends Controller
{
    public function show(Clinic $clinic)
    {
        return $this->response($clinic, Clinic::transformer());

//        return fractal()
//            ->item($clinic, Clinic::transformer())
//            ->toJson();
    }

}
