<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class UrlhausService
{
    public function check(string $url): array
    {
        $authKey = config('services.urlhaus.auth_key');

        if (blank($authKey)) {
            throw new RuntimeException('URLhaus Auth-Key belum dikonfigurasi.');
        }

        $response = Http::connectTimeout(10)
            ->timeout(30)
            ->retry(2, 500)
            ->withHeaders([
                'Auth-Key' => $authKey,
                'Accept' => 'application/json',
            ])
            ->asForm()
            ->post('https://urlhaus-api.abuse.ch/v1/url/', [
                'url' => $url,
            ]);

        $response->throw();

        $data = $response->json();

        if (($data['query_status'] ?? null) === 'no_results') {
            return [
                'is_malicious' => false,
                'status' => 'not_found',
                'url' => $url,
                'threat' => null,
            ];
        }

        if (($data['query_status'] ?? null) !== 'ok') {
            throw new RuntimeException(
                'URLhaus API error: ' . ($data['query_status'] ?? 'Unknown error')
            );
        }

        return [
            'is_malicious' => true,
            'status' => 'malicious',
            'url' => $data['url'] ?? $url,
            'threat' => [
                'id' => $data['id'] ?? null,
                'url_status' => $data['url_status'] ?? null,
                'host' => $data['host'] ?? null,
                'date_added' => $data['date_added'] ?? null,
                'threat' => $data['threat'] ?? null,
                'tags' => $data['tags'] ?? [],
                'reporter' => $data['reporter'] ?? null,
                'blacklists' => $data['blacklists'] ?? [],
            ],
        ];
    }
}
