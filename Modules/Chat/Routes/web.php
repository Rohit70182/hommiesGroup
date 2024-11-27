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
Route::prefix('chat')->middleware('auth')->group(function() {
    Route::get('/', 'ChatController@index');
    Route::post('/send/{id}', 'ChatController@store');
    Route::get('/show/{id}','ChatController@chat');
    Route::post('/get-message/{id}','ChatController@getMessage');
    Route::get('/get-user-list/', 'ChatController@getUserList');
});
