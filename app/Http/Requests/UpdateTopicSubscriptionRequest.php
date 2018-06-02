<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicSubscriptionRequest extends FormRequest
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
            'name'         => ['required'],
            'surname'      => ['required'],
            'affiliate_id' => ['required'],
            'email'        => ['required', 'email'],
            'phones'       => ['array'],
            'sex'          => ['required', 'in:male,female'],
        ];
    }
}