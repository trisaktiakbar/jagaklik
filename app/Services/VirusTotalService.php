<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class VirusTotalService
{
    private const BASE_URL = 'https://www.virustotal.com/api/v3';

    public function check(string $url): array
    {
        $apiKey = config('services.virustotal.api_key');

        if (blank($apiKey)) {
            throw new RuntimeException(
                'VirusTotal API Key belum dikonfigurasi.'
            );
        }

        $urlId = rtrim(
            strtr(base64_encode($url), '+/', '-_'),
            '='
        );

        $response = Http::withHeaders([
            'x-apikey' => $apiKey,
            'Accept' => 'application/json',
        ])
            ->connectTimeout(10)
            ->timeout(30)
            ->get(self::BASE_URL . "/urls/{$urlId}");

        if ($response->status() === 404) {
            return [
                'is_malicious' => false,
                'status' => 'not_found',
                'url' => $url,
                'message' => 'Belum ditemukan laporan URL di VirusTotal.',
                'stats' => null,
                'engines' => [],
                'permalink' => null,
            ];
        }

        $response->throw();

        $attributes = $response->json('data.attributes', []);

        $stats = $attributes['last_analysis_stats'] ?? [];

        $malicious = (int) ($stats['malicious'] ?? 0);
        $suspicious = (int) ($stats['suspicious'] ?? 0);

        $engines = [];

        foreach (
            $attributes['last_analysis_results'] ?? []
            as $engine => $result
        ) {
            $engines[] = [
                'engine' => $engine,
                'category' => $result['category'] ?? 'undetected',
                'result' => $result['result'] ?? null,
            ];
        }

        return [
            'is_malicious' => $malicious > 0 || $suspicious > 0,
            'status' => 'analyzed',
            'url' => $attributes['url'] ?? $url,
            'stats' => [
                'malicious' => $malicious,
                'suspicious' => $suspicious,
                'harmless' => (int) ($stats['harmless'] ?? 0),
                'undetected' => (int) ($stats['undetected'] ?? 0),
                'timeout' => (int) ($stats['timeout'] ?? 0),
                'total' => array_sum($stats),
            ],
            'engines' => $engines,
            'permalink' => 'https://www.virustotal.com/gui/url/' . $urlId,
            'last_analysis_date' => isset($attributes['last_analysis_date'])
                ? date('Y-m-d H:i:s', $attributes['last_analysis_date'])
                : null,
        ];
    }
}
