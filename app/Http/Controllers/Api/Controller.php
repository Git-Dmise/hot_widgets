<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = request();
    }

    public function success($data = [], string|null $message = null, int|null $code = null): JsonResponse
    {
        $statusCode = is_null($code) ? 200 : $code;

        return response()->json([
            'statusCode' => $statusCode,
            'message' => is_null($message) ? 'Success.' : $message,
            'success' => $statusCode === 200,
            'data' => $data,
        ]);
    }

    public function error(string|null $message = null, int|null $code = null): JsonResponse
    {
        $statusCode = is_null($code) ? 200 : $code;

        return response()->json([
            'statusCode' => $statusCode,
            'success' => $statusCode === 200,
            'message' => is_null($message) ? 'Error.' : $message,
        ]);
    }
}
