<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class BarrageController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = __('barrage');

        return $this->success($response_data);
    }
}
