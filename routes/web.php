<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request; // リクエスト（フォーム入力）を扱う

use Illuminate\Support\Facades\Auth; // 認証（ログイン処理）を扱う

use App\Models\User; //Userモデルを使う

use Illuminate\Support\Facades\Hash; //パスワードをハッシュ化・検証するためのクラス

Route::get('/', function () {
    return view('home');
})->name("home");
// ログイン後
Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name("dashboard");
// 登録ページ
Route::get('/register', function () {
    return view('register');
});
// ログイン
Route::get('/login', function () {
    return view('login');
});


// ユーザー登録用ポスト
Route::post('/register', function (Request $request) {
    User::create([
        'name' => $request->input('name'), // 名前取得
        'email' => $request->input('email'), // メール取得
        'password' => Hash::make($request->input('password')),
        // パスワードはハッシュ化
    ]);
    return redirect('/login');
})->name('register');

// ログインポスト
Route::post('/login', function (Request $request) {
    // POST /login に来たリクエストを受け取り、$requestとして使える
    $credentials = $request->only('email', 'password');
    // 入力からemailとpasswordだけ取得

    if (Auth::attempt($credentials)) {
        // usersテーブルで認証→成功ならログイン状態にする
        return redirect('/dashboard'); // 成功時の遷移
    }

    return back(); // 失敗したら元のページに戻る
})->name('login');

// ログアウト用のポスト
Route::post('logout', function () {
    Auth::logout();
    return redirect('/login');
})->name("logout");
