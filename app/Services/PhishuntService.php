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
}
