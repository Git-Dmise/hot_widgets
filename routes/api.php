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
Route::get('init', [ServerController::class, 'index']); // 获取时间戳
Route::get('version/force-update', [VersionConfigController::class, 'force_update']);   // 强制更新检测

Route::middleware(['api.sign.check'])->group(function () {
    Route::get('version/config', [VersionConfigController::class, 'config']); // 获取版本配置

    Route::group(['prefix' => 'widget'], function () {
        Route::group(['prefix' => 'recommend'], function () {
            Route::get('index', [WidgetRecommendController::class, 'index']); // 推荐组件
            Route::get('sticker', [WidgetRecommendController::class, 'sticker']); // 贴纸详情
            Route::get('photo_frame', [WidgetRecommendController::class, 'photo_frame']); // 照片详情
        });

        Route::group(['prefix' => 'lock_screen'], function () {
            Route::get('index', [LockScreenController::class, 'index']); // 锁屏组件
            Route::get('sticker', [LockScreenController::class, 'sticker']); // 贴纸详情
        });
    });

    // 灵动岛
    Route::get('animation/index', [AnimationController::class, 'index']);   // 动画岛列表
    Route::get('barrage/index', [BarrageController::class, 'index']);   // 弹幕岛列表
    Route::get('start/index', [StartController::class, 'index']); // 启动岛列表
});
