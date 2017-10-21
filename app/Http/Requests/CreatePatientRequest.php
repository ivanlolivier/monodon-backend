<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
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
            "email"         => ['required', 'email'],
            "name"          => ['required', 'string'],
            "surname"       => ['required', 'string'],
            "document_type" => ['required', 'in:passport,identity_document,driver_license'],
            "document"      => ['required'],
            "birthdate"     => ['required', 'date'],
            "sex"           => ['required', 'in:male,female'],
            "photo"         => [],
            "tags"          => ['array'],
        ];
    }
}
