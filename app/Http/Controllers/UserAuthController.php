<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; //Userモデルを使う
use Illuminate\Support\Facades\Hash; //パスワードをハッシュ化・検証するためのクラス
use Illuminate\Support\Facades\Auth; // 認証（ログイン処理）を扱う


class UserAuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }
    public function storeRegister(Request $request)
    {
        User::create([
            'name' => $request->input('name'), // 名前取得
            'email' => $request->input('email'), // メール取得
            'password' => Hash::make($request->input('password')),
            // パスワードはハッシュ化
        ]);
        return redirect('/login');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function storeLogin(Request $request)
    {
        // POST /login に来たリクエストを受け取り、$requestとして使える
        $credentials = $request->only('email', 'password');
        // 入力からemailとpasswordだけ取得

        if (Auth::attempt($credentials)) {
            // usersテーブルで認証→成功ならログイン状態にする
            return redirect('user/dashboard'); // 成功時の遷移
        }

        return back(); // 失敗したら元のページに戻る
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
