<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ConfigurationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1')->group(function(){
    Route::post('/login', [ApiAuthController::class, 'login'])->name('v1.auth.login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/user', function(Request $request){
            return $request->user();
        })->name('v1.auth.userProfile');

        Route::post('/logout', [ApiAuthController::class, 'logout'])->name('v1.auth.logout');

        Route::get('/getCurrentConf', [ConfigurationController::class, 'getCurrentConf'])->name('v1.conf.getCurrentConf');
    });
});
