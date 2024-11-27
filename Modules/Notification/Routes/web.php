<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\NotificationController;

Route::middleware('auth')->prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::get('/delete/{id}', [NotificationController::class, 'destroy']);
    Route::post('/ajax', [NotificationController::class, 'ajax']);
    Route::get('/send', [NotificationController::class, 'send']);
    Route::post('/send', [NotificationController::class, 'sendNotification']);
});
