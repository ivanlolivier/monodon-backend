<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends _Controller
{
    public function show(Appointment $appointment)
    {
//        $this->authorize('show', $appointment);

        return $this->responseAsJson($appointment, 200, Appointment::transformer());
    }

//    public function showForClinic(Clinic $clinic, Appointment $appointment)
//    {
//        return $this->show($appointment);
//    }

    public function listForClinic(Clinic $clinic)
    {
        $this->authorize('listForClinic', [Appointment::class, $clinic]);

        $appointments = $clinic->appointments()->get();

        return $this->responseAsJson($appointments, 200, Appointment::transformer());
    }

    public function createForClinic(Clinic $clinic, Request $request)
    {
        $this->authorize('createForClinic', [Appointment::class, $clinic]);

        $this->validate($request, [
            'title'       => ['required'],
            'description' => [],
            'datetime'    => ['required', 'date'],
            'dentist_id'  => ['required', 'exists:dentists,id'],
            'patient_id'  => ['required', 'exists:patients,id'],
        ]);

        /** @var Dentist $dentist */
        $dentist = Dentist::find($request->get('dentist_id'));
        if (!$dentist->worksOn($clinic)) {
            return response()->json([
                'dentist_id' => 'This dentist does not work on this clinic.'
            ], 422);
        }

        /** @var Patient $patient */
        $patient = Patient::find($request->get('patient_id'));
        if (!$patient->isSeenAt($clinic)) {
            return response()->json([
                'dentist_id' => 'This patient is not seen at this clinic.'
            ], 422);
        }

//        if ($dentist->)

        $appointment = new Appointment($request->only('title', 'description', 'datetime'));
        $appointment->dentist_id = $request->get('dentist_id');
        $appointment->patient_id = $request->get('patient_id');

        $clinic->appointments()->save($appointment);
    }
}
