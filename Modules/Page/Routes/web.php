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
use Modules\Page\Http\Controllers\PageController;

Route::middleware('auth')->prefix('page')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/add-page', [PageController::class, 'create'])->name('add_page');
    Route::get('/delete/{id}', [PageController::class, 'destroy'])->name('page.destroy');
    Route::get('/softDelete/{id}', [PageController::class, 'softDelete'])->name('page.softDelete');
    Route::get('/view/{id}', [PageController::class, 'show'])->name('page.show');
    Route::get('/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
    Route::patch('/update/{id}', [PageController::class, 'update'])->name('page.update');
    Route::post('/save-page', [PageController::class, 'store'])->name('store');
});
