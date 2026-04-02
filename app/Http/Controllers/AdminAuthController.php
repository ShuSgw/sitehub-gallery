<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin; //Adminモデルを使う
use Illuminate\Support\Facades\Hash; //パスワードをハッシュ化・検証するためのクラス


class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }
    public function storeLogin(Request $request)
    {
        // POST /login に来たリクエストを受け取り、$requestとして使える
        $credentials = $request->only('email', 'password');
        // 入力からemailとpasswordだけ取得
        if (Auth::guard('admin')->attempt($credentials)) {
            // usersテーブルで認証→成功ならログイン状態にする
            return redirect('admin/dashboard'); // 成功時の遷移
        }
        return back();
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function showRegister()
    {
        return view('admin.register');
    }
    public function storeRegister(Request $request)
    {
        Admin::create([
            'name' => $request->input('name'), // 名前取得
            'email' => $request->input('email'), // メール取得
            'password' => Hash::make($request->input('password')),
            // パスワードはハッシュ化
        ]);
        return redirect('/login');
    }
}
