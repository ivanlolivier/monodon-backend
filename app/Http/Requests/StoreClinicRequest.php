<?php

namespace App\Http\Requests;

class StoreClinicRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'                  => ['required', 'max:255'],
            'address'               => ['required', 'max:255'],
            'phones'                => ['array'],
            'email'                 => ['email'],
            'coordinates.latitude'  => [
                'required_with:coordinates.longitude',
                'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'
            ],
            'coordinates.longitude' => [
                'required_with:coordinates.latitude',
                'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'
            ]
        ];
    }
}
