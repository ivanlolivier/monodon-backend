<?php

namespace App\Http\Requests;

class CreatePatientRequest extends BaseRequest
{
    public function rules()
    {
        return [
            "email"         => ['required', 'email'],
            "name"          => ['required', 'string'],
            "surname"       => ['required', 'string'],
            "document_type" => ['required', 'in:passport,identity_document,driver_license'],
            "document"      => ['required'],
            "birthdate"     => ['required', 'date'],
            "phones"        => ['required', 'array'],
            "sex"           => ['required', 'in:male,female'],
            "photo"         => [],
            "tags"          => ['array'],
        ];
    }
}
