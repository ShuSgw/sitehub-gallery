<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ScreenshotLog extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'success',
    ];

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->startOfMonth());
    }
}
