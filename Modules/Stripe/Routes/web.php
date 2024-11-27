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
use Modules\Stripe\Http\Controllers\SettingsController;
use Modules\Stripe\Http\Controllers\StripeCardsController;
use Modules\Stripe\Http\Controllers\StripeController;

Route::middleware('auth')->prefix('stripe')->group(function () {

    Route::get('/', [StripeController::class, 'index']);

    Route::prefix('cards')->group(function () {
        Route::get('/', [StripeCardsController::class, 'index']);
        Route::get('/add', [StripeCardsController::class, 'create']);
        Route::post('/store', [StripeCardsController::class, 'store']);
        Route::get('/edit/{id}', [StripeCardsController::class, 'edit']);
        Route::get('/view/{id}', [StripeCardsController::class, 'view']);
        Route::get('/remove/{id}', [StripeCardsController::class, 'destroy']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index']);
        Route::get('/add', [SettingsController::class, 'create']);
        Route::post('/store', [SettingsController::class, 'store']);
        Route::get('/edit/{id}', [SettingsController::class, 'edit']);
        Route::get('/view/{id}', [SettingsController::class, 'view']);
        Route::get('/remove/{id}', [SettingsController::class, 'destroy']);
    });
});
