<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClinic;
use App\Models\Clinic;

class ClinicController extends Controller
{
    public function __construct()
    {
        $this->transformer = Clinic::transformer();
    }

    public function show(Clinic $clinic)
    {
        return $this->responseAsJson($clinic);
    }

    public function store(StoreClinic $request)
    {
        $clinic = Clinic::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        return $this->responseAsJson($clinic, 201);
    }

    public function update(Clinic $clinic, StoreClinic $request)
    {
        $clinic->fill([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        $clinic->update();

        return $this->responseAsJson($clinic);
    }

}
