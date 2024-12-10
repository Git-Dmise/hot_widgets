<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class LockScreenController extends Controller
{
    public function index(): JsonResponse
    {
        $response_data = $this->makeResponseData('Libs/config/lock_screen.json');

        return $this->success($response_data);
    }

    public function sticker(): JsonResponse
    {
        $response_data = $this->makeResponseData('Libs/config/lock_screen_sticker.json');

        return $this->success($response_data);
    }

    public function makeResponseData(string $json_path): array
    {
        $lock_screen = file_get_contents(app_path($json_path));
        $lock_screen = json_decode($lock_screen, true);
        $lock_screen = VersionConfigController::makeLang($lock_screen);

        $response_data = [];
        $substringToRemove = '/projects/hot_widgets/app/Libs/';
        $i = 0;
        foreach ($lock_screen as $item) {
            $response_data[$i]['id'] = $item['id'];
            $response_data[$i]['sort_id'] = $item['sort_id'];
            $response_data[$i]['type'] = $item['style_type'];
            $response_data[$i]['title'] = $item['title'];
            $response_data[$i]['is_vip'] = true;

            $preview_path = '';
            if ($item['widget_style'] !== 'bar') {
                $temp_path =
                    'resource/' .
                    $item['type'] . '/' .
                    $item['widget_style'] . '/' .
                    (isset($item['widget_type']) ? $item['widget_type'] . '/' : '') .
                    $item['widget_folders'];
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/preview');
                foreach ($resources as $resource) {
                    $preview_path = str_replace($substringToRemove, '', $resource->getPathname());
                }
            }

            $response_data[$i]['previewPath'] = $preview_path;
            $response_data[$i]['style'] = $item['widget_style'];
            $response_data[$i]['tintColor'] = '#D06F00';
            $response_data[$i]['bgColor'] = '#FFF7EA';

            $reality_path = '';
            if ($item['widget_style'] !== 'bar') {
                $temp_path =
                    'resource/' .
                    $item['type'] . '/' .
                    $item['widget_style'] . '/' .
                    (isset($item['widget_type']) ? $item['widget_type'] . '/' : '') .
                    $item['widget_folders'];
                $resources = File::allFiles(app_path('Libs') . '/' . $temp_path . '/reality');
                foreach ($resources as $resource) {
                    $reality_path = str_replace($substringToRemove, '', $resource->getPathname());
                }
            }

            $response_data[$i]['image'] = $reality_path;
            $response_data[$i]['text'] = $item['text'] ?? '';

            $i++;
        }

        return $response_data;
    }
}
