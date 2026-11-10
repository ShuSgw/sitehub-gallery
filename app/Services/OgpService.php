<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OgpService
{
    public function fetchImageUrl(string $url): ?string
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                ->get($url);
        } catch (\Exception $e) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML('<' . '?xml encoding="UTF-8">' . $response->body());
        $xpath = new \DOMXPath($doc);
        $node = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
        return $node?->nodeValue ?: null;
    }
}
