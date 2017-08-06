<?php

namespace App\Http\Controllers;

use App\Models\BuccalZone;

use App\Http\Requests;

class BuccalZoneController extends _Controller
{
    public function index()
    {
        $buccal_zones = BuccalZone::all();

        return $this->responseAsJson($buccal_zones, 200, BuccalZone::transformer());
    }
}
