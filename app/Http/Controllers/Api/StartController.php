<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class StartController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = __('start');

        return $this->success($response_data);
    }
}
