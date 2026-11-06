<?php

namespace App\Services;

use App\Models\UrlReport;
use Throwable;

class UrlScannerService
{
    public function __construct(
        protected GoogleSafeBrowsingService $googleSafeBrowsing,
        protected UrlhausService $urlhaus,
        protected OpenPhishService $openphish,
        protected ThreatFoxService $threatfox,
        protected VirusTotalService $virusTotal,
        protected AlienVaultOtxService $alienVault,
        protected IpApiService $ipApi,
        protected WebTrustScoreService $webTrustScore,
        protected PhishuntService $phishunt,
    ) {}

    public function scan(string $url): array
    {
        $domain = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        $communityReports = UrlReport::query()
            ->where(function ($query) use ($url, $domain) {
                $query->where('url', $url)
                    ->orWhere('domain_url', $domain);
            })
            ->latest()
            ->limit(10)
            ->get()
            ->toArray();

        $google = $this->runSource(
            fn() => $this->googleSafeBrowsing->check($url),
            'Google Safe Browsing tidak dapat dihubungi saat ini.',
        );

        $urlhaus = $this->runSource(
            fn() => $this->urlhaus->check($url),
            'URLhaus tidak dapat dihubungi saat ini.',
        );

        $openphish = $this->runSource(
            fn() => $this->openphish->check($url),
            'OpenPhish tidak dapat dihubungi saat ini.',
        );

        $threatfox = $this->runSource(
            fn() => $this->threatfox->check($url),
            'ThreatFox tidak dapat dihubungi saat ini.',
        );

        $virusTotal = $this->runSource(
            fn() => $this->virusTotal->check($url),
            'VirusTotal tidak dapat dihubungi saat ini.',
        );

        $alienVault = $this->runSource(
            fn() => $this->alienVault->check($url),
            'AlienVault OTX tidak dapat dihubungi saat ini.',
        );

        $serverLocation = $this->runSource(
            fn() => $this->ipApi->lookupWebsite($url),
            'Informasi lokasi server tidak dapat diperoleh saat ini.',
        );

        $webTrustScore = [
            'result' => null,
            'scan_id' => null,
            'pending' => false,
            'error' => null,
        ];

        try {
            $response = $this->webTrustScore->scan($url);
            $data = $response['data'] ?? [];

            if ($this->webTrustScore->isPending($response)) {
                $scanId = $data['scanId'] ?? null;

                if ($scanId) {
                    $webTrustScore['scan_id'] = (string) $scanId;
                    $webTrustScore['pending'] = true;
                } else {
                    $webTrustScore['error'] =
                        'WebTrustScore belum memberikan ID pemeriksaan.';
                }
            } else {
                $webTrustScore['result'] = $data;
            }
        } catch (Throwable $e) {
            report($e);

            $webTrustScore['error'] =
                'WebTrustScore tidak dapat dihubungi saat ini.';
        }

        $phishunt = $this->runSource(
            fn() => $this->phishunt->analyze($url),
            'Phishunt tidak dapat dihubungi saat ini.',
        );

        return [
            'community_reports' => $communityReports,

            'google_result' => $google['result'],
            'google_error' => $google['error'],

            'urlhaus_result' => $urlhaus['result'],
            'urlhaus_error' => $urlhaus['error'],

            'openphish_result' => $openphish['result'],
            'openphish_error' => $openphish['error'],

            'threatfox_result' => $threatfox['result'],
            'threatfox_error' => $threatfox['error'],

            'virustotal_result' => $virusTotal['result'],
            'virustotal_error' => $virusTotal['error'],

            'alienvault_result' => $alienVault['result'],
            'alienvault_error' => $alienVault['error'],

            'server_location' => $serverLocation['result'],
            'server_location_error' => $serverLocation['error'],

            'webtrustscore_result' => $webTrustScore['result'],
            'webtrustscore_scan_id' => $webTrustScore['scan_id'],
            'webtrustscore_pending' => $webTrustScore['pending'],
            'webtrustscore_error' => $webTrustScore['error'],

            'phishunt_result' => $phishunt['result'],
            'phishunt_error' => $phishunt['error'],
        ];
    }

    private function runSource(callable $callback, string $errorMessage): array
    {
        try {
            return [
                'result' => $callback(),
                'error' => null,
            ];
        } catch (Throwable $e) {
            report($e);

            return [
                'result' => null,
                'error' => $errorMessage,
            ];
        }
    }
}
