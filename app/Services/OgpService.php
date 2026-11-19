<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

use RuntimeException;

class OgpService
{
    // URLにアクセスして、レスポンスを返す（安全でないURLや、通信失敗のときは null）
    private function fetch(string $url): ?Response
    {
        if (! $this->isSafeUrl($url)) {
            return null;
        }

        try {
            return Http::timeout(10)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                ->withOptions([
                    'allow_redirects' => [
                        'max' => 3,
                        'on_redirect' => function ($request, $response, $uri) {
                            if (! $this->isSafeUrl((string) $uri)) {
                                throw new RuntimeException('unsafe redirect');
                            }
                        },
                    ],
                ])
                ->get($url);
        } catch (Exception $e) {
            return null;
        }
    }

    public function fetchImageUrl(string $url): ?string
    {
        $response = $this->fetch($url);

        if (! $response || ! $response->successful()) {
            return null;
        }

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML('<' . '?xml encoding="UTF-8">' . $response->body());
        $xpath = new DOMXPath($doc);
        $node = $xpath->query('//meta[@property="og:image"]/@content')->item(0);

        return $node?->nodeValue ?: null;
    }

    // サイトに1回だけアクセスして、OGP画像とボット確認の有無をまとめて返す
    public function inspect(string $url): array
    {
        $response = $this->fetch($url);

        // 取得できなかったとき（安全でないURL、通信失敗）
        if (! $response) {
            return ['og_image_url' => null, 'blocked' => false];
        }

        // Cloudflare のボット確認が出ているか
        $blocked = $response->header('cf-mitigated') === 'challenge';

        // OGP画像を探す（200番台のときだけ）
        $ogImageUrl = null;
        if ($response->successful()) {
            libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->loadHTML('<' . '?xml encoding="UTF-8">' . $response->body());
            $xpath = new DOMXPath($doc);
            $node = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
            $ogImageUrl = $node?->nodeValue ?: null;
        }

        return ['og_image_url' => $ogImageUrl, 'blocked' => $blocked];
    }


    public function isBotChallenge(string $url): bool
    {
        $response = $this->fetch($url);

        return $response?->header('cf-mitigated') === 'challenge';
    }

    // アクセスしてよいURLか確認する（内部のアドレスは拒否）
    private function isSafeUrl(string $url): bool
    {
        $parts = parse_url($url);

        if (! $parts || ! isset($parts['scheme'], $parts['host'])) {
            return false;
        }

        if (! in_array($parts['scheme'], ['http', 'https'], true)) {
            return false;
        }

        $ips = gethostbynamel($parts['host']);
        if (! $ips) {
            return false;
        }

        foreach ($ips as $ip) {
            if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return false;
            }
        }

        return true;
    }
}
