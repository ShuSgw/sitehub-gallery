<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

// 同じ名前空間なので書かなくても良い
use App\Models\Site;
use App\Models\Category;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // 1. mass assignmentを許可するカラム
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // 2. 隠したいカラム（シリアライズ時などに非表示）
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 3. 属性の型変換
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
