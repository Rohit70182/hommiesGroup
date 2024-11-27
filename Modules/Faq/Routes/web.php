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
use Modules\Faq\Http\Controllers\FaqController;

Route::middleware('auth')->prefix('faq')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('faq');
    Route::get('/add-faq', [FaqController::class, 'create'])->name('add_faq');
    Route::get('/add-faq', [FaqController::class, 'create'])->name('add_faq');
    Route::delete('/delete', [FaqController::class, 'destroy'])->name('faq.destroy');
    Route::get('/view/{id}', [FaqController::class, 'show'])->name('faq.show');
    Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::patch('/update/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::post('/save-faq', [FaqController::class, 'store'])->name('faq.store');
});
