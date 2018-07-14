<?php

namespace App\Http\Requests;

class GenerateCdaRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'visitId' => ['exists:visits,id'],
        ];
    }
}
