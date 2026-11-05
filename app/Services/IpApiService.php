<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class IpApiService
{
    public function lookupWebsite(string $url): array
    {
        $host = parse_url($url, PHP_URL_HOST);

        if (!$host) {
            throw new RuntimeException('Hostname tidak valid.');
        }

        // Jika input berupa IP, gunakan langsung.
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $ips = [$host];
        } else {
            // Ambil IPv4 dari DNS.
            $records = dns_get_record($host, DNS_A);

            $ips = array_column($records ?: [], 'ip');
        }

        // Hanya izinkan IP publik.
        $ips = array_values(array_unique(array_filter(
            $ips,
            fn($ip) => filter_var(
                $ip,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            )
        )));

        if (empty($ips)) {
            throw new RuntimeException(
                'Tidak ditemukan IP publik untuk website ini.'
            );
        }

        // Gunakan IP pertama yang ditemukan.
        $ip = $ips[0];

        return Cache::remember(
            'ip_api_' . md5($ip),
            now()->addHours(24),
            function () use ($ip) {
                $response = Http::timeout(10)->get(
                    "http://ip-api.com/json/{$ip}",
                    [
                        'fields' => implode(',', [
                            'status',
                            'message',
                            'query',
                            'country',
                            'countryCode',
                            'regionName',
                            'city',
                            'lat',
                            'lon',
                            'timezone',
                            'isp',
                            'org',
                            'as',
                            'hosting',
                            'proxy',
                            'mobile',
                        ]),
                    ]
                );

                if (!$response->successful()) {
                    throw new RuntimeException(
                        'Gagal menghubungi IP-API.'
                    );
                }

                $data = $response->json();

                if (($data['status'] ?? null) !== 'success') {
                    throw new RuntimeException(
                        $data['message'] ?? 'IP lookup gagal.'
                    );
                }

                return $data;
            }
        );
    }
}
