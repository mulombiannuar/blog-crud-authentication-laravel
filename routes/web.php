<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Pages\PagesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:clear');
    return 'DONE'; //Return anything
});

// Public routes
Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'homePage')->name('home');
    Route::get('blog', 'homePage')->name('blog-home');
    Route::get('blog/{post}', 'showPost')->name('show-post');
    Route::get('about', 'aboutPage')->name('about');
});

Route::middleware(['auth', 'auth.otp'])->group(function () {

    //Logged in user routes

    //Auth controller
    Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function () {
        Route::get('otp/verify', 'otpToken')->name('otp');
        Route::post('otp/verify', 'verifyOTPToken')->name('otp.verify');
    });

    //Posts routes
    Route::resource('posts', PostController::class, ['except' => ['index']]);

    // Admin routes
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('categories', CategoryController::class, ['except' => ['index']]);
            Route::controller(UserController::class)->group(function () {
                Route::put('users/photo/{user}', 'uploadPhoto')->name('users.photo');
                Route::put('users/activate/{user}',  'activateUser')->name('users.activate');
                Route::put('users/deactivate/{user}', 'deactivateUser')->name('users.deactivate');
                Route::resource('users', UserController::class, ['except' => ['index']]);
            });
        });
    });
});
