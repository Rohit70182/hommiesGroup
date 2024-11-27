<?php

use Illuminate\Support\Facades\Route;
use Modules\Security\Http\Controllers\SecurityController;
use Modules\Security\Http\Controllers\RuleController;
use Modules\Security\Http\Controllers\LogController;
use Modules\Security\Http\Controllers\BlacklistController;
use Modules\Security\Http\Controllers\WhitelistController;

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


Route::prefix('security')->group(function () {
    Route::get('/', [SecurityController::class, 'index']);

    Route::prefix('rule')->group(function () {
        Route::get('/', [RuleController::class, 'index']);
        Route::get('/add', [RuleController::class, 'create']);
        Route::post('/store', [RuleController::class, 'store']);
        Route::get('/edit/{id}', [RuleController::class, 'edit']);
        Route::post('/update/{id}', [RuleController::class, 'update']);
        Route::get('/view/{id}', [RuleController::class, 'show']);
        Route::get('/delete/{id}', [RuleController::class, 'destroy']);
    });

    Route::prefix('blacklist')->group(function () {
        Route::get('/', [BlacklistController::class, 'index']);
        Route::get('/add', [BlacklistController::class, 'create']);
        Route::post('/store', [BlacklistController::class, 'store']);
        Route::get('/edit/{id}', [BlacklistController::class, 'edit']);
        Route::post('/update/{id}', [BlacklistController::class, 'update']);
        Route::get('/view/{id}', [BlacklistController::class, 'show']);
        Route::get('/delete/{id}', [BlacklistController::class, 'destroy']);
    });

    Route::prefix('whitelist')->group(function () {
        Route::get('/', [WhitelistController::class, 'index']);
        Route::get('/add', [WhitelistController::class, 'create']);
        Route::post('/store', [WhitelistController::class, 'store']);
        Route::get('/edit/{id}', [WhitelistController::class, 'edit']);
        Route::post('/update/{id}', [WhitelistController::class, 'update']);
        Route::get('/view/{id}', [WhitelistController::class, 'show']);
        Route::get('/delete/{id}', [WhitelistController::class, 'destroy']);
    });
});
