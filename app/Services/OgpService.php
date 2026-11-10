<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OgpService
{
    public function fetchImageUrl(string $url): ?string
    {

        if (! $this->isSafeUrl($url)) {
            return null;
        }

        try {
            $response = Http::timeout(10)
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

        if (! $response->successful()) {
            return null;
        }

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML('<' . '?xml encoding="UTF-8">' . $response->body());
        $xpath = new DOMXPath($doc);
        $node = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
        return $node?->nodeValue ?: null;
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
