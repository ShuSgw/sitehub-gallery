<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Category;
//同じ名前空間なので書かなくても良い

class Site extends Model
{
    // 1. ファクトリを使えるようにする（テストやダミーデータ作成用）
    use HasFactory;

    // 2. mass assignmentを許可するカラム（create/updateで安全に使える）
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'url',
        'memo',
        'og_image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
