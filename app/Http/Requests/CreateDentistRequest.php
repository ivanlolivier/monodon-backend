<?php

namespace App\Http\Requests;

class CreateDentistRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'         => ['required'],
            'surname'      => ['required'],
            'affiliate_id' => ['required', 'exists:dentists,affiliate_id,!0'],
            'email'        => ['required', 'email'],
            'password'     => ['required'],
            'phones'       => ['array'],
            'sex'          => ['required', 'in:male,female'],
        ];
    }
}
