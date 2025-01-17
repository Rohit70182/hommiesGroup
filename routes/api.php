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
        Route::post('/delete-account', [
            \App\Http\Controllers\API\AuthController::class,
            'deleteUserAccount'
        ]);
        Route::get('/logout', [
            \App\Http\Controllers\API\AuthController::class,
            'logout'
        ]);
        Route::get('/loadPage', [
            \App\Http\Controllers\API\AuthController::class,
            'loadPage'
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
        Route::get('/list', [
            \App\Http\Controllers\API\PropertyController::class,
            'list'
        ]);
        Route::get('/nearby', [
            \App\Http\Controllers\API\PropertyController::class,
            'nearbyProperties'
        ]);
        Route::get('/listByRating', [
            \App\Http\Controllers\API\PropertyController::class,
            'listByRating'
        ]);
        Route::get('/getPropertyDetail/{id}', [
            \App\Http\Controllers\API\PropertyController::class,
            'getPropertyDetail'
        ]);
        Route::post('/deleteProperty/{id}', [
            \App\Http\Controllers\API\PropertyController::class,
            'deleteProperty'
        ]);
        Route::post('/storePropertyHistory', [
            \App\Http\Controllers\API\PropertyController::class,
            'storePropertyHistory'
        ]);
        Route::post('/markAsUnsold', [
            \App\Http\Controllers\API\PropertyController::class,
            'markAsUnsold'
        ]);
        Route::get('/user-list', [
            \App\Http\Controllers\API\PropertyController::class,
            'getUserList'
        ]);
    });
});
Route::prefix('roommate')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
        Route::post('/findRoommate', [
            \App\Http\Controllers\API\RoommateController::class,
            'findRoommate'
        ]);
        Route::get('/roommate-list', [
            \App\Http\Controllers\API\RoommateController::class,
            'roommateList'
        ]);
        Route::post('/updateRoommate/{id}', [
            \App\Http\Controllers\API\RoommateController::class,
            'updateRoommate'
        ]);
        Route::post('/markAsSold', [
            \App\Http\Controllers\API\RoommateController::class,
            'markAsSold'
        ]);
    });
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
        Route::post('/send-message', [
            \App\Http\Controllers\API\ChatsController::class,
            'sendMessage'
        ]);
        Route::get('/load-chat', [
            \App\Http\Controllers\API\ChatsController::class,
            'loadChat'
        ]);
        Route::get('/chat-list', [
            \App\Http\Controllers\API\ChatsController::class,
            'chatList'
        ]);
        Route::get('/load-new-messages', [
            \App\Http\Controllers\API\ChatsController::class,
            'loadNewMessages'
        ]);
    });
});

Route::prefix('rating')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
        Route::post('/storeRating', [
            \App\Http\Controllers\API\RatingController::class,
            'storeRating'
        ]);
    });
});
