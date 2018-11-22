<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Patient;
use App\Models\Message;
use Illuminate\Http\Request;

class AppointmentController extends _Controller
{
    public function listForClinic(Clinic $clinic, Request $request)
    {
        $this->authorize('listForClinic', [Appointment::class, $clinic]);


        $appointments = $clinic->appointments()
            ->with('dentist')
            ->with('patient');

        if ($from = $request->input('from', false)) {
            $appointments = $appointments->where('datetime', '>=', date($from));
        }
        if ($to = $request->input('to', false)) {
            $appointments = $appointments->where('datetime', '<=', date($to));
        }
        if ($take = $request->input('take', false)) {
            $appointments = $appointments->take($take);
        }
        if ($skip = $request->input('skip', false)) {
            $appointments = $appointments->skip($skip);
        }

        $appointments = $appointments->orderBy('datetime', 'asc')->get();


        return $this->responseAsJson($appointments, 200, Appointment::transformer());
    }

    public function createForClinic(Clinic $clinic, CreateAppointmentRequest $request)
    {
        $this->authorize('createForClinic', [Appointment::class, $clinic]);

        /** @var Dentist $dentist */
        $dentist = Dentist::find($request->get('dentist_id'));
        if (!$dentist->worksOn($clinic)) {
            return response()->json(['dentist_id' => 'This dentist does not work on this clinic.'], 422);
        }

        /** @var Patient $patient */
        $patient = Patient::find($request->get('patient_id'));
        if (!$patient->isSeenAt($clinic)) {
            return response()->json(['patient_id' => 'This patient is not seen at this clinic.'], 422);
        }

        //TODO: Control that the dentist and the patient are free at the time of the appointment

        $appointment = new Appointment([
            'title'       => $request->get('title'),
            'description' => $request->get('description'),
            'datetime'    => $request->get('date') . ' ' . $request->get('time') . ':00',
            'duration'    => $request->get('duration'),
        ]);
        $appointment->dentist_id = $request->get('dentist_id');
        $appointment->patient_id = $request->get('patient_id');

        $clinic->appointments()->save($appointment);

        setlocale(LC_TIME, 'Spanish');

        $message = new Message([
            'title'        => 'Nueva cita agendada',
            'message'      => "Tienes una nueva cita agendada con el dentista {$dentist->name} para el día {$appointment->datetime->format('l jS \\d\\e F \\a \\l\\a\\s H:i \\h\\s')}",
            'is_broadcast' => false
        ]);
        $message->employee_id = $request->user()->id;

        /** @var Message $message */
        $message = $clinic->messages()->save($message);
        $message->patients()->attach($patient->id);

        $message->send('appointment');

        return $this->responseAsJson($appointment, 201, Appointment::transformer());
    }

    public function updateForClinic(Clinic $clinic, Appointment $appointment, CreateAppointmentRequest $request)
    {
        $this->authorize('updateForClinic', [$appointment, $clinic]);

        /** @var Dentist $dentist */
        if ($request->get('dentist_id') != $appointment->dentist_id) {
            $dentist = Dentist::find($request->get('dentist_id'));
            if (!$dentist->worksOn($clinic)) {
                return response()->json(['dentist_id' => 'This dentist does not work on this clinic.'], 422);
            }
        }

        /** @var Patient $patient */
        if ($request->get('patient_id') != $appointment->patient_id) {
            $patient = Patient::find($request->get('patient_id'));
            if (!$patient->isSeenAt($clinic)) {
                return response()->json(['patient_id' => 'This patient is not seen at this clinic.'], 422);
            }
        }

        $appointment->fill([
            'title'       => $request->get('title'),
            'description' => $request->get('description'),
            'datetime'    => $request->get('date') . ' ' . $request->get('time') . ':00',
            'duration'    => $request->get('duration'),
        ]);
        $appointment->dentist_id = $request->get('dentist_id');
        $appointment->patient_id = $request->get('patient_id');

        $appointment->save();

        return $this->responseAsJson($appointment, 200, Appointment::transformer());
    }

    public function deleteForClinic(Clinic $clinic, Appointment $appointment)
    {
        $this->authorize('deleteForClinic', [$appointment, $clinic]);

        $appointment->delete();

        return $this->responseAsJson([], 204);
    }
}
