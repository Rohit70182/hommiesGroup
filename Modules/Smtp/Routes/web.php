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

Route::prefix('smtp')->group(function() {
    Route::get('/home','SmtpController@home');
    Route::get('/account', 'SmtpAccountController@accounts');
    Route::get('/add', 'SmtpAccountController@add');
    Route::post('/store', 'SmtpAccountController@store');
    Route::get('/edit/{id}','SmtpAccountController@edit');
    Route::post('/update/{id}','SmtpAccountController@update');
     Route::get('/delete/{id}','SmtpAccountController@destroy');
    Route::get('/emailQueue','SmtpQueueController@index');
});
