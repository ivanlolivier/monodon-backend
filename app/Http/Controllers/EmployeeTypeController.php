<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\EmployeeType;

class EmployeeTypeController extends _Controller
{
    public function index()
    {
        $employee_types = EmployeeType::all();

        return $this->responseAsJson($employee_types, 200, EmployeeType::transformer());
    }
}
