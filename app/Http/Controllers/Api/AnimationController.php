<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class AnimationController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = [
            [
                'id' => 1,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 2,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 3,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 4,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 5,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 6,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 7,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 8,
                'is_vip' => true,
                'cover_link' => '1',
            ],
            [
                'id' => 9,
                'is_vip' => true,
                'cover_link' => '1',
            ],
        ];

        return $this->success($response_data);
    }
}
