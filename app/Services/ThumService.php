<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThumService
{
    // URL生成
    public function buildUrl(string $url): string
    {
        $keyId = config('services.thumio.key_id');
        $secret = config('services.thumio.secret');

        // 5分後の時刻（ミリ秒）
        $expires = (int) (microtime(true) * 1000) + 300 * 1000;

        $hash = md5($secret . $expires . $url);

        // thumb.ioの指定のURL生成
        return 'https://image.thum.io/get/auth/' . $keyId . '-' . $expires . '-' . $hash . '/' . $url;
    }

    // スクリーンショットを取得して storage に保存し、保存先のパスを返す（失敗したら null）
    public function generateThumbnail(string $url): ?string
    {
        try {
            // buildUrl() で署名付きURLを作り、thum.io から画像を取得する
            // スクリーンショットの生成には時間がかかることがあるので、30秒まで待つ
            $response = Http::timeout(30)->get($this->buildUrl($url));
        } catch (Exception $e) {
            // 通信に失敗（タイムアウトなど）しても、エラーで止めず null を返す
            return null;
        }

        // ステータスが 200 番台（成功）でなければ、保存せず null を返す
        if (! $response->successful()) {
            return null;
        }

        // 画像以外（エラーの文章など）が返ってきたときは保存しない
        // Content-Type が "image/" で始まるものだけを、画像として扱う
        if (! str_starts_with((string) $response->header('Content-Type'), 'image/')) {
            return null;
        }

        // 保存先のパスを作る（例: screenshots/aBc123....png）
        // ランダムな名前にして、他のサイトのファイルと重ならないようにする
        $path = 'screenshots/' . Str::random(40) . '.png';

        // storage/app/public/ の下に、画像データ（$response->body()）を保存する
        Storage::disk('public')->put($path, $response->body());

        // DB に記録するため、保存先のパスを返す
        return $path;
    }
}
// 