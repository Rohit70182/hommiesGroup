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


Route::middleware('admin')->group(function () {
Route::prefix('comment')->group(function() {
    Route::get('/', 'CommentController@index');
    Route::get('/delete/{id}', 'CommentController@destroy');
    Route::get('/view/{id}', [
        Modules\Comment\Http\Controllers\CommentController::class,
        'show'
    ])->name('comment.show');
    Route::get('/add-comment', [
        Modules\Comment\Http\Controllers\CommentController::class,
        'create'
    ])->name('add_comment');
    Route::post('/store-comment', [
        Modules\Comment\Http\Controllers\CommentController::class,
        'store'
    ]);
});
});
