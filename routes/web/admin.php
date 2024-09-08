<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/login', 'Auth\AuthController@showLoginForm')->name('login_form');
    Route::post('/login', 'Auth\AuthController@login')->name('login');
    // Route::get('/register', 'Auth\AuthController@showRegisterForm')->name('register_form');
    // Route::post('/register', 'Auth\AuthController@register')->name('register');
    // Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
    // Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
    // Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
    // Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

        #Admin profile routes
        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::post('/profile/update', 'UserController@updateProfile')->name('profile.update');
    });

    #Administration routes
    Route::middleware(['auth:admin', 'permission:admin management'])->group(function () {
        Route::resource('administration', 'UserController')->name('*', 'administration');
    });

    Route::resource('product', 'ProductController')->name('*', 'product');
    Route::resource('order', 'OrderController')->name('*', 'order');

    Route::get('/product/{product}/increment', [ProductController::class, 'incrementQuantityShow'])->name('product.increment-qty-show');
    Route::put('/product/{product}/increment', [ProductController::class, 'incrementQuantity'])->name('product.increment-qty');
    Route::get('/history', [ProductController::class, 'log'])->name('product.log');
});
