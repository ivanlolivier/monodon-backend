<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;

use App\Http\Requests;

class TreatmentController extends _Controller
{
    public function index()
    {
        $this->authorize('index', Treatment::class);

        $treatments = Treatment::all();

        return $this->responseAsJson($treatments, 200, Treatment::transformer());
    }
}
