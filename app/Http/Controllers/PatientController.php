<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatient;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientController extends _Controller
{
    public function __construct()
    {
        $this->transformer = Patient::transformer();
    }

    /**
     * Show patient (me)
     *
     * Shows logged patient's info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->responseAsJson(Auth::user());
    }

    /**
     * Show patient
     *
     * Shows a patient info specified by id
     *
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Patient $patient)
    {
        return $this->responseAsJson($patient);
    }

    /**
     * Creates patient
     *
     * Creates a new patient
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatient $request)
    {
        $patient = Patient::create($request->all());

        return $this->responseAsJson($patient, 201);
    }

    /**
     * Updates patient (me)
     *
     * Updates the information of the patient logged
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMe(StorePatient $request)
    {
        return $this->update(Auth::user(), $request);
    }

    /**
     * Updates patient
     *
     * Updates a patient's info specified by id
     *
     * @param Patient $patient
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Patient $patient, StorePatient $request)
    {
        $patient->fill(array_merge($request->all(), [
            'document_type' => $request->document['type'],
            'document'      => $request->document['number'],
            'phones'        => implode(';', $request->get('phones')),
            'tags'          => implode(';', $request->get('tags')),
        ]));
        $patient->update();

        return $this->responseAsJson($patient);
    }
}
