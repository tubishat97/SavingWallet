<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/login', 'Auth\AuthController@showLoginForm')->name('login_form');
    Route::post('/login', 'Auth\AuthController@login')->name('login');
    Route::get('/register', 'Auth\AuthController@showRegisterForm')->name('register_form');
    Route::post('/register', 'Auth\AuthController@register')->name('register');
    Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
    Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

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

    #Roles routes
    Route::middleware(['auth:admin', 'permission:roles'])->group(function () {
        Route::get('roles/users', 'AdminRoleController@users')->name('roles.users');
        Route::get('roles/users/{user}/edit', 'AdminRoleController@usersEdit')->name('roles.users.edit');
        Route::put('roles/users/{user}/edit', 'AdminRoleController@usersUpdate')->name('roles.users.save');
        Route::resource('roles', 'AdminRoleController')->name('*', 'roles');
    });

    #Administration routes
    Route::middleware(['auth:admin', 'permission:admin management'])->group(function () {
        Route::resource('administration', 'UserController')->name('*', 'administration');
    });

    #Categories routes
    Route::middleware(['auth:admin', 'role:user'])->group(function () {
        Route::resource('category', 'CategoryController')->name('*', 'category');
    });

    #Transaction routes
    Route::middleware(['auth:admin', 'role:user'])->group(function () {
        Route::resource('transaction', 'TransactionController')->name('*', 'transaction');
    });
});
