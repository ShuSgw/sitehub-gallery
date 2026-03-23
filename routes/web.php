<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
// リクエスト（フォーム入力）を扱う
use Illuminate\Support\Facades\Auth;
// 認証（ログイン処理）を扱う

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
    // POST /login に来たリクエストを受け取り、$requestとして使える
    $credentials = $request->only('email', 'password');
    // 入力からemailとpasswordだけ取得

    if (Auth::attempt($credentials)) {
        // usersテーブルで認証→成功ならログイン状態にする
        return redirect('/dashboard'); // 成功時の遷移
    }

    return back(); // 失敗したら元のページに戻る
});
