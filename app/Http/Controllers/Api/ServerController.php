<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->success([
            'timestamp' => (int)(microtime(true) * 1000)
        ]);
    }
}
