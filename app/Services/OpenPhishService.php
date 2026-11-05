<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenPhishService
{
    private const FEED_URL =
    'https://raw.githubusercontent.com/openphish/public_feed/refs/heads/main/feed.txt';

    private const CACHE_KEY = 'openphish.community_feed';

    public function check(string $url): array
    {
        $phishingUrls = $this->getFeed();

        $normalizedUrl = $this->normalizeUrl($url);

        $matchedUrl = null;

        foreach ($phishingUrls as $phishingUrl) {
            if ($this->normalizeUrl($phishingUrl) === $normalizedUrl) {
                $matchedUrl = $phishingUrl;
                break;
            }
        }

        $isPhishing = $matchedUrl !== null;

        return [
            'is_phishing' => $isPhishing,
            'status' => $isPhishing ? 'phishing' : 'not_found',
            'url' => $url,
            'matched_url' => $matchedUrl,
            'source' => 'OpenPhish Community Feed',
            'feed_count' => count($phishingUrls),
        ];
    }

    private function getFeed(): array
    {
        return Cache::remember(
            self::CACHE_KEY,
            now()->addHours(12),
            function (): array {
                $response = Http::connectTimeout(10)
                    ->timeout(30)
                    ->retry(2, 500)
                    ->accept('text/plain')
                    ->get(self::FEED_URL);

                $response->throw();

                $urls = preg_split(
                    '/\r\n|\r|\n/',
                    $response->body()
                );

                $urls = array_filter(
                    array_map('trim', $urls),
                    fn($url) => filter_var(
                        $url,
                        FILTER_VALIDATE_URL
                    ) !== false
                );

                if (empty($urls)) {
                    throw new RuntimeException(
                        'OpenPhish feed kosong atau tidak valid.'
                    );
                }

                return array_values(array_unique($urls));
            }
        );
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);

        return preg_replace_callback(
            '~^(https?)://([^/?#]+)~i',
            function ($matches) {
                return strtolower($matches[1])
                    . '://'
                    . strtolower($matches[2]);
            },
            $url
        );
    }
}
