<?php

use App\Http\Controllers\Api\AnimationController;
use App\Http\Controllers\Api\ServerController;
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
Route::get('get_timestamp', [ServerController::class, 'index']);

Route::middleware(['api.sign.check'])->group(function () {
    Route::prefix('animation')->group(function () {
        Route::get('index', [AnimationController::class, 'index']);
    });
});
