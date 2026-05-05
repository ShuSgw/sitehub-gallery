<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// 認証機能（ログイン・Auth::attemptなど）を使えるようにする基底クラス
use Illuminate\Notifications\Notifiable;
// 通知機能（メール通知など）を使えるトレイト（まだ使ってない）

class Admin extends Authenticatable
// Adminを「認証可能なユーザー」として扱う
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ]; // 一括代入（createなど）で書き込みを許可するカラム（セキュリティ対策）

    protected $hidden = [
        'password',
        'remember_token',
    ]; // JSON化や配列化したときに非表示にするカラム（APIレスポンス漏洩防止）

    // 属性の型変換（キャスト）
    // 'password' => 'hashed' を指定すると、パスワードを保存するときに
    // 自動的にハッシュ化される（平文保存を防止）
    // 例: Admin::create(['password' => 'plain']) → DB には自動でハッシュ化された値が入る
    protected $casts = [
        'password' => 'hashed',
    ];
}
