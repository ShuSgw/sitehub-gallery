<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\GreetingService;

class UserDashboardController extends Controller
{
    public function index()
    {
        /**
         * config/auth.php のガード設定に基づいてモデルを取得
         * @see config/auth.php　*/

        // 1. デフォルト: web guard → User model
        $user = Auth::user();

        // 2. 別ガード指定: admin guard → Admin model
        // $admin = Auth::guard('admin')->user();

        // このユーザーに紐づくサイト一覧を取得
        // sites() は User モデル内で定義した hasMany リレーション
        // 'sites' テーブルから user_id が一致するレコードを取得
        $sites = $user->sites()->get();

        $greetingService = new GreetingService();
        $greeting = $greetingService->get();

        return view('user.dashboard', compact('user', 'sites', 'greeting'));
    }
}
