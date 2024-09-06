<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class BarrageController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = [];

        $barrage = __('barrage');
        foreach ($barrage as $item => $value) {
            $item++;

            $response_data[] = [
                'id' => $item,
                'is_vip' => !($item === 1 or $item === 2),
                'text' => $value,
            ];
        }

        return $this->success($response_data);
    }
}
