<?php

/**
 * @noinspection PhpUnused
 */

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
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
            // 使用[]传参
            throw new ApiException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }

        // 请求时间戳
        if (!$client_timestamp = $request->header('X-Client-Timestamp') or !is_numeric($client_timestamp)) {
            throw new ApiException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }

        // 请求UUID
        if (!$client_request_uuid = $request->header('X-Client-Request-Uuid')) {
            throw new ApiException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }

        /*

        $client_time = (int)($client_timestamp / 1000);

        if ($client_time < (time() - 60) or $client_time > (time() + 60)) {
            throw new ApiException(0, __('auth.throttle', ['seconds' => '-1']));
        }

        */

        $api_sign_config = config('chatgai.api_sign');

        // 请求系统
        $sign_data = match ($request->header('X-Client-System')) {
                'iwatchos' => $api_sign_config['iwatchos_key'],
                'android' => $api_sign_config['android_key'],
                default => $api_sign_config['web_key'],
                'ios' => $api_sign_config['ios_key'],
            }
            . "\n"
            . $request->method()
            . "\n"
            . '/' . $request->path() . (match ($request->header('X-Client-System')) {
                default => !empty($request->getQueryString()) ? "?{$request->getQueryString()}" : '',
                'ios', 'android', 'iwatchos' => '',
            })
            . "\n"
            . $client_timestamp
            . "\n"
            . $client_request_uuid
            . "\n"
            . $request->getContent()
            . "\n";

        if (md5($sign_data) !== $client_sign) {
            throw new ApiException(0, 'Too many request attempts. Please try again in -1 seconds.');
        }
    }
}
