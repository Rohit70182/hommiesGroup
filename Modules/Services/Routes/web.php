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
use Modules\Services\Http\Controllers\CategoryController;
use Modules\Services\Http\Controllers\SubCategoryController;
use Modules\Services\Http\Controllers\AddOnController;
use Modules\Services\Http\Controllers\BookingController;
use Modules\Services\Http\Controllers\CustomRequestController;
use Modules\Services\Http\Controllers\ServicesController;
use Modules\Services\Http\Controllers\CouponController;



Route::middleware('auth')->prefix('services')->group(function() {

    Route::get('/', [ServicesController::class, 'index']);
    Route::get('/add', [ServicesController::class, 'create']);
    Route::get('/add/sub-service/{id}', [ServicesController::class, 'createSubService']);
    Route::post('/store', [ServicesController::class, 'store']);
    Route::post('/store/sub-service', [ServicesController::class, 'storeSubService']);
    Route::post('/get_category/{id}', [ServicesController::class, 'get_category']);
    Route::get('/edit/{id}', [ServicesController::class, 'edit']);


    Route::get('/edit/sub-service/{id}', [ServicesController::class, 'editSubService']);
    Route::post('/update/sub-service/{id}', [ServicesController::class, 'updateSubService']);
    Route::get('/delete/sub-service/{id}', [ServicesController::class, 'deleteSubService']);


    Route::post('/update/{id}', [ServicesController::class, 'update']);
    Route::get('/show/{id}', [ServicesController::class, 'show']);
    Route::get('/remove/{id}', [ServicesController::class, 'destroy']);
    Route::get('/delete/sub-service/{id}', [ServicesController::class, 'deleteSubService']);
    Route::get('/softDelete/{id}', [ServicesController::class, 'softDelete']);
    Route::get('/home', [ServicesController::class, 'home']);
    Route::get('/changeState/{id}', [ServicesController::class, 'changeState']);

    
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/add', [CategoryController::class, 'create']);
        Route::post('/store', [CategoryController::class, 'store']);
        Route::get('/edit/{id}', [CategoryController::class, 'edit']);
        Route::post('/update/{id}', [CategoryController::class, 'update']);
        Route::get('/show/{id}', [CategoryController::class, 'show']);
        Route::get('/remove/{id}', [CategoryController::class, 'destroy']);
        Route::get('/softDelete/{id}', [CategoryController::class, 'softDelete']);
    });
    Route::prefix('sub-category')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index']);
        Route::get('/add', [SubCategoryController::class, 'create']);
        Route::post('/store', [SubCategoryController::class, 'store']);
        Route::get('/edit/{id}', [SubCategoryController::class, 'edit']);
        Route::post('/update/{id}', [SubCategoryController::class, 'update']);
        Route::get('/show/{id}', [SubCategoryController::class, 'show']);
        Route::get('/remove/{id}', [SubCategoryController::class, 'destroy']);
        Route::get('/softDelete/{id}', [SubCategoryController::class, 'softDelete']);
    });
    Route::prefix('add-on')->group(function () {
        Route::get('/', [AddOnController::class, 'index']);
        Route::get('/add', [AddOnController::class, 'create']);
        Route::post('/store', [AddOnController::class, 'store']);
        Route::get('/edit/{id}', [AddOnController::class, 'edit']);
        Route::post('/update/{id}', [AddOnController::class, 'update']);
        Route::get('/view/{id}', [AddOnController::class, 'view']);
        Route::get('/remove/{id}', [AddOnController::class, 'destroy']);
        Route::get('/softDelete/{id}', [AddOnController::class, 'softDelete']);
    });

    Route::prefix('booking-req')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
//         Route::get('/add', [BookingController::class, 'create']);
        Route::post('/store', [BookingController::class, 'store']);
        Route::post('/get_category/{id}',[BookingController::class, 'get_category']);
        Route::post('/get_subcategory/{id}',[BookingController::class, 'get_subcategory']);
        Route::get('/edit/{id}', [BookingController::class, 'edit']);
        Route::post('/update/{id}', [BookingController::class, 'update']);
        Route::get('/view/{id}', [BookingController::class, 'show']);
        Route::get('/remove/{id}', [BookingController::class, 'destroy']);
    });
    Route::prefix('custom-req')->group(function () {
        Route::get('/', [CustomRequestController::class, 'index']);
//         Route::get('/add', [CustomRequestController::class, 'create']);
        Route::post('/store', [CustomRequestController::class, 'store']);
        Route::get('/edit/{id}', [CustomRequestController::class, 'edit']);
        Route::get('/status/{id}/{sid}', [CustomRequestController::class, 'updateStatus']);
        Route::post('/update/{id}', [CustomRequestController::class, 'update']);
        Route::get('/show/{id}', [CustomRequestController::class, 'show']);
        Route::get('/remove/{id}', [CustomRequestController::class, 'destroy']);
        Route::get('/softDelete/{id}', [CustomRequestController::class, 'softDelete']);
    });

    Route::prefix('coupon')->group(function () {
        Route::get('/', [CouponController::class, 'index']);
        Route::get('/add', [CouponController::class, 'create']);
        Route::post('/store', [CouponController::class, 'store']);
        Route::get('/edit/{id}', [CouponController::class, 'edit']);
        Route::get('/apporve/{id}', [CouponController::class, 'apporve']);
        Route::get('/decline/{id}', [CouponController::class, 'decline']);
        Route::post('/update/{id}', [CouponController::class, 'update']);
        Route::get('/show/{id}', [CouponController::class, 'show']);
        Route::get('/remove/{id}', [CouponController::class, 'destroy']);
        Route::get('/softDelete/{id}', [CouponController::class, 'softDelete']);
        Route::get('/stateupdate/{id}/{st}', [CouponController::class, 'stateupdate']);
    });

    
});
