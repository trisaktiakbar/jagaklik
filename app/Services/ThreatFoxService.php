<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ThreatFoxService
{
    private const API_URL = 'https://threatfox-api.abuse.ch/api/v1/';

    /**
     * Check URL against ThreatFox IOC database.
     */
    public function check(string $url): array
    {
        $authKey = config('services.threatfox.auth_key');

        if (empty($authKey)) {
            throw new RuntimeException(
                'ThreatFox Auth-Key belum dikonfigurasi.'
            );
        }

        $response = Http::withHeaders([
            'Auth-Key' => $authKey,
        ])
            ->acceptJson()
            ->asJson()
            ->connectTimeout(10)
            ->timeout(30)
            ->retry(2, 500)
            ->post(self::API_URL, [
                'query' => 'search_ioc',
                'search_term' => trim($url),
                'exact_match' => true,
            ]);

        $response->throw();

        $result = $response->json();

        if (
            ! is_array($result) ||
            ! isset($result['query_status'])
        ) {
            throw new RuntimeException(
                'Respons ThreatFox tidak valid.'
            );
        }

        $queryStatus = $result['query_status'];

        /*
         * IOC tidak ditemukan.
         */
        if ($queryStatus === 'no_result') {
            return $this->formatResult(
                url: $url,
                threats: [],
                status: 'not_found'
            );
        }

        /*
         * API mengembalikan status selain yang diharapkan.
         */
        if ($queryStatus !== 'ok') {
            throw new RuntimeException(
                'ThreatFox API error: ' . $queryStatus
            );
        }

        /*
         * Ambil data IOC.
         */
        $data = $result['data'] ?? [];

        if (! is_array($data)) {
            throw new RuntimeException(
                'Format data ThreatFox tidak valid.'
            );
        }

        $threats = $this->formatThreats($data);

        return $this->formatResult(
            url: $url,
            threats: $threats,
            status: count($threats) > 0
                ? 'malicious'
                : 'not_found'
        );
    }

    /**
     * Format IOC records.
     */
    private function formatThreats(array $data): array
    {
        return collect($data)
            ->filter(fn($item) => is_array($item))
            ->map(fn($item) => [
                'id' => $item['id'] ?? null,
                'ioc' => $item['ioc'] ?? null,
                'ioc_type' => $item['ioc_type'] ?? null,
                'threat_type' => $item['threat_type'] ?? null,
                'threat_type_desc' => $item['threat_type_desc'] ?? null,
                'malware' => $item['malware'] ?? null,
                'malware_alias' => $item['malware_alias'] ?? null,
                'malware_printable' => $item['malware_printable'] ?? null,
                'confidence_level' => $item['confidence_level'] ?? null,
                'first_seen' => $item['first_seen'] ?? null,
                'last_seen' => $item['last_seen'] ?? null,
                'reference' => $item['reference'] ?? null,
                'reporter' => $item['reporter'] ?? null,
                'tags' => $item['tags'] ?? [],
            ])
            ->values()
            ->all();
    }

    /**
     * Format final response.
     */
    private function formatResult(
        string $url,
        array $threats,
        string $status
    ): array {
        return [
            'is_malicious' => $status === 'malicious',
            'status' => $status,
            'url' => $url,
            'threats' => $threats,
            'threat_count' => count($threats),
            'source' => 'ThreatFox',
        ];
    }
}
