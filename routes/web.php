<?php

use App\Http\Controllers\OffWorkController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn() => Inertia::render('LandingPage/Index'));

Route::get('/info', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function (){
    Route::resources([
        'locations' => \App\Http\Controllers\LocationController::class,
        'users' => \App\Http\Controllers\UserController::class,
        'offworks' => OffWorkController::class,
    ]);

    Route::resource('configurations', \App\Http\Controllers\ConfigurationController::class)->only(['index', 'edit', 'update']);
    Route::put('/offworks/{offwork}/updateStatus', [OffWorkController::class, 'updateStatus'])->name('offworks.updateStatus');

    Route::resource('attendances', \App\Http\Controllers\AttendanceController::class);
});
