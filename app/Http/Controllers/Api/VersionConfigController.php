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
        $response_data = json_decode("{\r\n    \"otherInfo\": {\r\n        \"termsUrl\": \"https:\/\/docs.google.com\/document\/d\/12ku3TSBUeP-HCm0BhCYsGFaNDwMXas7t7r6Er4_6MDk\/edit?usp=sharing\",\r\n        \"privacyUrl\": \"https:\/\/docs.google.com\/document\/d\/11Q3866e9fMsa7LDRRvcbC9TmsOykv2_3BFl6fmRpC9A\/edit?usp=sharing\",\r\n        \"resources\": \"http:\/\/mypaper-dev.lovepor.cn:40041\/zip\/islands\/animation.zip\",\r\n        \"tutorialUrl\": \"http:\/\/mypaper-dev.lovepor.cn:40042\/course\"\r\n    },\r\n    \"scoreInfo\": {\r\n        \"n\": 2,\r\n        \"scoreMaxCount\": 5,\r\n        \"isShowScore\": false,\r\n        \"scoreMode\": 2\r\n    },\r\n    \"purchase_details\": {\r\n        \"forever_product_ids\": [\r\n            \"hotwidgets.forever\"\r\n        ],\r\n        \"subscrip_product_ids\": [\r\n            \"hotwidgets.year\",\r\n            \"hotwidgets.week\"\r\n        ],\r\n        \"products\": [\r\n            {\r\n                \"productId\": \"hotwidgets.forever\",\r\n                \"title\": {\r\n                    \"en-US\": \"permanent\",\r\n                    \"zh-Hans-CN\": \"永久\",\r\n                    \"zh-Hant-HK\": \"永久\"\r\n                },\r\n                \"type\": \"year\",\r\n                \"price\": \"$29.99\",\r\n                \"originalPrice\": \"$299.99\",\r\n                \"discountContent\": {\r\n                    \"en-US\": \"90% of the province\",\r\n                    \"zh-Hans-CN\": \"立省90%\",\r\n                    \"zh-Hant-HK\": \"立省90%\"\r\n                }\r\n            },\r\n            {\r\n                \"productId\": \"hotwidgets.year\",\r\n                \"title\": {\r\n                    \"en-US\": \"annually\",\r\n                    \"zh-Hans-CN\": \"每年\",\r\n                    \"zh-Hant-HK\": \"每年\"\r\n                },\r\n                \"type\": \"year\",\r\n                \"price\": \"$39.99\"\r\n            },\r\n            {\r\n                \"productId\": \"hotwidgets.week\",\r\n                \"title\": {\r\n                    \"en-US\": \"weekly\",\r\n                    \"zh-Hans-CN\": \"每周\",\r\n                    \"zh-Hant-HK\": \"每週\"\r\n                },\r\n                \"type\": \"week\",\r\n                \"price\": \"$4.99\"\r\n            }\r\n        ]\r\n    }\r\n}",
            true);

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
