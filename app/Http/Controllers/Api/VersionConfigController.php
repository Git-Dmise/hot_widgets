<?php

namespace App\Http\Controllers\Api;

use App\Services\IpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class VersionConfigController extends Controller
{
    public function force_update(): JsonResponse
    {
        $latest_version = '1.0.0';
        $minimum_version = '1.0.0';
        $update_details = 'xxx';
        $update_url = 'xxx';
        $update_md5 = 'xxx';
        $is_flashback = false;

        $versionStatus = (int)version_compare($this->request->header('X-Client-Version'), $minimum_version, '<');
        if ($versionStatus and $is_flashback) {
            $versionStatus = 2;
        }

        return $this->success([
            'versionStatus' => $versionStatus,
            'version' => $latest_version,
            'updateContent' => $update_details,
            'updateUrl' => $update_url,
            'updateMd5' => $update_md5,
        ]);
    }

    public function config(): JsonResponse
    {
        $content = file_get_contents(app_path('Libs/config/version/config.json'));

        $response_data = json_decode($content, true);

        $response_data = self::makeLang($response_data);

        $response_data['ipInfo'] = [
            'inChina' => app(IpService::class)->isInChina($this->request->ip()),
            'starAccel' => app(IpService::class)->ipInChinaNoCity($this->request->ip(), ['北京市', '上海市']),
            'area' => app(IpService::class)->getArea($this->request->ip()),
        ];

        return $this->success($response_data);
    }

    public static function makeLang(array $body): array
    {
        $locale = App::getLocale();

        foreach ($body as &$value) {
            if (is_array($value)) {
                if (isset($value['en-US'])) {
                    $value = $value[$locale];
                }
                else {
                    $value = self::makeLang($value);
                }
            }
        }
        return $body;
    }
}
