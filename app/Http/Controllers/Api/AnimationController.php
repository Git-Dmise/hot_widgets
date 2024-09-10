<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class AnimationController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = [];

        for ($i = 1; $i <= 9; $i++) {
            $large = [];
            $thumb = [];

            for ($j = 1; $j <= 10; $j++) {
                $large[] = '00' . $i . '/large/00' . $i . '_00' . $j . '_large.png';
            }

            $response_data[] = [
                'id' => $i,
                'is_vip' => $i !== 1,
                'large' => $large,
                'left' => ['00' . $i . '/thumb/00' . $i . '_001_thumb_left.png'],
                'right' => ['00' . $i . '/thumb/00' . $i . '_001_thumb_right.png'],
            ];
        }

        return $this->success($response_data);
    }
}
