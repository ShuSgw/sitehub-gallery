<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ★追加：認証チェックのため
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * リクエストが来たときに呼ばれる処理
     *
     * @param Closure(Request): (Response) $next 次の処理に進める関数
     */
    // ...$guards は「どのguardでチェックするか」を受け取る
    // 例: auth:admin のとき 'admin' が入る
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // もしguardが指定されていなければ「web」を使う
        // web = デフォルトのユーザー認証
        if (empty($guards)) {
            $guards = ['web'];
        }

        // guardごとにログイン状態をチェック
        foreach ($guards as $guard) {
            // 認証されていれば次の処理に進む
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // admin用のURLにアクセスしている場合
        // adminがログインしていなければ管理者ログイン画面に飛ばす
        if ($request->is('admin/*')) {
            return redirect()->route('admin.login');
        }

        // それ以外（普通のユーザー用）は
        // ログインしていなければユーザーログイン画面に飛ばす
        return redirect()->route('login');
    }
}
