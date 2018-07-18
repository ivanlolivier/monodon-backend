<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

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
        $formatter = new LineFormatter(null, null, // Datetime format
            true, // allowInlineLineBreaks option, default false
            true  // ignoreEmptyContextAndExtra option, default false
        );
        $debugHandler = new StreamHandler(storage_path('logs/' . $logName), Logger::INFO);
        $debugHandler->setFormatter($formatter);
        $log->pushHandler($debugHandler);
        
        if ($request->headers->has('authorization')) {
            $request->headers->set('authorization', 'hidden');
        }
        
        $request_body_to_log = $request->except(['image', 'photo', 'logo', 'password', 'password_confirmation']);
        
        $log->info($request->method() . ' ' . $request->url() . ' (' . $request->ip() . ')' . $this->array_to_string([
                '====request===='  => $this->array_to_string([
                    'method'  => $request->method(),
                    'url'     => $request->url(),
                    'ip'      => $request->ip(),
                    'body'    => $request_body_to_log ? $this->array_to_string($request_body_to_log) : '<empty>',
                    'headers' => "\n" . $request->headers
                ]),
                '====response====' => $this->array_to_string([
                    'statusCode' => $response->getStatusCode(),
                    'body'       => $response->getContent(),
                    'headers'    => $response->headers
                ])
            ]));
    }
    
    private function array_to_string($input)
    {
        return "\n" . implode("\n", array_map(function ($v, $k) {
                if (is_array($v)) {
                    $v = $this->array_to_string($v);
                }
                return sprintf("%s = %s", $k, $v);
            }, $input, array_keys($input)));
    }
}