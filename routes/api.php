<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */

Route::prefix('user')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
        Route::post('/profile/update', [
            \App\Http\Controllers\API\AuthController::class,
            'profileUpdate'
        ]);
        Route::post('/change-password', [
            \App\Http\Controllers\API\AuthController::class,
            'changePassword'
        ]);
        Route::delete('/delete-account', [
            \App\Http\Controllers\API\AuthController::class,
            'deleteUserAccount'
        ]);
        Route::get('/logout', [
            \App\Http\Controllers\API\AuthController::class,
            'logout'
        ]);
        Route::post('/address/add', [
            \App\Http\Controllers\API\AuthController::class,
            'addAddress'
        ]);

        Route::get('/address-list', [
            \App\Http\Controllers\API\AuthController::class,
            'addressDetail'
        ]);

        Route::get('/address/delete', [
            \App\Http\Controllers\API\AuthController::class,
            'addressDelete'
        ]);

        Route::post('/address/update', [
            \App\Http\Controllers\API\AuthController::class,
            'addressUpdate'
        ]);
    });
});
// Route::middleware('auth:sanctum')->get('/user/check', [\App\Http\Controllers\API\AuthController::class, 'userCheck']);

Route::prefix('user')->group(function () {
    Route::post('/register', [
        \App\Http\Controllers\API\AuthController::class,
        'register'
    ]);
    Route::post('/register-provider', [
        \App\Http\Controllers\API\AuthController::class,
        'registerProvider'
    ]);
    Route::get('/page', [
        \App\Http\Controllers\API\AuthController::class,
        'page'
    ]);
    Route::get('/check', [
        \App\Http\Controllers\API\AuthController::class,
        'userCheck'
    ]);
    Route::post('/login', [
        \App\Http\Controllers\API\AuthController::class,
        'login'
    ]);

    Route::post('/verify_otp', [
        \App\Http\Controllers\API\AuthController::class,
        'verifyOtp'
    ]);
    Route::post('/resend_otp', [
        \App\Http\Controllers\API\AuthController::class,
        'resendOtp'
    ]);
    Route::post('/password/forgot', [
        \App\Http\Controllers\API\AuthController::class,
        'sendPasswordResetLink'
    ])->middleware('throttle:5,1');
    Route::post('/password/verify_otp', [
        \App\Http\Controllers\API\AuthController::class,
        'verifyForgotPasswordOtp'
    ]);
});

Route::prefix('property')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
        Route::post('/properties', [
            \App\Http\Controllers\API\PropertyController::class,
            'addProperty'
        ]);
        Route::post('/markfavourite', [
            \App\Http\Controllers\API\PropertyController::class,
            'markfavourite'
        ]);
        Route::get('/myFavourites', [
            \App\Http\Controllers\API\PropertyController::class,
            'myFavourites'
        ]);
        Route::post('/edit/{id}', [
            \App\Http\Controllers\API\PropertyController::class,
            'updateProperty'
        ]);
    });
});

Route::prefix('property')->group(function () {
    Route::get('/list', [
        \App\Http\Controllers\API\PropertyController::class,
        'list'
    ]);
    Route::get('/getPropertyDetail/{id}', [
        \App\Http\Controllers\API\PropertyController::class,
        'getPropertyDetail'
    ]);
});
Route::prefix('amanity')->group(function () {
    Route::get('/amenities', [
        \App\Http\Controllers\API\AmenityController::class,
        'getAmenities'
    ]);
});


Route::prefix('chats')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
        // Route::post('/send-message', [
        //     \App\Http\Controllers\API\ChatsController::class,
        //     'sendMessage'
        // ]);
        Route::get('/load-chat', [
            \App\Http\Controllers\API\ChatsController::class,
            'loadChat'
        ]);
        Route::get('/chat-list', [
            \App\Http\Controllers\API\ChatsController::class,
            'chatList'
        ]);
        Route::get('/delete-message', [
            \App\Http\Controllers\API\ChatsController::class,
            'deleteMessage'
        ]);
        Route::get('/delete-chat', [
            \App\Http\Controllers\API\ChatsController::class,
            'deleteChat'
        ]);
    });
});

Route::prefix('chats')->group(function () {
    Route::post('/send-message', [
        \App\Http\Controllers\API\ChatsController::class,
        'sendMessage'
    ]);
    Route::get('/users-list', [
        \App\Http\Controllers\API\ChatsController::class,
        'usersList'
    ]);
});
