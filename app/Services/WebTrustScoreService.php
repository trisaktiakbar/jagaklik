<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class WebTrustScoreService
{
    protected string $baseUrl = 'https://webtrustscore.com/api';

    /**
     * Memulai pemeriksaan reputasi website.
     *
     * HTTP 200: hasil pemeriksaan tersedia.
     * HTTP 202: pemeriksaan sedang diproses.
     */
    public function scan(string $url): array
    {
        $response = Http::acceptJson()
            ->asJson()
            ->timeout(30)
            ->post("{$this->baseUrl}/scan", [
                'url' => $url,
            ]);

        if (!$response->successful() && $response->status() !== 202) {
            throw new RuntimeException(
                'WebTrustScore mengembalikan HTTP ' . $response->status()
            );
        }

        return [
            'http_status' => $response->status(),
            'data' => $response->json() ?? [],
        ];
    }

    /**
     * Mengambil hasil pemeriksaan berdasarkan scan ID.
     */
    public function getResult(string $scanId): array
    {
        $response = Http::acceptJson()
            ->timeout(20)
            ->get("{$this->baseUrl}/scan/" . urlencode($scanId));

        if (!$response->successful() && $response->status() !== 202) {
            throw new RuntimeException(
                'WebTrustScore mengembalikan HTTP ' . $response->status()
            );
        }

        return [
            'http_status' => $response->status(),
            'data' => $response->json() ?? [],
        ];
    }

    /**
     * Mengambil skor terakhir yang tersimpan di cache.
     */
    public function lookup(string $domain): array
    {
        $response = Http::acceptJson()
            ->timeout(20)
            ->get("{$this->baseUrl}/lookup", [
                'domain' => $domain,
            ]);

        $response->throw();

        return $response->json() ?? [];
    }

    /**
     * Memeriksa apakah proses pemeriksaan masih berjalan.
     */
    public function isPending(array $response): bool
    {
        $data = $response['data'] ?? [];

        $status = strtolower((string) ($data['status'] ?? ''));

        return ($response['http_status'] ?? null) === 202
            || in_array($status, [
                'pending',
                'queued',
                'processing',
                'running',
                'in_progress',
            ], true);
    }
}
