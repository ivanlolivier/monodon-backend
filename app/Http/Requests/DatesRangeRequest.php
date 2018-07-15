<?php

namespace App\Http\Requests;

class DatesRangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            "from" => ['required', 'date'],
            "to"   => ['required', 'date'],
        ];
    }
}
