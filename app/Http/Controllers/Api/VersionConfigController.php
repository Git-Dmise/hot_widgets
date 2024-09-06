<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use Illuminate\Http\JsonResponse;

class VersionConfigController extends Controller
{
    public function index(): JsonResponse
    {
        throw new ApiException(422, __(''));
        if (version_compare($this->request->header('X-Client-Version'), '1.0.0', '<')) {
            throw new ApiException();
        }

        $response_data = [
            'apple_product_id' => [
                'week' => '1',
                'quarterly' => '2',
            ]
        ];

        return $this->success($response_data);
    }
}
