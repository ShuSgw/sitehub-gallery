<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Site;
use App\Services\OgpService;
use App\Services\ThumService;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url'  => ['required', 'url:http,https'],
        ]);

        $images = $this->fetchImages($request->url);

        // ログインユーザーに紐づけて保存
        Auth::user()->sites()->create([
            'name' => $request->name,
            'url'  => $request->url,
            'og_image_url' => $images['og_image_url'],
            'screenshot_path' => $images['screenshot_path'],
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
        if ($request->url !== $site->url || !$site->screenshot_path) {
            $images = $this->fetchImages($request->url);
            $data['og_image_url'] = $images['og_image_url'];
            $data['screenshot_path'] = $images['screenshot_path'];
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

    private function fetchImages(string $url): array
    {
        $ogp = new OgpService();
        $thum = new ThumService();

        // サイトへのアクセスは1回だけ（OGP画像とボット確認を、まとめて調べる）
        $info = $ogp->inspect($url);

        $screenshotPath = null;
        // ボット確認が出るサイトでなければ、thum.io でスクショを作る
        if (! $info['blocked']) {
            $screenshotPath = $thum->generateThumbnail($url);
        }

        return [
            // OGP画像が無ければ null が保存される
            'og_image_url' => $info['og_image_url'],
            'screenshot_path' => $screenshotPath,
        ];
    }
}
