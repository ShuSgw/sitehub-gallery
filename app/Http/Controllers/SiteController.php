<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url'  => ['required', 'url'],
        ]);

        // ログインユーザーに紐づけて保存
        Auth::user()->sites()->create([
            'name' => $request->name,
            'url'  => $request->url,
        ]);

        return redirect()->route('user.dashboard');
    }
}
