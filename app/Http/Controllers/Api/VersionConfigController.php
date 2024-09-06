<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class VersionConfigController extends Controller
{
    public function index(): JsonResponse
    {
        $latest_version = '1.0.0';
        $minimum_version = '1.0.0';
        $update_details = 'xxx';

        if (version_compare($this->request->header('X-Client-Version'), $minimum_version, '<')) {
            $version_status = 1;
        }
        elseif (version_compare($this->request->header('X-Client-Version'), $latest_version, '<')) {
            $version_status = 0;
        }
        else {
            $version_status = -1;
        }

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
            'version' => [
                'latest_version' => $latest_version,
                'minimum_version' => $minimum_version,
                'version_status' => $version_status,
                'update_details' => $update_details
            ],
        ];

        return $this->success($response_data);
    }
}
