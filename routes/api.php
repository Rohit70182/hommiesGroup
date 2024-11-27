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
Route::prefix('user')->group(function () {
    Route::post('/register', [
        \App\Http\Controllers\API\AuthController::class,
        'register'
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

Route::prefix('favourite')->group(function () {
    Route::get('/favourites', [
        \App\Http\Controllers\API\FavouriteController::class,
        'favourites'
    ]);
    Route::post('/favourite', [
        \App\Http\Controllers\API\FavouriteController::class,
        'favourite'
    ]);
});

Route::prefix('booking')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
    Route::post('/service-provider', [
        \App\Http\Controllers\API\BookingController::class,
        'bookServiceProvider'
    ]);
    
    Route::post('/edit-cart', [
        \App\Http\Controllers\API\BookingController::class,
        'editCartItem'
    ]);
    
    Route::get('/service-provider-list', [
        \App\Http\Controllers\API\BookingController::class,
        'serviceProviders'
    ]);
    
    Route::get('/date-list', [
        \App\Http\Controllers\API\BookingController::class,
        'bookingDateList'
    ]);
    
    Route::get('/booking-list', [
        \App\Http\Controllers\API\BookingController::class,
        'bookings'
    ]);
    
    Route::get('/detail', [
        \App\Http\Controllers\API\BookingController::class,
        'bookingDetail'
    ]);
    
    Route::post('/service', [
        \App\Http\Controllers\API\BookingController::class,
        'add'
    ]);
    
    Route::post('/cancel', [
        \App\Http\Controllers\API\BookingController::class,
        'cancel'
    ]);
    
    Route::post('/service/delete', [
        \App\Http\Controllers\API\BookingController::class,
        'delete'
    ]);
    
    Route::get('/slots', [
        \App\Http\Controllers\API\BookingController::class,
        'slots'
    ]);
    
    Route::get('/cancel-reasons', [
        \App\Http\Controllers\API\BookingController::class,
        'cancelReasons'
    ]);
    
    Route::get('/cancel-reasons', [
        \App\Http\Controllers\API\BookingController::class,
        'cancelReasons'
    ]);
    
    Route::post('/book-cart', [
        \App\Http\Controllers\API\BookingController::class,
        'bookCart'
    ]);
    
    
    Route::post('/custom-request' , [
        \App\Http\Controllers\API\BookingController::class,
        'customRequest'
    ]);
    
    Route::get('/service-detail', [
        \App\Http\Controllers\API\BookingController::class,
        'serviceDetail'
    ]);
    
    Route::get('/request-detail' , [
        \App\Http\Controllers\API\BookingController::class,
        'requestDetail'
    ]);
    
    Route::post('/service-provider', [
        \App\Http\Controllers\API\BookingController::class,
        'bookServiceProvider'
    ]);
    
    Route::post('/add-cart', [
        \App\Http\Controllers\API\BookingController::class,
        'addToCart'
    ]);
    
    Route::get('/remove-cart', [
        \App\Http\Controllers\API\BookingController::class,
        'removeFromCart'
    ]);
    
    Route::get('/cart/detail', [
        \App\Http\Controllers\API\BookingController::class,
        'getCartDetail'
    ]);
    
    Route::get('/request-cancel' , [
        \App\Http\Controllers\API\BookingController::class,
        'requestCancel'
    ]);
   });
});

Route::prefix('service')->group(function () {
        Route::get('/category-list', [
            \App\Http\Controllers\API\ServiceController::class,
            'categoryList'
        ]);

        Route::get('/add-on', [
            \App\Http\Controllers\API\ServiceController::class,
            'addOnDetail'
        ]);

        Route::get('/subcategory-list', [
            \App\Http\Controllers\API\ServiceController::class,
            'subCategoryList'
        ]);
       
        Route::get('/list', [
            \App\Http\Controllers\API\ServiceController::class,
            'serviceList'
        ]);
        Route::get('/detail' , [
            \App\Http\Controllers\API\ServiceController::class,
            'serviceDetail'
        ]);
        Route::get('/coupon-list' , [
            \App\Http\Controllers\API\ServiceController::class,
            'couponList'
        ]);
        Route::get('/event-list' , [
            \App\Http\Controllers\API\ServiceController::class,
            'eventList'
        ]);
        Route::get('/event-list' , [
            \App\Http\Controllers\API\ServiceController::class,
            'eventList'
        ]);
        Route::get('/sub-services-list' , [
            \App\Http\Controllers\API\ServiceController::class,
            'subServicesList'
        ]);
        Route::get('/provider-list' , [
            \App\Http\Controllers\API\ServiceController::class,
            'providerList'
        ]);
        Route::get('/provider-detail' , [
            \App\Http\Controllers\API\ServiceController::class,
            'providerDetail'
        ]);
        Route::post('/add-price', [
            \App\Http\Controllers\API\ServiceController::class,
            'addprice'
        ])->middleware('auth:sanctum','serviceprovider', );

        Route::get('/nearby-providers' , [
            \App\Http\Controllers\API\ServiceController::class,
            'nearByProvider'
        ]);
        
});

Route::prefix('event')->group(function () {
    Route::group([
        'middleware' => [
            'auth:sanctum'
        ]
    ], function () {
        Route::post('/event-add', [
            \App\Http\Controllers\API\EventsController::class,
            'add'
        ]);
        Route::post('/event-update', [
            \App\Http\Controllers\API\EventsController::class,
            'update'
        ]);
        Route::post('/event-delete', [
            \App\Http\Controllers\API\EventsController::class,
            'delete'
        ]);
    });
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



