<?php

namespace App\Http\Requests;

class StorePatientRequest extends BaseRequest
{
    public function rules()
    {
        return [
            "name"            => ['required'],
            "surname"         => ['required'],
            "document"        => ['array'],
            "document.type"   => ['in:passport,identity_document,driver_license'],
            "document.number" => [],
            "birthdate"       => ['required'],
            "sex"             => ['required', 'in:male,female'],
            "photo"           => [],
            "phones"          => ['array'],
            "email"           => ['email'],
            "tags"            => ['array'],
        ];
    }
}
