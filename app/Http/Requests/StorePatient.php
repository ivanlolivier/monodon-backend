<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatient extends FormRequest
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
            "name"            => ['required'],
            "surname"         => ['required'],
            "document.type"   => ['required', 'in:passport,identity_document,driver_license'],
            "document.number" => ['required'],
            "birthdate"       => ['required'],
            "sex"             => ['required', 'in:male,female'],
            "photo"           => [],
            "phones"          => ['array'],
            "email"           => ['email'],
            "tags"            => ['array'],
        ];
    }
}
