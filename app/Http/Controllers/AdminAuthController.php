<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;


class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function storeLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // セッション固定化攻撃対策：
            // ログイン成功後、古いセッション ID を破棄して新しいセッション ID を生成
            // 攻撃者が事前に設定したセッション ID が無効化される
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back();
    }

    public function logout(Request $request)
    {
        // 管理者をログアウト（admin guard を使用）
        Auth::guard('admin')->logout();

        // セッション内の全データを破棄
        // ログアウト後にセッションデータが残ってしまう問題を防止
        $request->session()->invalidate();

        // 新しい CSRF トークンを生成
        // 前のセッションの CSRF トークンが使われることを防止
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // public function showRegister()
    // {
    //     return view('admin.register');
    // }

    // public function storeRegister(Request $request)
    // {
    //     Admin::create([
    //         'name' => $request->input('name'), // 名前取得
    //         'email' => $request->input('email'), // メール取得
    //         'password' => Hash::make($request->input('password')),
    //         // パスワードはハッシュ化
    //     ]);
    //     return redirect('/login');
    // }
}
