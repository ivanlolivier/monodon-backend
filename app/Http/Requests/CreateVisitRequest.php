<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateVisitRequest extends FormRequest
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
            'clinic'                         => ['required', 'exists:clinics,id'],
            'exploratory'                    => ['string'],
            'interrogatory'                  => ['required', 'array'],
            'interrogatory.*.question'       => ['distinct', 'exists:questions,id'],
            'interrogatory.*.answer'         => ['boolean'],
            'diagnosis'                      => ['required'],
            'diagnosis.type'                 => ['required', 'in:healthy,incomplete,treatment,derivation'],
            'diagnosis.description'          => ['string'],
            'diagnosis.contact'              => ['required_if:diagnosis.type,derivation'],
            'diagnosis.contact.name'         => ['required_if:diagnosis.type,derivation'],
            'diagnosis.contact.email'        => ['email'],
            'diagnosis.contact.phone'        => ['required_if:diagnosis.type,derivation'],
            'diagnosis.derivation_reason'    => ['required_if:diagnosis.type,derivation'],
            'indications'                    => ['array'],
            'indications.*.title'            => ['required', 'string'],
            'indications.*.message'          => ['required', 'string'],
            'indications.*.type'             => ['required', 'in:single,daily,weekly,monthly'],
            'indications.*.possible_answers' => ['required', 'in:YES-NO,OK,RANGE'],
            'indications.*.time_to_send'     => ['date_format:H:i'],
            'indications.*.start_sending'    => ['date'],
            'indications.*.finish_sending'   => ['date', 'required_unless:indications.*.type,single'],
            'indications.*.periodicity'      => ['array', 'required_unless:indications.*.type,single'],
            'indications.*.periodicity.*'    => ['integer'],
        ];
    }
}
