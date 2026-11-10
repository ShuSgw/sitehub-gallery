<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Site;
use App\Services\OgpService;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url'  => ['required', 'url:http,https'],
        ]);

        $ogp = new OgpService();
        // ログインユーザーに紐づけて保存
        Auth::user()->sites()->create([
            'name' => $request->name,
            'url'  => $request->url,
            'og_image_url' => $ogp->fetchImageUrl($request->url),
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

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url'  => ['required', 'url:http,https'],
        ]);

        $data = [
            'name' => $request->name,
            'url'  => $request->url,
            'memo'  => $request->memo,
            'category_id' => $request->category_id,
        ];

        // URLが変わったとき、または画像がまだないときだけ取得する
        if ($request->url !== $site->url || !$site->og_image_url) {
            $ogp = new OgpService();
            $data['og_image_url'] = $ogp->fetchImageUrl($request->url);
        }

        $site->update($data);

        return redirect()->route('user.dashboard');
    }
    public function destroy(int $id)
    {
        $site = Site::findOrFail($id);
        abort_if($site->user_id !== Auth::id(), 403);

        $site->delete();

        return redirect()->route('user.dashboard');
    }
}
