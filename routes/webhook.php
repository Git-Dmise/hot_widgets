<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Support\Facades\Route;

Route::post('app/configs', [AppConfigController::class, 'store']);  // 修改版本配置
