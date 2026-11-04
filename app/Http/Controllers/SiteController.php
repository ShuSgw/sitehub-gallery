<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Site;

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
    public function edit(int $id)
    {
        $site = Site::findOrFail($id);
        // abort_if = 引数1じゃないならエラー
        abort_if($site->user_id !== Auth::id(), 403);

        $categories = Auth::user()->categories;

        return view('user.edit', compact(
            'site',
            'categories'
        ));
    }
    public function update(Request $request, int $id)
    {
        $site = Site::findOrFail($id);
        abort_if($site->user_id !== Auth::id(), 403);

        $site->update([
            'name' => $request->name,
            'url'  => $request->url,
            'memo'  => $request->memo,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('user.dashboard');
    }
}
