<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use DB;

class EmployeeController extends _Controller
{
    public function __construct()
    {
        $this->transformer = Employee::transformer();
    }

    public function showMe()
    {
        return $this->show(Auth::user());
    }

    public function show(Employee $employee)
    {
        $employee->load('clinic');
        $employee->load('type');

        return $this->responseAsJson($employee);
    }
}
