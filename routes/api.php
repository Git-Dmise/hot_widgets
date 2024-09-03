<?php

use App\Http\Controllers\Api\AnimationController;
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

Route::middleware(['api.sign.check'])->group(function () {
    Route::prefix('animation')->group(function () {
        Route::get('/preview', [AnimationController::class, 'preview']);
    });
});
