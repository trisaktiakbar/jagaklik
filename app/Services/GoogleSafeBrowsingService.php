<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSafeBrowsingService
{
    public function check(string $url): array
    {
        $apiKey = config('services.google.safe_browsing.api_key');

        $endpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find';

        $response = Http::connectTimeout(10)
            ->timeout(30)
            ->retry(2, 500)
            ->acceptJson()
            ->post($endpoint . '?key=' . urlencode($apiKey), [
                'client' => [
                    'clientId' => 'jagaklik',
                    'clientVersion' => '1.0.0',
                ],
                'threatInfo' => [
                    'threatTypes' => [
                        'MALWARE',
                        'SOCIAL_ENGINEERING',
                        'UNWANTED_SOFTWARE',
                        'POTENTIALLY_HARMFUL_APPLICATION',
                    ],
                    'platformTypes' => [
                        'ANY_PLATFORM',
                    ],
                    'threatEntryTypes' => [
                        'URL',
                    ],
                    'threatEntries' => [
                        ['url' => $url],
                    ],
                ],
            ]);

        $response->throw();

        $matches = $response->json('matches', []);

        return [
            'is_safe' => empty($matches),
            'status' => empty($matches) ? 'safe' : 'malicious',
            'threats' => $matches,
        ];
    }
}
