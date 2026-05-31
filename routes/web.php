<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('home');
})->name("home");

Route::controller(UserAuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        // 登録ページ
        Route::get('/register', 'showRegister')
            ->name('register.form');
        // 登録保存
        Route::post('/register', 'storeRegister')
            ->middleware('throttle:3,1')
            ->name('register.store');
        // ログイン
        Route::get('/login', 'showLogin')
            ->name('user.login');
        // ログインポスト
        Route::post('/login', 'storeLogin')
            ->middleware('throttle:3,1')
            ->name('login.store');
    });

    Route::post('/logout', 'logout')->name('logout');
});

// ユーザー管理画面
Route::controller(UserDashboardController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/user/dashboard', 'index')
            ->name("user.dashboard");
    });
});

// サイト系
Route::controller(SiteController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::post('/sites', 'store')
            ->name('sites.store');
        Route::get('/sites/{site}/edit', 'edit')
            ->name('sites.edit');
        Route::patch('/sites/{id}/', 'update')
            ->name('sites.update');
    });
});



Route::controller(AdminAuthController::class)->group(function () {
    // アドミンログインページ
    Route::get('admin/login', 'showLogin')->name('admin.login');
    // アドミンログインポスト
    Route::post('admin/login', 'storeLogin')
        ->middleware('throttle:3,1')
        ->name('admin.store');
    Route::post('admin/logout', 'logout')->name('admin.logout');

    // 登録ページ
    // Route::get(
    //     'admin/register',
    //     'showRegister'
    // )->name('admin.register');
    // アドミン登録用ポスト
    // Route::post(
    //     'admin/register',
    //     'storeRegister'
    // )->name('admin.register');
});

Route::controller(AdminDashboardController::class)->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/dashboard', 'index')->name("admin.dashboard");
    });
});
