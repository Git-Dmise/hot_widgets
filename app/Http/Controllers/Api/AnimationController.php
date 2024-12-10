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
                if ($j < 10) {
                    $j = '0' . $j;
                }
                $large[] = 'resource/dynamic_island/smart/' . $i . '/reality/' . $j . '.png';
            }

            $response_data[] = [
                'id' => $i,
                'is_vip' => $i !== 1,
                'large_duration' => $i === 9 ? 2 : 1,
                'large' => $large,
                'left_duration' => 1,
                'left' => ['resource/dynamic_island/smart/' . $i . '/left/1.png'],
                'right_duration' => 1,
                'right' => ['resource/dynamic_island/smart/' . $i . '/right/1.png'],
            ];
        }

        return $this->success($response_data);
    }
}
