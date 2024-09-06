<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class AnimationController extends Controller
{
    public function index(): JsonResponse
    {
//        $domain_name = env('DOMAIN_NAME');
//
//        $response_data = [];
//
//        $animation_directory = File::directories(public_path('/images/islands/animation/'));
//        foreach ($animation_directory as $item => $value) {
//            $item++;
//
//            $large = [];
//            $large_path = $value . '/large/';
//            $large_files = File::files($large_path);
//            foreach ($large_files as $file) {
//                $large[] = $domain_name . preg_replace('/.*public\//', '', $large_path) . basename($file);
//            }
//
//            $thumb = [];
//            $thumb_path = $value . '/thumb/';
//            $thumb_files = File::files($thumb_path);
//            foreach ($thumb_files as $file) {
//                $thumb[] = $domain_name . preg_replace('/.*public\//', '', $thumb_path) . basename($file);
//            }
//
//            $response_data[] = [
//                'id' => $item,
//                'is_vip' => !($item === 1 or $item === 2),
//                'large' => $large,
//                'thumb' => $thumb,
//            ];
//        }

        $response_data = [
            [
                'id' => 1,
                'is_vip' => true,
                'large' => [
                    ''
                ],
                'thumb' => $thumb,
            ],
        ];

        return $this->success($response_data);
    }
}
