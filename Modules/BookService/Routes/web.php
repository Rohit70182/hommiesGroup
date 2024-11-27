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
use Modules\BookService\Http\Controllers\BookServiceController;
use Modules\BookService\Http\Controllers\CustomController;
use Modules\BookService\Http\Controllers\ScheduleServicesController;

Route::middleware('auth')->prefix('booking')->group(function()  {

    Route::get('/', [BookServiceController::class ,'index'])->name('bookings');
    Route::get('/show/{id}', [BookServiceController::class, 'show'])->name('show.booking');
    Route::post('/assign/{uid}', [BookServiceController::class, 'assign']);
    
});
