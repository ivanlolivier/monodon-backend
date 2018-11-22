<?php

namespace App\Http\Requests;

class GenerateCdaRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'type'    => ['in:visit'],
            'visitId' => ['exists:visits,id'],
        ];
    }
}
