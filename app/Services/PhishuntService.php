<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PhishuntService
{
    protected string $baseUrl = 'https://phishunt.io/api/v1';

    /**
     * Menganalisis URL menggunakan Phishunt.
     */
    public function analyze(string $url): array
    {
        $response = Http::acceptJson()
            ->withUserAgent('JagaKlik/1.0')
            ->timeout(45)
            ->get("{$this->baseUrl}/analyze", [
                'url' => $url,
            ]);

        $response->throw();

        $data = $response->json();

        if (! is_array($data)) {
            throw new RuntimeException('Respons Phishunt tidak valid.');
        }

        return $data;
    }

    public function getDomains(
        int $limit = 50,
        int $offset = 0,
        ?string $contains = null
    ): array {
        $params = [
            'limit' => min(max($limit, 1), 1000),
            'offset' => max($offset, 0),
        ];

        if (filled($contains)) {
            $params['contains'] = $contains;
        }

        $response = Http::acceptJson()
            ->withUserAgent('JagaKlik/1.0')
            ->timeout(30)
            ->retry(2, 500)
            ->get("{$this->baseUrl}/domains", $params);

        $response->throw();

        $data = $response->json();

        if (
            ! is_array($data) ||
            ! isset($data['results']) ||
            ! is_array($data['results'])
        ) {
            throw new RuntimeException('Respons daftar domain Phishunt tidak valid.');
        }

        return $data;
    }
}
