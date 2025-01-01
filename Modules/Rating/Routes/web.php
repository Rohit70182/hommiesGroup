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

Route::prefix('rating')->group(function() {
    Route::get('/', 'RatingController@index');
    Route::delete('/item/delete', 'RatingController@destroy')->name('rating.destroy');
    Route::get('/view/{id}', [
        Modules\Rating\Http\Controllers\RatingController::class,
        'show'
    ])->name('rating.show');
    Route::get('/add-rating', [
        Modules\Rating\Http\Controllers\RatingController::class,
        'create'
    ])->name('add_rating');
    Route::post('/store-rating', [
        Modules\Rating\Http\Controllers\RatingController::class,
        'store'
    ]);
    Route::patch('/update/{id}', [
        Modules\Rating\Http\Controllers\RatingController::class,
        'update'
    ])->name('update');
});
