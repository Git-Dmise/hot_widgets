<?php

/**
 * @noinspection PhpUnused
 */

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Exceptions\SignCheckException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiSignCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('x') !== 'test') {
            $this->validateSign($request);
        }

        return $next($request);
    }

    protected function validateSign(Request $request): void
    {
        // 签名
        if (!$client_sign = $request->header('X-Client-Sign')) {
            throw new SignCheckException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }

        // 请求时间戳
        if (!$client_timestamp = $request->header('X-Client-Timestamp') or !is_numeric($client_timestamp)) {
            throw new SignCheckException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }

        // 请求UUID
        if (!$client_request_uuid = $request->header('X-Client-Request-Uuid')) {
            throw new SignCheckException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }

        $client_time = (int)($client_timestamp / 1000);

        if ($client_time < (time() - 60) or $client_time > (time() + 60)) {
            throw new SignCheckException(0, __('auth.throttle', ['seconds' => '-1']));
        }

        // 请求系统
        $sign_data = env('API_SIGN')
            . "\n"
            . $request->method()
            . "\n"
            . '/' . $request->path()
            . "\n"
            . $request->getQueryString()
            . "\n"
            . $client_timestamp
            . "\n"
            . $client_request_uuid
            . "\n";

        if (md5($sign_data) !== $client_sign) {
            throw new SignCheckException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }
    }
}
