<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationController extends _Controller
{
    public function answer_types()
    {
        return [
            ['code' => 'YES-NO'],
            ['code' => 'OK'],
            ['code' => 'RANGE'],
        ];
    }
}
