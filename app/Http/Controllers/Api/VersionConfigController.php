<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class VersionConfigController extends Controller
{
    public function force_update(): JsonResponse
    {
        $latest_version = '1.0.1';
        $minimum_version = '1.0.0';
        $update_details = 'xxx';
        $update_url = 'xxx';
        $update_md5 = 'xxx';

        return $this->success([
            'forceUpdate' => version_compare($this->request->header('X-Client-Version'), $minimum_version, '<'),
            'version' => $latest_version,
            'updateContent' => $update_details,
            'updateUrl' => $update_url,
            'updateMd5' => $update_md5,
        ]);
    }

    public function config(): JsonResponse
    {
        $response_data = [
            'link' => [
                'teaching' => 'xxx',
                'contact_email' => 'xxx',
                'terms_privacy' => 'xxx',
            ],
            'apple_product_id' => [
                'week' => '1',
                'quarterly' => '2',
            ],
        ];

        return $this->success($response_data);
    }
}
