<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class _Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $transformer;

    const STORAGE_PATH = '/';
    const STORAGE_DISC = 'public';

    protected function responseAsJson($result, $code = 200, $transformer = null)
    {
        $response_formated = $this->prepareResponse($result, $transformer);

        return response()->json($response_formated, $code);
    }

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

    protected function saveFile($filename, $file)
    {
        $file_path = self::STORAGE_PATH . '/' . $filename;

        $disk = Storage::disk(self::STORAGE_DISC);
        $disk->put($file_path, $file);

        return $file_path;
    }

}
