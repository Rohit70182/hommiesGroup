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
use Modules\Seo\Http\Controllers\ManagerController;
use Modules\Seo\Http\Controllers\AnalyticsController;
use Modules\Seo\Http\Controllers\RedirectController;

Route::middleware('auth')->prefix('seo')->group(function () {

    Route::get('/', [Modules\Seo\Http\Controllers\SeoController::class, 'index']);

    Route::prefix('manager')->group(function () {
        Route::get('/', [ManagerController::class, 'index']);
        Route::get('/add', [ManagerController::class, 'create']);
        Route::post('/store', [ManagerController::class, 'store']);
        Route::get('/edit/{id}', [ManagerController::class, 'edit']);
        Route::get('/view/{id}', [ManagerController::class, 'view']);
        Route::get('/remove/{id}', [ManagerController::class, 'destroy']);
    });

    Route::prefix('analytics')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index']);
        Route::get('/add', [AnalyticsController::class, 'create']);
        Route::post('/store', [AnalyticsController::class, 'store']);
        Route::get('/edit/{id}', [AnalyticsController::class, 'edit']);
        Route::get('/view/{id}', [AnalyticsController::class, 'view']);
        Route::get('/remove/{id}', [AnalyticsController::class, 'destroy']);
    });

    Route::prefix('redirect')->group(function () {
        Route::get('/', [RedirectController::class, 'index']);
        Route::get('/add', [RedirectController::class, 'create']);
        Route::post('/store', [RedirectController::class, 'store']);
        Route::get('/edit/{id}', [RedirectController::class, 'edit']);
        Route::get('/view/{id}', [RedirectController::class, 'view']);
        Route::get('/remove/{id}', [RedirectController::class, 'destroy']);
    });
});
