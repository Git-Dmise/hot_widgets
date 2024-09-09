<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('init', [ServerController::class, 'index']);
Route::get('version/force-update', [VersionConfigController::class, 'force_update']); // 强制更新检测

Route::middleware(['api.sign.check'])->group(function () {
    Route::get('version/config', [VersionConfigController::class, 'config']); // web端支付配置

    Route::prefix('animation')->group(function () {
        Route::get('resources', [AnimationController::class, 'resources']); // 动画岛图片资源
        Route::get('index', [AnimationController::class, 'index']); // 动画岛列表
    });

    Route::prefix('barrage')->group(function () {
        Route::get('index', [BarrageController::class, 'index']);   // 弹幕岛列表
    });

    Route::prefix('start')->group(function () {
        Route::get('index', [StartController::class, 'index']); // 启动岛列表
    });
});
