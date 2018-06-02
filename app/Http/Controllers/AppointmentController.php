<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Patient;
use App\Models\Message;
use Illuminate\Http\Request;

class AppointmentController extends _Controller
{
    public function listForClinic(Clinic $clinic)
    {
        $this->authorize('listForClinic', [Appointment::class, $clinic]);

        $appointments = $clinic->appointments()
            ->with('dentist')
            ->with('patient')
            ->get();

        return $this->responseAsJson($appointments, 200, Appointment::transformer());
    }

    public function createForClinic(Clinic $clinic, Request $request)
    {
        $this->authorize('createForClinic', [Appointment::class, $clinic]);

        $this->validate($request, [
            'title'       => ['required'],
            'description' => [],
            'date'        => ['required', 'date_format:Y-m-d', 'after:today'],
            'time'        => ['required', 'date_format:H:i'],
            'duration'    => ['required', 'integer', 'min:1'],
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
                'patient_id' => 'This patient is not seen at this clinic.'
            ], 422);
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

    public function updateForClinic(Clinic $clinic, Appointment $appointment, Request $request)
    {
        $this->authorize('updateForClinic', [$appointment, $clinic]);

        $this->validate($request, [
            'title'       => ['required'],
            'description' => [],
            'datetime'    => ['required', 'date'],
            'dentist_id'  => ['required', 'exists:dentists,id'],
            'patient_id'  => ['required', 'exists:patients,id'],
        ]);

        /** @var Dentist $dentist */
        if ($request->get('dentist_id') != $appointment->dentist_id) {
            $dentist = Dentist::find($request->get('dentist_id'));
            if (!$dentist->worksOn($clinic)) {
                return response()->json([
                    'dentist_id' => 'This dentist does not work on this clinic.'
                ], 422);
            }
        }

        /** @var Patient $patient */
        if ($request->get('patient_id') != $appointment->patient_id) {
            $patient = Patient::find($request->get('patient_id'));
            if (!$patient->isSeenAt($clinic)) {
                return response()->json([
                    'patient_id' => 'This patient is not seen at this clinic.'
                ], 422);
            }
        }

        $appointment->fill($request->only('title', 'description', 'datetime'));
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
