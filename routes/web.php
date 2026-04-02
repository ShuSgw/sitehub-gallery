<?php

use Illuminate\Support\Facades\Route;

use App\http\Controllers\UserDashboardController;
use App\http\Controllers\UserAuthController;
use App\http\Controllers\AdminAuthController;
use App\http\Controllers\AdminDashboardController;

use Illuminate\Support\Facades\Hash; //パスワードをハッシュ化・検証するためのクラス

Route::get('/', function () {
    return view('home');
})->name("home");

Route::controller(UserAuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        // 登録ページ
        Route::get('/register', 'showRegister');
        // 登録保存
        Route::post('/register', 'storeRegister')->name('register');
        // ログイン
        Route::get('/login', 'showLogin');
        // ログインポスト
        Route::post('/login', 'storeLogin')->name('login');
    });

    // ログアウト
    Route::post('/logout', 'logout')->name('logout');
});

// ユーザー管理画面
Route::controller(UserDashboardController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/user/dashboard', 'index')->name("user.dashboard");
    });
});

Route::controller(AdminAuthController::class)->group(function () {
    // アドミンログインページ
    Route::get('admin/login', 'showLogin')->name('admin.login');
    // アドミンログインポスト
    Route::post('admin/login', 'storeLogin')->name('admin.login');
    // アドミンログアウト
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
