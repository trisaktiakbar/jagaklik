<?php

use App\Services\GoogleSafeBrowsingService;
use App\Services\UrlhausService;
use App\Services\OpenPhishService;
use App\Services\ThreatFoxService;
use App\Services\VirusTotalService;
use App\Services\AlienVaultOtxService;
use App\Services\IpApiService;
use App\Services\WebTrustScoreService;
use App\Services\PhishuntService;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Models\UrlReport;
use App\Models\UrlScan;

new class extends Component {
    public string $url = '';

    public ?string $sharedUrl = null;

    #[Locked]
    public string $scannedUrl = '';

    #[Locked]
    public ?array $googleResult = null;

    #[Locked]
    public ?array $urlhausResult = null;

    #[Locked]
    public ?array $openphishResult = null;

    #[Locked]
    public ?array $threatfoxResult = null;

    #[Locked]
    public ?array $virusTotalResult = null;

    #[Locked]
    public ?array $alienVaultResult = null;

    #[Locked]
    public ?array $serverLocation = null;

    /*
    |--------------------------------------------------------------------------
    | WebTrustScore
    |--------------------------------------------------------------------------
    */

    #[Locked]
    public ?array $webTrustScoreResult = null;

    #[Locked]
    public ?string $webTrustScoreScanId = null;

    #[Locked]
    public ?string $webTrustScoreError = null;

    #[Locked]
    public bool $webTrustScorePending = false;

    #[Locked]
    public ?int $savedScanId = null;

    /*
    |--------------------------------------------------------------------------
    | Phishunt
    |--------------------------------------------------------------------------
    */

    #[Locked]
    public ?array $phishuntResult = null;

    #[Locked]
    public ?string $phishuntError = null;

    /*
    |--------------------------------------------------------------------------
    | Source Errors
    |--------------------------------------------------------------------------
    */

    #[Locked]
    public ?string $googleError = null;

    #[Locked]
    public ?string $urlhausError = null;

    #[Locked]
    public ?string $openphishError = null;

    #[Locked]
    public ?string $threatfoxError = null;

    #[Locked]
    public ?string $virusTotalError = null;

    #[Locked]
    public ?string $alienVaultError = null;

    #[Locked]
    public ?string $serverLocationError = null;

    #[Locked]
    public bool $hasScanned = false;

    #[Locked]
    public array $communityReports = [];


    public function mount(): void
    {
        if (! is_string($this->sharedUrl)) {
            return;
        }

        $url = trim($this->sharedUrl);

        if (
            filter_var($url, FILTER_VALIDATE_URL) &&
            in_array(
                strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''),
                ['http', 'https'],
                true
            )
        ) {
            $this->url = $url;
        }
    }


    public function scan(GoogleSafeBrowsingService $googleSafeBrowsing, UrlhausService $urlhaus, OpenPhishService $openphish, ThreatFoxService $threatfox, VirusTotalService $virusTotal, AlienVaultOtxService $alienVault, IpApiService $ipApi, WebTrustScoreService $webTrustScore, PhishuntService $phishunt): void
    {
        $this->resetValidation();

        $this->reset(['scannedUrl', 'googleResult', 'urlhausResult', 'openphishResult', 'threatfoxResult', 'virusTotalResult', 'alienVaultResult', 'serverLocation', 'webTrustScoreResult', 'webTrustScoreScanId', 'webTrustScoreError', 'webTrustScorePending', 'savedScanId', 'phishuntResult', 'phishuntError', 'googleError', 'urlhausError', 'openphishError', 'threatfoxError', 'virusTotalError', 'alienVaultError', 'serverLocationError', 'hasScanned', 'communityReports']);

        $validated = Validator::make(
            ['url' => trim($this->url)],
            [
                'url' => ['bail', 'required', 'url:http,https', 'max:4000'],
            ],
            [
                'url.required' => 'Silakan masukkan URL website terlebih dahulu.',
                'url.url' => 'URL tidak valid. Gunakan alamat website dengan http:// atau https://.',
                'url.max' => 'URL terlalu panjang.',
            ],
        )->validate();

        $this->scannedUrl = $validated['url'];

        $domain = strtolower(parse_url($this->scannedUrl, PHP_URL_HOST) ?? '');

        /*
        |--------------------------------------------------------------------------
        | Community Reports
        |--------------------------------------------------------------------------
        */

        $this->communityReports = UrlReport::query()
            ->where(function ($query) use ($domain) {
                $query->where('url', $this->scannedUrl)->orWhere('domain_url', $domain);
            })
            ->latest()
            ->limit(10)
            ->get()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Google Safe Browsing
        |--------------------------------------------------------------------------
        */

        try {
            $this->googleResult = $googleSafeBrowsing->check($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->googleError = 'Google Safe Browsing tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | URLhaus
        |--------------------------------------------------------------------------
        */

        try {
            $this->urlhausResult = $urlhaus->check($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->urlhausError = 'URLhaus tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | OpenPhish
        |--------------------------------------------------------------------------
        */

        try {
            $this->openphishResult = $openphish->check($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->openphishError = 'OpenPhish tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | ThreatFox
        |--------------------------------------------------------------------------
        */

        try {
            $this->threatfoxResult = $threatfox->check($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->threatfoxError = 'ThreatFox tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | VirusTotal
        |--------------------------------------------------------------------------
        */

        try {
            $this->virusTotalResult = $virusTotal->check($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->virusTotalError = 'VirusTotal tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | AlienVault OTX
        |--------------------------------------------------------------------------
        */

        try {
            $this->alienVaultResult = $alienVault->check($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->alienVaultError = 'AlienVault OTX tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | IP-API: Server Location & Network Information
        |--------------------------------------------------------------------------
        */

        try {
            $this->serverLocation = $ipApi->lookupWebsite($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->serverLocationError = 'Informasi lokasi server tidak dapat diperoleh saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | WebTrustScore: Website Reputation
        |--------------------------------------------------------------------------
        */

        $this->startWebTrustScoreScan($webTrustScore);

        /*
        |--------------------------------------------------------------------------
        | Phishunt: Phishing Intelligence
        |--------------------------------------------------------------------------
        */

        try {
            $this->phishuntResult = $phishunt->analyze($this->scannedUrl);
        } catch (\Throwable $e) {
            report($e);

            $this->phishuntError = 'Phishunt tidak dapat dihubungi saat ini.';
        }

        /*
        |--------------------------------------------------------------------------
        | Save Scan History
        |--------------------------------------------------------------------------
        */

        $this->hasScanned = true;

        $this->saveScanHistory();
    }

    /*
    |--------------------------------------------------------------------------
    | Start WebTrustScore Scan
    |--------------------------------------------------------------------------
    */

    private function startWebTrustScoreScan(WebTrustScoreService $service): void
    {
        try {
            $response = $service->scan($this->scannedUrl);

            $data = $response['data'] ?? [];

            if ($service->isPending($response)) {
                $scanId = $data['scanId'] ?? null;

                if (!$scanId) {
                    $this->webTrustScoreError = 'WebTrustScore belum memberikan ID pemeriksaan.';

                    return;
                }

                $this->webTrustScoreScanId = (string) $scanId;

                $this->webTrustScorePending = true;

                return;
            }

            $this->webTrustScoreResult = $data;
        } catch (\Throwable $e) {
            report($e);

            $this->webTrustScoreError = 'WebTrustScore tidak dapat dihubungi saat ini.';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Poll WebTrustScore Result
    |--------------------------------------------------------------------------
    */

    public function pollWebTrustScore(WebTrustScoreService $service): void
    {
        if (!$this->webTrustScorePending || !$this->webTrustScoreScanId) {
            return;
        }

        try {
            $response = $service->getResult($this->webTrustScoreScanId);

            if ($service->isPending($response)) {
                return;
            }

            $this->webTrustScoreResult = $response['data'] ?? [];

            $this->webTrustScorePending = false;

            $this->webTrustScoreScanId = null;

            $this->updateSavedScanWebTrustScore();
        } catch (\Throwable $e) {
            report($e);

            $this->webTrustScoreError = 'Hasil pemeriksaan WebTrustScore gagal diperoleh.';

            $this->webTrustScorePending = false;

            $this->webTrustScoreScanId = null;

            $this->updateSavedScanWebTrustScore();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update Existing Scan History
    |--------------------------------------------------------------------------
    */

    private function updateSavedScanWebTrustScore(): void
    {
        if (!$this->savedScanId) {
            return;
        }

        $scan = UrlScan::find($this->savedScanId);

        if (!$scan) {
            return;
        }

        $results = (array) $scan->results;

        $results['webtrustscore'] = $this->webTrustScoreResult;

        $results['errors']['webtrustscore'] = $this->webTrustScoreError;

        $results['webtrustscore_pending'] = $this->webTrustScorePending;

        $scan->update([
            'results' => $results,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ThreatFox Detection
    |--------------------------------------------------------------------------
    */

    public function getThreatFoxDetectedProperty(): bool
    {
        if (($this->threatfoxResult['is_malicious'] ?? false) === true) {
            return true;
        }

        return is_array($this->threatfoxResult['threats'] ?? null) && count($this->threatfoxResult['threats']) > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | VirusTotal Detection
    |--------------------------------------------------------------------------
    */

    public function getVirusTotalDetectedProperty(): bool
    {
        if (($this->virusTotalResult['is_malicious'] ?? false) === true) {
            return true;
        }

        $stats = $this->virusTotalResult['stats'] ?? [];

        return (int) ($stats['malicious'] ?? 0) > 0 || (int) ($stats['suspicious'] ?? 0) > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | AlienVault Detection
    |--------------------------------------------------------------------------
    */

    public function getAlienVaultDetectedProperty(): bool
    {
        return ($this->alienVaultResult['is_suspicious'] ?? false) === true && (int) ($this->alienVaultResult['pulse_count'] ?? 0) > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Overall Malicious Status
    |--------------------------------------------------------------------------
    */

    public function getIsMaliciousProperty(): bool
    {
        return ($this->googleResult['is_safe'] ?? true) === false || ($this->urlhausResult['is_malicious'] ?? false) === true || ($this->openphishResult['is_phishing'] ?? false) === true || $this->threatFoxDetected || $this->virusTotalDetected;
    }

    /*
    |--------------------------------------------------------------------------
    | Successful Sources
    |--------------------------------------------------------------------------
    */

    public function getSuccessfulSourcesProperty(): int
    {
        return (int) ($this->googleResult !== null) + (int) ($this->urlhausResult !== null) + (int) ($this->openphishResult !== null) + (int) ($this->threatfoxResult !== null) + (int) ($this->virusTotalResult !== null) + (int) ($this->alienVaultResult !== null);
    }

    /*
    |--------------------------------------------------------------------------
    | Analyzed Sources
    |--------------------------------------------------------------------------
    */

    public function getAnalyzedSourcesProperty(): int
    {
        $count = 0;

        $count += (int) ($this->googleResult !== null);

        $count += (int) ($this->urlhausResult !== null);

        $count += (int) ($this->openphishResult !== null);

        $count += (int) ($this->threatfoxResult !== null);

        $count += (int) ($this->alienVaultResult !== null);

        if ($this->virusTotalResult !== null && ($this->virusTotalResult['status'] ?? null) !== 'not_found') {
            $count++;
        }

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | Overall Status
    |--------------------------------------------------------------------------
    */

    public function getOverallStatusProperty(): string
    {
        if ($this->isMalicious) {
            return 'malicious';
        }

        if ($this->alienVaultDetected) {
            return 'suspicious';
        }

        if ($this->successfulSources === 0) {
            return 'unavailable';
        }

        if ($this->analyzedSources < 6) {
            return 'partial';
        }

        return 'safe';
    }

    /*
    |--------------------------------------------------------------------------
    | Save Scan History
    |--------------------------------------------------------------------------
    */

    private function saveScanHistory(): void
    {
        $detectedSources = [($this->googleResult['is_safe'] ?? true) === false, ($this->urlhausResult['is_malicious'] ?? false) === true, ($this->openphishResult['is_phishing'] ?? false) === true, $this->threatFoxDetected, $this->virusTotalDetected, $this->alienVaultDetected];

        $scan = UrlScan::create([
            'url' => $this->scannedUrl,

            'domain' => strtolower(parse_url($this->scannedUrl, PHP_URL_HOST) ?? ''),

            'status' => $this->overallStatus,

            // Tetap enam sumber Threat Intelligence.
            // WebTrustScore dan Phishunt merupakan pemeriksaan tambahan.
            'total_sources' => 6,

            'successful_sources' => $this->successfulSources,

            'detected_sources' => count(array_filter($detectedSources)),

            'results' => [
                'google_safe_browsing' => $this->googleResult,

                'urlhaus' => $this->urlhausResult,

                'openphish' => $this->openphishResult,

                'threatfox' => $this->threatfoxResult,

                'virustotal' => $this->virusTotalResult,

                'alienvault_otx' => $this->alienVaultResult,

                'server_location' => $this->serverLocation,

                'webtrustscore' => $this->webTrustScoreResult,

                'webtrustscore_scan_id' => $this->webTrustScoreScanId,

                'webtrustscore_pending' => $this->webTrustScorePending,

                // Phishunt
                'phishunt' => $this->phishuntResult,

                'errors' => [
                    'google' => $this->googleError,

                    'urlhaus' => $this->urlhausError,

                    'openphish' => $this->openphishError,

                    'threatfox' => $this->threatfoxError,

                    'virustotal' => $this->virusTotalError,

                    'alienvault' => $this->alienVaultError,

                    'server_location' => $this->serverLocationError,

                    'webtrustscore' => $this->webTrustScoreError,

                    'phishunt' => $this->phishuntError,
                ],
            ],

            'scanned_at' => now(),
        ]);

        $this->savedScanId = $scan->id;
    }
};
?>

<section class="relative overflow-hidden bg-slate-50 py-20 dark:bg-[#0b1220]">

    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-blue-400/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-cyan-400/10 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- Section Heading --}}
        <livewire:guest.url-scanner-header />

        {{-- Scanner Card --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50 dark:border-slate-700/70 dark:bg-[#101a2b] dark:shadow-black/10">

            {{-- Card Header --}}
            <livewire:guest.url-scanner-card-header />

            <div class="p-6 sm:p-8" x-data="jagaklikQrScanner">

                {{-- Scan Form --}}
                <form wire:submit="scan">

                    {{-- Input Mode --}}
                    <livewire:guest.url-scanner-input-mode />

                    <livewire:guest.url-scanner-url-input wire:model="url" />

                    <livewire:guest.url-scanner-qr-input wire:model="url" />

                    @error('url')
                    <p class="mt-2 text-sm text-rose-500">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror

                    <button type="submit" wire:loading.attr="disabled" wire:target="scan"
                        :disabled="mode === 'qr' && (!decodedUrl || decoding)"
                        class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:shadow-blue-500/30 disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="scan">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i>
                            Periksa Tautan
                        </span>

                        <span wire:loading wire:target="scan">
                            <i class="fa-solid fa-spinner fa-spin mr-1"></i>
                            Sedang Memeriksa...
                        </span>

                    </button>

                </form>

                <div wire:loading.remove wire:target="scan">

                    @if ($googleError && $urlhausError && $openphishError && $threatfoxError && $virusTotalError && $alienVaultError)
                    <div
                        class="mt-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700 dark:border-rose-400/20 dark:bg-rose-400/10 dark:text-rose-300">

                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>

                        Semua sumber pemeriksaan tidak tersedia.
                        Silakan coba kembali nanti.

                    </div>
                    @endif

                    @if ($hasScanned)

                    <div class="mt-8 space-y-6">

                        @php
                        $status = $this->overallStatus;

                        $statusConfig = match ($status) {
                        'malicious' => [
                        'icon' => 'fa-shield-virus',
                        'title' => 'Ancaman Berhasil Terdeteksi!',
                        'description' =>
                        'URL ini terindikasi memiliki aktivitas berbahaya berdasarkan satu atau beberapa sumber intelijen.',
                        'badge' => 'Berbahaya',
                        'classes' =>
                        'border-rose-200 bg-rose-50 dark:border-rose-400/20 dark:bg-rose-400/10',
                        'iconClasses' =>
                        'bg-rose-100 text-rose-600 dark:bg-rose-400/20 dark:text-rose-400',
                        'titleClasses' => 'text-rose-700 dark:text-rose-400',
                        'badgeClasses' =>
                        'bg-rose-100 text-rose-700 dark:bg-rose-400/20 dark:text-rose-300',
                        ],

                        'suspicious' => [
                        'icon' => 'fa-shield-halved',
                        'title' => 'Aktivitas Mencurigakan Ditemukan',
                        'description' =>
                        'AlienVault OTX menemukan laporan Threat Intelligence yang berkaitan dengan URL ini. Temuan tersebut perlu diperiksa lebih lanjut dan belum menjadi bukti pasti bahwa URL berbahaya.',
                        'badge' => 'Mencurigakan',
                        'classes' =>
                        'border-amber-200 bg-amber-50 dark:border-amber-400/20 dark:bg-amber-400/10',
                        'iconClasses' =>
                        'bg-amber-100 text-amber-600 dark:bg-amber-400/20 dark:text-amber-400',
                        'titleClasses' => 'text-amber-700 dark:text-amber-400',
                        'badgeClasses' =>
                        'bg-amber-100 text-amber-700 dark:bg-amber-400/20 dark:text-amber-300',
                        ],

                        'safe' => [
                        'icon' => 'fa-shield-check',
                        'title' => 'Tidak Ditemukan Ancaman',
                        'description' =>
                        'Keenam sumber intelijen tidak menemukan indikasi ancaman pada URL ini. Namun, hasil tersebut tidak menjamin website sepenuhnya aman.',
                        'badge' => 'Tidak Ditemukan Ancaman',
                        'classes' =>
                        'border-emerald-200 bg-emerald-50 dark:border-emerald-400/20 dark:bg-emerald-400/10',
                        'iconClasses' =>
                        'bg-emerald-100 text-emerald-600 dark:bg-emerald-400/20 dark:text-emerald-400',
                        'titleClasses' => 'text-emerald-700 dark:text-emerald-400',
                        'badgeClasses' =>
                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-400/20 dark:text-emerald-300',
                        ],

                        'partial' => [
                        'icon' => 'fa-circle-exclamation',
                        'title' => 'Pemeriksaan Sebagian',
                        'description' =>
                        'Sebagian sumber intelijen belum memberikan hasil pemeriksaan yang lengkap. Hasil yang tersedia belum cukup untuk menyimpulkan bahwa URL ini aman.',
                        'badge' => 'Belum Lengkap',
                        'classes' =>
                        'border-amber-200 bg-amber-50 dark:border-amber-400/20 dark:bg-amber-400/10',
                        'iconClasses' =>
                        'bg-amber-100 text-amber-600 dark:bg-amber-400/20 dark:text-amber-400',
                        'titleClasses' => 'text-amber-700 dark:text-amber-400',
                        'badgeClasses' =>
                        'bg-amber-100 text-amber-700 dark:bg-amber-400/20 dark:text-amber-300',
                        ],

                        default => [
                        'icon' => 'fa-triangle-exclamation',
                        'title' => 'Pemeriksaan Tidak Tersedia',
                        'description' =>
                        'Semua sumber intelijen gagal memberikan hasil pemeriksaan. Silakan coba kembali nanti.',
                        'badge' => 'Tidak Tersedia',
                        'classes' =>
                        'border-slate-200 bg-slate-50 dark:border-slate-600 dark:bg-slate-800',
                        'iconClasses' =>
                        'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                        'titleClasses' => 'text-slate-700 dark:text-slate-300',
                        'badgeClasses' =>
                        'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                        ],
                        };

                        $webTrustScore = $webTrustScoreResult['score'] ?? null;

                        $webTrustBand = $webTrustScoreResult['band'] ?? null;

                        $webTrustScoreColor = match (true) {
                        !is_numeric($webTrustScore) => 'text-slate-500 dark:text-slate-400',
                        $webTrustScore >= 800 => 'text-emerald-600 dark:text-emerald-400',
                        $webTrustScore >= 700 => 'text-blue-600 dark:text-blue-400',
                        $webTrustScore >= 600 => 'text-amber-600 dark:text-amber-400',
                        $webTrustScore >= 500 => 'text-orange-600 dark:text-orange-400',
                        default => 'text-rose-600 dark:text-rose-400',
                        };

                        $webTrustBandDescription = match ($webTrustBand) {
                        'Exceptional' => 'Reputasi Sangat Baik',
                        'Strong' => 'Reputasi Baik',
                        'Established' => 'Reputasi Cukup Baik',
                        'Mixed' => 'Reputasi Campuran',
                        'Concerning' => 'Perlu Diwaspadai',
                        'Dangerous' => 'Berbahaya',
                        'Critical Threat' => 'Ancaman Kritis',
                        default => $webTrustBand,
                        };
                        @endphp

                        {{-- Result Summary --}}
                        <livewire:guest.url-scanner-result-summary :statusConfig="$statusConfig" :scannedUrl="$scannedUrl"
                            :successfulSources="$this->successfulSources" :analyzedSources="$this->analyzedSources" />

                        {{-- Server Information --}}
                        <livewire:guest.url-scanner-server-information :server-location="$serverLocation" :server-location-error="$serverLocationError" />

                        {{-- WebTrustScore Polling --}}
                        @if ($webTrustScorePending)
                        <div wire:poll.3s="pollWebTrustScore" class="hidden"></div>
                        @endif

                        {{-- Website Reputation --}}
                        <livewire:guest.url-scanner-web-trust-score :result="$webTrustScoreResult" :pending="$webTrustScorePending"
                            :error="$webTrustScoreError" />


                        {{-- Threat Information --}}
                        @if ($this->isMalicious || $this->alienVaultDetected)
                        <div class="space-y-4">

                            <div>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white">
                                    <i class="fa-solid fa-bug mr-2 text-rose-500"></i>
                                    Informasi Ancaman
                                </h3>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Detail ancaman yang ditemukan oleh sumber intelijen.
                                </p>
                            </div>

                            <livewire:guest.url-scanner-google-safe-browsing :google-result="$googleResult" />

                            <livewire:guest.url-scanner-urlhaus :urlhaus-result="$urlhausResult" />

                            <livewire:guest.url-scanner-openphish :openphish-result="$openphishResult" />

                            <livewire:guest.url-scanner-threatfox :threatfox-result="$threatfoxResult" :threat-fox-detected="$this->threatFoxDetected" />

                            <livewire:guest.url-scanner-virustotal :virus-total-result="$virusTotalResult" :virus-total-detected="$this->virusTotalDetected" />

                            <livewire:guest.url-scanner-alienvault :alien-vault-result="$alienVaultResult" :alien-vault-detected="$this->alienVaultDetected" />

                        </div>
                        @endif

                        {{-- Phishunt Intelligence --}}
                        <livewire:guest.url-scanner-phishunt :result="$phishuntResult" :error="$phishuntError" />


                        {{-- Individual Source Status --}}
                        <livewire:guest.url-scanner-source-status :google-result="$googleResult" :google-error="$googleError"
                            :urlhaus-result="$urlhausResult" :urlhaus-error="$urlhausError" :openphish-result="$openphishResult" :openphish-error="$openphishError"
                            :threatfox-result="$threatfoxResult" :threatfox-error="$threatfoxError" :threat-fox-detected="$this->threatFoxDetected" :virus-total-result="$virusTotalResult"
                            :virus-total-error="$virusTotalError" :virus-total-detected="$this->virusTotalDetected" :alien-vault-result="$alienVaultResult" :alien-vault-error="$alienVaultError"
                            :alien-vault-detected="$this->alienVaultDetected" />

                        {{-- Community Reports --}}
                        <livewire:guest.url-scanner-community-report :community-reports="$communityReports" />

                        {{-- Disclaimer --}}
                        <livewire:guest.url-scanner-disclaimer />

                    </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- Trust Information --}}
        <livewire:guest.url-scanner-bottom-trust-indicator />

    </div>

</section>

@script
<script>
    Alpine.data('jagaklikQrScanner', () => ({
        mode: 'url',

        previewUrl: null,
        fileName: '',
        decodedUrl: '',

        decoding: false,
        errorMessage: '',

        /**
         * Mengganti metode input URL atau QR Code.
         */
        switchMode(mode) {
            this.mode = mode;
            this.errorMessage = '';
        },

        /**
         * Membaca gambar dan mengekstrak URL dari QR Code.
         */
        async decodeFile(event) {
            const file = event.target.files?.[0];

            this.errorMessage = '';
            this.decodedUrl = '';

            if (!file) {
                return;
            }

            this.clearPreview();

            this.fileName = '';

            const allowedTypes = [
                'image/png',
                'image/jpeg',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                this.errorMessage =
                    'Format gambar tidak didukung. Gunakan PNG, JPG, atau WEBP.';

                event.target.value = '';

                await this.$wire.set('url', '');

                return;
            }

            const maxSize = 5 * 1024 * 1024;

            if (file.size > maxSize) {
                this.errorMessage =
                    'Ukuran gambar maksimal 5 MB.';

                event.target.value = '';

                await this.$wire.set('url', '');

                return;
            }

            this.previewUrl = URL.createObjectURL(file);
            this.fileName = file.name;
            this.decoding = true;

            try {
                if (typeof window.jsQR === 'undefined') {
                    throw new Error(
                        'Library QR Code belum berhasil dimuat. Silakan muat ulang halaman.'
                    );
                }

                const image = new Image();

                image.src = this.previewUrl;

                await new Promise((resolve, reject) => {
                    image.onload = resolve;

                    image.onerror = () => {
                        reject(new Error('Gambar tidak dapat dibaca.'));
                    };
                });

                const maxPixels = 25000000;

                if (
                    image.naturalWidth * image.naturalHeight >
                    maxPixels
                ) {
                    throw new Error(
                        'Resolusi gambar terlalu besar. Gunakan gambar dengan resolusi lebih kecil.'
                    );
                }

                const canvas = document.createElement('canvas');

                const context = canvas.getContext('2d', {
                    willReadFrequently: true
                });

                if (!context) {
                    throw new Error(
                        'Browser tidak mendukung pemrosesan gambar.'
                    );
                }

                canvas.width = image.naturalWidth;
                canvas.height = image.naturalHeight;

                context.drawImage(
                    image,
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );

                const imageData = context.getImageData(
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );

                const result = window.jsQR(
                    imageData.data,
                    imageData.width,
                    imageData.height, {
                        inversionAttempts: 'attemptBoth'
                    }
                );

                if (!result || !result.data) {
                    throw new Error(
                        'QR Code tidak ditemukan. Pastikan gambar QR Code jelas dan tidak terpotong.'
                    );
                }

                const extractedData = result.data.trim();

                let parsedUrl;

                try {
                    parsedUrl = new URL(extractedData);
                } catch {
                    throw new Error(
                        'QR Code berhasil dibaca, tetapi tidak berisi URL yang valid.'
                    );
                }

                if (!['http:', 'https:'].includes(parsedUrl.protocol)) {
                    throw new Error(
                        'QR Code bukan berisi URL website HTTP atau HTTPS.'
                    );
                }

                if (!parsedUrl.hostname) {
                    throw new Error(
                        'Alamat website dalam QR Code tidak valid.'
                    );
                }

                this.decodedUrl = extractedData;

                await this.$wire.set('url', this.decodedUrl);

            } catch (error) {
                this.errorMessage = error.message ||
                    'Terjadi kesalahan saat membaca QR Code.';

                this.decodedUrl = '';

                await this.$wire.set('url', '');

            } finally {
                this.decoding = false;
            }
        },

        /**
         * Membersihkan preview gambar.
         */
        clearPreview() {
            if (this.previewUrl) {
                URL.revokeObjectURL(this.previewUrl);
                this.previewUrl = null;
            }
        },

        /**
         * Menghapus gambar dan hasil pembacaan QR Code.
         */
        async clearFile() {
            this.clearPreview();

            this.fileName = '';
            this.decodedUrl = '';
            this.errorMessage = '';

            const input = document.getElementById('qr-image');

            if (input) {
                input.value = '';
            }

            await this.$wire.set('url', '');
        },

        destroy() {
            this.clearPreview();
        }
    }));
</script>
@endscript