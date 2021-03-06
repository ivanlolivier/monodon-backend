<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateVisitRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'clinic'                         => ['required', 'exists:clinics,id'],
            'exploratory'                    => ['string'],
            'interrogatory'                  => ['required', 'array'],
            'interrogatory.*.question'       => ['distinct', 'exists:questions,id'],
            'interrogatory.*.answer'         => ['boolean'],
            'diagnosis'                      => ['required'],
            'diagnosis.description'          => ['string'],
            'diagnosis.type'                 => ['required', 'in:healthy,incomplete,predefined,derivation'],
            'diagnosis.predefined'           => ['required_if:diagnosis.type,predefined', 'array'],
            'diagnosis.predefined.*'         => ['exists:predefined_diagnosis,id'],
            'diagnosis.contact'              => ['required_if:diagnosis.type,derivation'],
            'diagnosis.contact.name'         => ['required_if:diagnosis.type,derivation'],
            'diagnosis.contact.phone'        => ['required_if:diagnosis.type,derivation'],
            'diagnosis.derivation_reason'    => ['required_if:diagnosis.type,derivation'],
            'diagnosis.contact.email'        => ['email'],
            'treatments'                     => ['required_if:diagnosis.type,treatment', 'array'],
            'treatments.*.buccal_zone'       => ['required_if:diagnosis.type,treatment', 'exists:buccal_zones,id'],
            'treatments.*.treatment'         => ['required_if:diagnosis.type,treatment', 'exists:treatments,id'],
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
