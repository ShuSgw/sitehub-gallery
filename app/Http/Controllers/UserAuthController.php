<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use App\Models\User; //Userモデルを使う
use Illuminate\Support\Facades\Hash; //パスワードをハッシュ化・検証するためのクラス
use Illuminate\Support\Facades\Auth; // 認証（ログイン処理）を扱う

use App\Services\TelegramService;


class UserAuthController extends Controller
{
    // Telegram 通知用のクラスを保存する変数
    private $telegram;
    // public function __construct($telegram)  ← 何の型でもOK、曖昧
    public function __construct(TelegramService $telegram)
    {
        // 受け取った TelegramService を保存 → メソッド内で使える
        $this->telegram = $telegram;
    }

    public function showRegister()
    {
        return view('user.register');
    }

    public function storeRegister(RegisterRequest $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('user.login');
    }

    public function showLogin()
    {
        return view('user.login');
    }

    public function storeLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // セッション固定化攻撃対策：
            // ログイン成功後、古いセッション ID を破棄して新しいセッション ID を生成
            // 攻撃者が事前に設定したセッション ID が無効化される
            $request->session()->regenerate();

            // 成功時：ユーザー情報を含めて Telegram に通知
            $this->telegram->notifyLoginSuccess(Auth::user());
            return redirect()->route('user.dashboard');
        }

        // ログイン失敗時：IP と時刻だけを通知（メール情報は含めない）
        // これにより、有効なメールアドレスの特定を防ぐ
        $this->telegram->notifyLoginFailure();
        return back();
    }

    public function logout(Request $request)
    {
        // ユーザーをログアウト
        Auth::logout();

        // セッション内の全データを破棄
        // ログアウト後にセッションデータが残ってしまう問題を防止
        $request->session()->invalidate();

        // 新しい CSRF トークンを生成
        // 前のセッションの CSRF トークンが使われることを防止
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
