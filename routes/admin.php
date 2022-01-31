<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Config
Route::prefix('configs')->group(function () {
    Route::get('', [ConfigController::class, 'index'])
        ->name('configs.index');
    Route::get('/list', [ConfigController::class, 'list'])
        ->name('configs.system');
    Route::get('/list/{config}', [ConfigController::class, 'getSystemConfig'])
        ->name('configs.system.get');
    Route::post('', [ConfigController::class, 'post'])
        ->name('configs.create');
    Route::get('{config}', [ConfigController::class, 'get'])
        ->name('configs.get');
    Route::put('{config}', [ConfigController::class, 'put'])
        ->name('configs.update');
    Route::delete('{config}', [ConfigController::class, 'remove'])
        ->name('configs.delete');
});
