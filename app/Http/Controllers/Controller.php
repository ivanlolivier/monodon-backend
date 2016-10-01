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

    protected $transformer;

    protected function prepareResponse($result, $transformer = null)
    {
        if (is_null($transformer)) {
            $transformer = $this->transformer;
        }

        if ($result instanceof Collection) {
            return fractal()
                ->collection($result)
                ->transformWith($transformer)
                ->toArray();
        }

        return fractal()
            ->item($result)
            ->transformWith($transformer)
            ->toArray();
    }

}
