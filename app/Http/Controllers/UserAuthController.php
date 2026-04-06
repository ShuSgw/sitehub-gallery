<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use App\Models\User; //Userモデルを使う
use Illuminate\Support\Facades\Hash; //パスワードをハッシュ化・検証するためのクラス
use Illuminate\Support\Facades\Auth; // 認証（ログイン処理）を扱う


class UserAuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function storeRegister(RegisterRequest $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect('/login');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function storeLogin(LoginRequest $request)
    {
        // $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);
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
