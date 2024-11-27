<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\API\PageController;

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

Route::middleware('auth:api')->get('/page', function (Request $request) {
    return $request->user();
});
    Route::group([
        'prefix' => 'page'
    ], function () {
        Route::get('/list', [
            PageController::class,
            'list'
        ]);
    });