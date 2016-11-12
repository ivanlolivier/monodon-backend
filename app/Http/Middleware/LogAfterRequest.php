<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class LogAfterRequest
 * @package App\Http\Middleware
 */
class LogAfterRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param $response
     */
    public function terminate(Request $request, $response)
    {
        $logName = Carbon::now()->format('Y-m-d') . '_api_requests.log';

        $log = new Logger('ApiRequests');
        $log->pushHandler(new StreamHandler(storage_path('logs/' . $logName), Logger::INFO));

        $log->info('app.request', [
            'request'  => [
                'body'    => $request->except(['image', 'photo', 'password', 'password_confirmation']),
                'method'  => $request->method(),
                'url'     => $request->url(),
                'headers' => $request->headers
            ],
            'response' => [
                'body'       => json_decode($response->getContent(), true),
                'statusCode' => $response->getStatusCode(),
                'headers'    => $response->headers
            ]
        ]);
    }
}