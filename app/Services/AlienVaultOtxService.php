<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use RuntimeException;

class AlienVaultOtxService
{
    protected string $baseUrl = 'https://otx.alienvault.com/api/v1';

    /**
     * Check URL against AlienVault OTX.
     */
    public function check(string $url): array
    {
        $apiKey = config('services.alienvault.api_key');

        if (empty($apiKey)) {
            throw new RuntimeException(
                'AlienVault OTX API Key belum dikonfigurasi.'
            );
        }

        try {
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-OTX-API-KEY' => $apiKey,
                ])
                ->timeout(30)
                ->get(
                    $this->baseUrl . '/indicators/url/'
                        . rawurlencode($url) . '/general'
                );

            if ($response->status() === 404) {
                return $this->emptyResult(
                    $url,
                    'Indikator URL tidak ditemukan di AlienVault OTX.'
                );
            }

            if ($response->failed()) {
                throw new RuntimeException(
                    'AlienVault OTX API mengembalikan HTTP '
                        . $response->status() . '.'
                );
            }

            $data = $response->json();

            if (!is_array($data)) {
                throw new RuntimeException(
                    'Respons AlienVault OTX tidak valid.'
                );
            }

            return $this->formatResult($url, $data);
        } catch (ConnectionException $e) {
            throw new RuntimeException(
                'Tidak dapat terhubung ke AlienVault OTX.',
                previous: $e
            );
        }
    }

    /**
     * Format API response.
     */
    protected function formatResult(
        string $url,
        array $data
    ): array {
        $pulseInfo = $data['pulse_info'] ?? [];

        $pulses = is_array($pulseInfo['pulses'] ?? null)
            ? $pulseInfo['pulses']
            : [];

        $pulseCount = (int) ($pulseInfo['count'] ?? count($pulses));

        $formattedPulses = [];

        foreach (array_slice($pulses, 0, 10) as $pulse) {
            if (!is_array($pulse)) {
                continue;
            }

            $formattedPulses[] = [
                'id' => $pulse['id'] ?? null,
                'name' => $pulse['name'] ?? 'Unknown Threat',
                'description' => $pulse['description'] ?? null,
                'author' => $pulse['author_name'] ?? null,
                'created' => $pulse['created'] ?? null,
                'modified' => $pulse['modified'] ?? null,
                'tags' => is_array($pulse['tags'] ?? null)
                    ? $pulse['tags']
                    : [],
                'references' => is_array($pulse['references'] ?? null)
                    ? $pulse['references']
                    : [],
                'adversary' => $pulse['adversary'] ?? null,
                'malware_families' => is_array(
                    $pulse['malware_families'] ?? null
                ) ? $pulse['malware_families'] : [],
                'targeted_countries' => is_array(
                    $pulse['targeted_countries'] ?? null
                ) ? $pulse['targeted_countries'] : [],
            ];
        }

        $isSuspicious = $pulseCount > 0;

        return [
            'is_suspicious' => $isSuspicious,

            'url' => $data['indicator'] ?? $url,

            'type' => $data['type'] ?? 'URL',

            'reputation' => $data['reputation'] ?? null,

            'pulse_count' => $pulseCount,

            'pulses' => $formattedPulses,

            'message' => $isSuspicious
                ? 'Ditemukan laporan ancaman terkait URL ini di AlienVault OTX.'
                : 'Tidak ditemukan laporan ancaman terkait URL ini.',

            'status' => 'analyzed',
        ];
    }

    /**
     * Return empty result when indicator is not found.
     */
    protected function emptyResult(
        string $url,
        string $message
    ): array {
        return [
            'is_suspicious' => false,
            'url' => $url,
            'type' => 'URL',
            'reputation' => null,
            'pulse_count' => 0,
            'pulses' => [],
            'message' => $message,
            'status' => 'not_found',
        ];
    }
}
