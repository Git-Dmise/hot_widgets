<?php

use App\Exceptions\ApiException;
use App\Http\Middleware\ApiSignCheck;
use App\Http\Middleware\SetLocale;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            SetLocale::class
        ]);
        $middleware->alias([
            'api.sign.check' => ApiSignCheck::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'statusCode' => 401,
                'success' => false,
            ], 401);
        });

        $exceptions->renderable(function (ApiException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'statusCode' => $exception->getApiCode(),
                'success' => false,
            ], 422);
        });

        $exceptions->renderable(function (ApiException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'statusCode' => $exception->getApiCode(),
                'success' => false,
            ], 427);
        });

        $exceptions->renderable(function (NotFoundHttpException $exception) {
            \Illuminate\Support\Facades\Log::info(request()->path());
            return response()->json([
                'message' => $exception->getMessage(),
                'statusCode' => 404,
                'success' => false,
            ], 404);
        });

        $exceptions->renderable(function (Throwable $exception) {
            return response()->json([
                'message' => app()->isProduction()
                    ? 'There are too many visitors, please try again later.'
                    : $exception->getMessage(),
            ], 503);
        });
    })
    ->create();
