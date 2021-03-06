<?php

namespace App\Http\Requests;

class UpdateTopicSubscriptionRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'         => ['required'],
            'surname'      => ['required'],
            'affiliate_id' => ['required'],
            'email'        => ['required', 'email'],
            'phones'       => ['array'],
            'sex'          => ['required', 'in:male,female'],
        ];
    }
}
