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

            for ($j = 1; $j <= 10; $j++) {
                $large[] = 'animation/' . $i . ($i === 9 ? '/large_2/' : '/large/') . $j . '.png';
            }

            $response_data[] = [
                'id' => $i,
                'is_vip' => $i !== 1,
                'large' => $large,
                'left' => ['animation/' . $i . '/left/' . $i . '.png'],
                'right' => ['animation/' . $i . '/right/' . $i . '.png'],
            ];
        }

        return $this->success($response_data);
    }
}
