<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LoggerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Components\CommentComponentController;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Mail;

Route::get('sitemap', function () {
    SitemapGenerator::create('http://localhost/demo-service-yii2-1836')->writeToFile('sitemap.xml');
    return "sitemap created";
});
    
//Components
Route::post('/dashboard/comment', [CommentComponentController::class, 'store']);

//Landing Page
Route::get('/', [HomeController::class, 'welcome']);
Route::get('/home', [HomeController::class, 'home']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/privacy', [HomeController::class, 'privacy']);
Route::get('/terms', [HomeController::class, 'terms']);
Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password')->middleware('auth');



//Auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/sign-in', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register/signup', [RegisterController::class, 'signup']);
// Route::post('/mail', [RegisterController::class, 'mail']);
Route::get('/password-reset/{token}', [
    App\Http\Controllers\UserController::class,
    'resetPassword'
]);
Route::post('/password-reset/{token}', [
    App\Http\Controllers\UserController::class,
    'updateUserPassword'
]);

Route::get('/verify-email/{email}', [RegisterController::class, 'verifyEmail']);


Route::middleware('auth')->group(function () {
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
    Route::prefix('dashboard')->group(function () {
        //Dashboard Route Section
        Route::get('/', [DashboardController::class, 'dashboard']);
        Route::post('/change-password', [DashboardController::class, 'changePassword']);
        Route::get('/myprofile', [UserProfileController::class, 'show']);
        Route::get('/myprofile/edit/{id}', [UserProfileController::class, 'edit']);
        Route::put('/myprofile/update/{id}', [UserProfileController::class, 'update']);
        //Users
        Route::get('/users', [UserActivityController::class, 'users']);
        Route::get('/user/add', [UserController::class, 'add']);
        Route::view('user/add', 'dashboard.user-management.adduser');
        Route::post('/user/add', [UserController::class, 'addUser']);
        Route::get('/users/delete/{id}', [UserController::class, 'delete']);
        Route::get('/users/softDelete/{id}', [UserController::class, 'softDelete']);
        Route::get('/users/edit/{id}', [UserController::class, 'edit']);
        Route::put('/users/update/{id}', [UserController::class, 'update']);
        Route::get('/users/show/{id}', [UserController::class, 'show']);
    });


    Route::middleware('admin')->group(function () {

        Route::get('services', [DashboardController::class, 'displaylogs']);
        
        Route::get('cancel-reasons', [DashboardController::class, 'cancelReasons'])->name('cancelReasons');
        Route::get('cancel-reasons/edit/{id}', [DashboardController::class, 'editcancelReasons'])->name('editcancelReasons');
        Route::put('cancel-reasons/update/{id}', [DashboardController::class, 'updatecancelReasons'])->name('updatereason');
        Route::get('cancel-reasons/show/{id}', [DashboardController::class, 'showcancelReasons'])->name('showreason');
        Route::get('cancel-reasons/delete/{id}', [DashboardController::class, 'deletecancelReasons'])->name('deletereason');
        Route::get('cancel-reasons/create', [DashboardController::class, 'createcancelReasons'])->name('createreason');
        Route::post('cancel-reasons/save', [DashboardController::class, 'storecancelReasons'])->name('storereason');
        Route::get('orders', [DashboardController::class, 'orders'])->name('orders');
        Route::get('orders/show/{id}', [DashboardController::class, 'showOrders'])->name('order.show');
        
        //Files
        Route::get('files', [DashboardController::class, 'Showfiles']);

        //Backup
        Route::get('dashboard/backup', [BackupController::class, 'show']);
        Route::get('backup/create', [BackupController::class, 'backup']);
        Route::get('backup/download/{filename}', [BackupController::class, 'download']);
        Route::get('backup/delete/{filename}', [BackupController::class, 'Delete']);
        Route::get('backup/restore/{filename}', [BackupController::class, 'restore']);

        //User Activity
        Route::get('logActivity', [UserActivityController::class, 'logActivity']);
        Route::get('deleteLogs', [UserActivityController::class, 'deleteAll']);
        Route::get('/logActivity/delete/{id}', [UserActivityController::class, 'delete']);
        Route::get('/logActivity/softDelete/{id}', [UserActivityController::class, 'softDelete']);

        Route::get('/logActivity/logShow/{id}', [UserActivityController::class, 'show']);

        //log profiler
        Route::get('logs', [LoggerController::class, 'index']);

        //upload pictures
        Route::get('open', [ImageUploadController::class, 'showUploadPage']);
        Route::post('upload', [ImageUploadController::class, 'fileUpload']);

        
        //Error logs
        Route::get('dashboard/logs', [LoggerController::class, 'logs']);
        Route::get('dashboad/logs/delete/{id}', [LoggerController::class, 'destroy']);
        Route::get('testOpen', [EventController::class, 'blade']);
        Route::get('/event/list', [EventController::class, 'index']);
        Route::get('/event/add', [EventController::class, 'create' ]);
        Route::get('edit/{id}', [EventController::class, 'edit']);
        Route::post('/event/store', [EventController::class, 'store' ]);
        Route::get('show/{id}', [EventController::class, 'show']);
        Route::post('update/{id}', [EventController::class, 'update' ]);
        Route::get('delete/{id}', [EventController::class, 'destroy']);
        Route::get('softDelete/{id}', [EventController::class, 'softDelete']);

    });
    
});
