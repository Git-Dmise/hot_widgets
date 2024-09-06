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
        return response()->json([
            'code' => is_null($code) ? 200 : $code,
            'message' => is_null($message) ? 'Success.' : $message,
            'data' => $data,
        ]);
    }

    public function error(string|null $message = null, int|null $code = null): JsonResponse
    {
        return response()->json([
            'code' => is_null($code) ? 422 : $code,
            'message' => is_null($message) ? 'Error.' : $message,
        ]);
    }
}
