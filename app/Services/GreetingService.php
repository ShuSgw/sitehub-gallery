<?php

namespace App\Services;

class GreetingService
{
    public function get($hour = null)
    {
        $hour = $hour ?? now()->hour;

        if ($hour >= 5 && $hour < 12) {
            return 'おはよう';
        } elseif ($hour >= 12 && $hour < 18) {
            return 'こんにちは';
        } else {
            return 'こんばんは';
        }
    }
}
