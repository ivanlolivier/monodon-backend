<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
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

    public function updateMe(Request $request)
    {
        return $this->update(Auth::user(), $request);
    }

    public function update(Employee $employee, Request $request)
    {
        $employee->fill($request->all());

        $employee->save();

        return $this->responseAsJson($employee);
    }
}
