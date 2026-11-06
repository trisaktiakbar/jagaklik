<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UrlScannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UrlScanController extends Controller
{
    public function __invoke(
        Request $request,
        UrlScannerService $scanner,
    ): JsonResponse {
        $validated = $request->validate([
            'url' => ['required', 'string', 'url:http,https', 'max:4000'],
        ], [
            'url.required' => 'URL wajib diisi.',
            'url.url' => 'URL harus menggunakan protokol HTTP atau HTTPS.',
            'url.max' => 'URL terlalu panjang.',
        ]);

        $url = trim($validated['url']);

        $result = $scanner->scan($url);

        $google = $result['google_result'];
        $urlhaus = $result['urlhaus_result'];
        $openphish = $result['openphish_result'];
        $threatfox = $result['threatfox_result'];
        $virusTotal = $result['virustotal_result'];
        $alienVault = $result['alienvault_result'];

        // ThreatFox detection
        $threatFoxDetected =
            ($threatfox['is_malicious'] ?? false) === true
            || (
                is_array($threatfox['threats'] ?? null)
                && count($threatfox['threats']) > 0
            );

        // VirusTotal detection
        $stats = $virusTotal['stats'] ?? [];

        $virusTotalDetected =
            ($virusTotal['is_malicious'] ?? false) === true
            || (int) ($stats['malicious'] ?? 0) > 0
            || (int) ($stats['suspicious'] ?? 0) > 0;

        // AlienVault detection
        $alienVaultDetected =
            ($alienVault['is_suspicious'] ?? false) === true
            && (int) ($alienVault['pulse_count'] ?? 0) > 0;

        // Overall malicious status
        $isMalicious =
            ($google['is_safe'] ?? true) === false
            || ($urlhaus['is_malicious'] ?? false) === true
            || ($openphish['is_phishing'] ?? false) === true
            || $threatFoxDetected
            || $virusTotalDetected;

        // Successful sources
        $successfulSources = collect([
            $google,
            $urlhaus,
            $openphish,
            $threatfox,
            $virusTotal,
            $alienVault,
        ])->filter(fn($source) => $source !== null)->count();

        // Analyzed sources
        $analyzedSources = collect([
            $google,
            $urlhaus,
            $openphish,
            $threatfox,
            $alienVault,
        ])->filter(fn($source) => $source !== null)->count();

        if (
            $virusTotal !== null
            && ($virusTotal['status'] ?? null) !== 'not_found'
        ) {
            $analyzedSources++;
        }

        // Overall status
        $overallStatus = match (true) {
            $isMalicious => 'malicious',
            $alienVaultDetected => 'suspicious',
            $successfulSources === 0 => 'unavailable',
            $analyzedSources < 6 => 'partial',
            default => 'safe',
        };

        $detectedSources = collect([
            ($google['is_safe'] ?? true) === false,
            ($urlhaus['is_malicious'] ?? false) === true,
            ($openphish['is_phishing'] ?? false) === true,
            $threatFoxDetected,
            $virusTotalDetected,
            $alienVaultDetected,
        ])->filter()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'url' => $url,
                'domain' => parse_url($url, PHP_URL_HOST),
                'status' => $overallStatus,

                'summary' => [
                    'total_sources' => 6,
                    'successful_sources' => $successfulSources,
                    'analyzed_sources' => $analyzedSources,
                    'detected_sources' => $detectedSources,
                ],

                'results' => [
                    'google' => $google,
                    'urlhaus' => $urlhaus,
                    'openphish' => $openphish,
                    'threatfox' => $threatfox,
                    'virustotal' => $virusTotal,
                    'alienvault' => $alienVault,
                    'server_location' => $result['server_location'],
                    'webtrustscore' => $result['webtrustscore_result'],
                    'webtrustscore_pending' => $result['webtrustscore_pending'],
                    'phishunt' => $result['phishunt_result'],
                    'community_reports' => $result['community_reports'],
                ],

                'errors' => [
                    'google' => $result['google_error'],
                    'urlhaus' => $result['urlhaus_error'],
                    'openphish' => $result['openphish_error'],
                    'threatfox' => $result['threatfox_error'],
                    'virustotal' => $result['virustotal_error'],
                    'alienvault' => $result['alienvault_error'],
                    'server_location' => $result['server_location_error'],
                    'webtrustscore' => $result['webtrustscore_error'],
                    'phishunt' => $result['phishunt_error'],
                ],

                'webtrustscore' => [
                    'scan_id' => $result['webtrustscore_scan_id'],
                    'pending' => $result['webtrustscore_pending'],
                ],
            ],
        ]);
    }
}
