<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Throwable;

class WidgetRecommendController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = $this->makeResponseData('Libs/config/recommend.json');

        return $this->success($response_data);
    }

    public function sticker(): JsonResponse
    {
        $response_data = $this->makeResponseData('Libs/config/sticker.json');

        return $this->success($response_data);
    }

    public function photo_frame(): JsonResponse
    {
        $response_data = $this->makeResponseData('Libs/config/photo_frame.json');

        return $this->success($response_data);
    }

    public function makeResponseData(string $json_path): array
    {
        $recommend = file_get_contents(app_path($json_path));
        $recommend = json_decode($recommend, true);
        $recommend = VersionConfigController::makeLang($recommend);

        $response_data = [];
        $substringToRemove = '/projects/hot_widgets/app/Libs/';
        $i = 0;
        foreach ($recommend as $item) {
            $response_data[$i]['id'] = $item['id'];
            $response_data[$i]['sort_id'] = $item['sort_id'];
            $response_data[$i]['type'] = $item['widget_type'] ?? $item['widget_folders'];
            $response_data[$i]['title'] = $item['title'];
            $response_data[$i]['is_vip'] = $item['is_vip'];

            $temp_path =
                'resource/' .
                $item['type'] . '/' .
                $item['widget_style'] . '/' .
                (isset($item['widget_type']) ? $item['widget_type'] . '/' : '') .
                $item['widget_folders'];
            try {
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/preview');
            } catch (Throwable) {
                //
            }
            $preview_path = '';
            foreach ($resources as $resource) {
                $preview_path = str_replace($substringToRemove, '', $resource->getPathname());
            }

            $response_data[$i]['previewPath'] = $preview_path;
            $response_data[$i]['is_gif'] = str_ends_with($preview_path, '.gif');
            $response_data[$i]['style'] = $item['widget_style'];
            if (isset($item['widget_type']) and $item['widget_type'] === 'sticker') {
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/reality');

                $reality = [];
                foreach ($resources as $resource) {
                    $reality[] = str_replace($substringToRemove, '', $resource->getPathname());
                }
                $response_data[$i]['sticker'] = [
                    'large' => $reality,
                    'large_duration' => 1.0,
                ];
            }
            elseif (isset($item['widget_type']) and $item['widget_type'] === 'photo_frame') {
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/default_image');
                $default_image = '';
                foreach ($resources as $resource) {
                    $default_image = str_replace($substringToRemove, '', $resource->getPathname());
                }

                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/reality');
                $reality = '';
                foreach ($resources as $resource) {
                    $reality = str_replace($substringToRemove, '', $resource->getPathname());
                }

                $response_data[$i]['photoFrame'] = [
                    'default_image' => $default_image,
                    'reality' => $reality,
                ];
            }
            elseif (isset($item['widget_folders']) and $item['widget_folders'] === 'photo_wall') {
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/default_image');
                $default_image = [];
                foreach ($resources as $resource) {
                    $default_image[] = str_replace($substringToRemove, '', $resource->getPathname());
                }

                $response_data[$i]['photoWall'] = [
                    'default_image' => $default_image,
                    'reality_bg' => str_replace($substringToRemove, '', app_path('Libs') . '/' . $temp_path . '/reality/bg.png'),
                    'reality_box' => str_replace($substringToRemove, '', app_path('Libs') . '/' . $temp_path . '/reality/box.png'),
                ];
            }
            elseif (isset($item['widget_folders']) and ($item['widget_folders'] === 'anniversary')) {
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/reality');
                $reality = '';
                foreach ($resources as $resource) {
                    $reality = str_replace($substringToRemove, '', $resource->getPathname());
                }

                $response_data[$i]['anniversary'] = [
                    'reality' => $reality,
                ];
            }
            elseif (isset($item['widget_folders']) and $item['widget_folders'] === 'power') {
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/reality');
                $reality = '';
                foreach ($resources as $resource) {
                    $reality = str_replace($substringToRemove, '', $resource->getPathname());
                }

                $response_data[$i]['power'] = [
                    'reality' => $reality,
                ];
            }

            $i++;
        }

        return $response_data;
    }
}
