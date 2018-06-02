<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => ['required'],
            'description' => [],
            'date'        => ['required', 'date_format:Y-m-d', 'after:today'],
            'time'        => ['required', 'date_format:H:i'],
            'duration'    => ['required', 'integer', 'min:1'],
            'dentist_id'  => ['required', 'exists:dentists,id'],
            'patient_id'  => ['required', 'exists:patients,id'],

        ];
    }
}
