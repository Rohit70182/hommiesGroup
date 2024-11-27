<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('favourite')->group(function() {
    Route::get('/', 'FavouriteController@index');
    Route::delete('/item/delete', 'FavouriteController@destroy')->name('item.destroy');
    Route::get('/add-item', [
        Modules\Favourite\Http\Controllers\FavouriteController::class,
        'create'
    ])->name('add_item');
    Route::get('/view/{id}', [
        Modules\Favourite\Http\Controllers\FavouriteController::class,
        'show'
    ])->name('item.show');
    Route::get('/edit/{id}', [
        Modules\Favourite\Http\Controllers\FavouriteController::class,
        'edit'
    ])->name('item.edit');
    Route::patch('/update/{id}', [
        Modules\Favourite\Http\Controllers\FavouriteController::class,
        'update'
    ])->name('update');
    
    Route::post('/save-page', [
        Modules\Favourite\Http\Controllers\FavouriteController::class,
        'store'
    ])->name('save');
    Route::get('/fav/{id}', [Modules\Favourite\Http\Controllers\FavouriteController::class, 'fav']);
});
