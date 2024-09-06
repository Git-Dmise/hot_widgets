<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class AnimationController extends Controller
{
    public function resources(): JsonResponse
    {
        return $this->success([env('DOMAIN_NAME') . 'zip/islands/animation.zip']);
    }

    public function index(): JsonResponse
    {
        $response_data = [];

        for ($i = 1; $i <= 9; $i++) {
            $large = [];
            $thumb = [];

            for ($j = 1; $j <= 10; $j++) {
                $large[] = '00' . $i . '_00' . $j . '_large.png';
            }

            $thumb['left'] = '00' . $i . '_001_thumb_left.png';
            $thumb['right'] = '00' . $i . '_001_thumb_right.png';

            $response_data[] = [
                'id' => $i,
                'is_vip' => $i !== 1,
                'large' => $large,
                'thumb' => $thumb,
            ];
        }

        return $this->success($response_data);
    }
}
