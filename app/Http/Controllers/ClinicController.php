<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClinic;
use App\Model\Clinic;
use App\Transformers\ClinicTransformer;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function __construct()
    {
        $this->transformer = Clinic::transformer();
    }

    public function show(Clinic $clinic)
    {
        return response()->json($this->prepareResponse($clinic));
    }

    public function store(StoreClinic $request)
    {
        $clinic = Clinic::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        return response()->json($this->prepareResponse($clinic), 201);
    }

    public function update(Clinic $clinic, StoreClinic $request)
    {
        $clinic->fill([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        $clinic->update();

        return response()->json($this->prepareResponse($clinic));
    }

}
