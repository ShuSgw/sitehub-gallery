<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Telegram に通知を送るためのクラス
class TelegramService
{
    private $token;
    private $chatId;

    // クラスが作成されるときに自動で実行される
    public function __construct()
    {
        // config 経由で取得する（config:cache 後は env() が null を返すため）
        $this->token = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    // $message の内容を Telegram に送信するメソッド
    public function sendMessage($message)
    {
        try {
            // Telegram API にメッセージを送信してレスポンスを取得
            $response = Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            // APIが成功しなかった場合（HTTPステータスが200-299でない場合）
            if (!$response->successful()) {
                // エラー内容をログに記録して、ログイン処理は続行
                Log::warning('Telegram API returned error', [
                    'status' => $response->status(),  // HTTPステータスコード
                    'body' => $response->json(),       // API からのエラーメッセージ
                ]);
            }
        } catch (\Exception $e) {
            // ネットワーク接続エラーなど、予期しないエラーが発生した場合
            // エラー情報をログに記録して、ログイン処理は続行
            Log::error('Failed to send Telegram message', [
                'error' => $e->getMessage(),   // エラーメッセージ
                'message' => $message,          // 送信しようとしたメッセージ
            ]);
        }
    }

    // ログイン成功を通知
    public function notifyLoginSuccess($user)
    {
        $ip = request()->ip();
        $this->sendMessage(
            "✅ <b>ログイン成功</b>\n" .
                "ユーザー: {$user->name}\n" .
                "メール: {$user->email}\n" .
                "IP: {$ip}\n" .
                "時刻: " . now()->format('Y-m-d H:i:s')
        );
    }

    // ログイン失敗を通知（メール情報は含めない）
    public function notifyLoginFailure()
    {
        $ip = request()->ip();
        $this->sendMessage(
            "❌ <b>ログイン失敗</b>\n" .
                "IP: {$ip}\n" .
                "時刻: " . now()->format('Y-m-d H:i:s')
        );
    }
}
