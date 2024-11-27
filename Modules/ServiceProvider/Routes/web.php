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
use Modules\ServiceProvider\Http\Controllers\ServiceProviderController;

Route::middleware('auth')->prefix('serviceProvider')->group(function() {

    Route::get('/', [ServiceProviderController::class, 'index']);
    Route::get('/create', [ServiceProviderController::class, 'create']);
    Route::post('/store', [ServiceProviderController::class, 'store']);
    Route::get('/edit/{id}',[ServiceProviderController::class, 'edit']);
    Route::post('/update/{id}',[ServiceProviderController::class, 'update']);
    Route::get('/show/{id}', [ServiceProviderController::class, 'show']);
    Route::get('/delete/{id}', [ServiceProviderController::class, 'destroy']);
    Route::get('/softDelete/{id}', [ServiceProviderController::class, 'softDelete']);

});
