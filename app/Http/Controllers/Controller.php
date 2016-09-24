<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response($result, $transformer)
    {
        if ($result instanceof Collection) {
            return fractal()
                ->collection($result, $transformer)
                ->toJson();
        }

        return fractal()
            ->item($result, $transformer)
            ->toJson();
    }

}
