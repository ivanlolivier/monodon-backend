<?php

namespace App\Http\Requests;

class CreateAppointmentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title'       => [],
            'description' => [],
            'date'        => ['required', 'date_format:Y-m-d', 'after:today'],
            'time'        => ['required', 'date_format:H:i'],
            'duration'    => ['required', 'integer', 'min:1'],
            'dentist_id'  => ['required', 'exists:dentists,id'],
            'patient_id'  => ['required', 'exists:patients,id'],
        
        ];
    }
}
