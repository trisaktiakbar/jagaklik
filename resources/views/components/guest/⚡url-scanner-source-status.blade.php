<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $googleResult = null;

    #[Reactive]
    public ?string $googleError = null;

    #[Reactive]
    public ?array $urlhausResult = null;

    #[Reactive]
    public ?string $urlhausError = null;

    #[Reactive]
    public ?array $openphishResult = null;

    #[Reactive]
    public ?string $openphishError = null;

    #[Reactive]
    public ?array $threatfoxResult = null;

    #[Reactive]
    public ?string $threatfoxError = null;

    #[Reactive]
    public bool $threatFoxDetected = false;

    #[Reactive]
    public ?array $virusTotalResult = null;

    #[Reactive]
    public ?string $virusTotalError = null;

    #[Reactive]
    public bool $virusTotalDetected = false;

    #[Reactive]
    public ?array $alienVaultResult = null;

    #[Reactive]
    public ?string $alienVaultError = null;

    #[Reactive]
    public bool $alienVaultDetected = false;
};
?>

<div>
    <div class="mb-4">

        <h3 class="text-base font-bold text-slate-900 dark:text-white">
            <i class="fa-solid fa-magnifying-glass-chart mr-2 text-blue-500"></i>
            Informasi Pemeriksaan
        </h3>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Informasi mengenai sumber dan hasil pemeriksaan.
        </p>

    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">

        <div
            class="flex flex-col gap-2 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">

            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                    <i class="fa-brands fa-google"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        Google Safe Browsing
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Malware, social engineering, unwanted software, dan aplikasi berbahaya
                    </p>
                </div>
            </div>

            @if ($googleError)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Tidak Tersedia
                </span>
            @elseif (($googleResult['is_safe'] ?? true) === false)
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-circle-xmark mr-1"></i>
                    {{ count($googleResult['threats'] ?? []) }} ancaman ditemukan
                </span>
            @elseif ($googleResult !== null)
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Tidak ditemukan ancaman
                </span>
            @else
                <span class="text-xs font-semibold text-slate-500">
                    Belum tersedia
                </span>
            @endif

        </div>

        <div
            class="flex flex-col gap-2 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">

            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 dark:bg-cyan-400/10 dark:text-cyan-400">
                    <i class="fa-solid fa-database"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        URLhaus
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Pemeriksaan URL distribusi malware
                    </p>
                </div>
            </div>

            @if ($urlhausError)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Tidak Tersedia
                </span>
            @elseif (($urlhausResult['is_malicious'] ?? false) === true)
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-circle-xmark mr-1"></i>
                    Ancaman ditemukan
                </span>
            @elseif ($urlhausResult !== null)
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Tidak ditemukan ancaman
                </span>
            @else
                <span class="text-xs font-semibold text-slate-500">
                    Belum tersedia
                </span>
            @endif

        </div>

        <div
            class="flex flex-col gap-2 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">

            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 dark:bg-cyan-400/10 dark:text-cyan-400">
                    <i class="fa-solid fa-fish"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        OpenPhish
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Pemeriksaan URL phishing berdasarkan Community Feed
                    </p>
                </div>
            </div>

            @if ($openphishError)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Tidak Tersedia
                </span>
            @elseif (($openphishResult['is_phishing'] ?? false) === true)
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-circle-xmark mr-1"></i>
                    Phishing ditemukan
                </span>
            @elseif ($openphishResult !== null)
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Tidak ditemukan ancaman
                </span>
            @else
                <span class="text-xs font-semibold text-slate-500">
                    Belum tersedia
                </span>
            @endif

        </div>

        <div
            class="flex flex-col gap-2 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">

            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                    <i class="fa-solid fa-bug"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        ThreatFox
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Pemeriksaan malware dan Indicators of Compromise (IOC)
                    </p>
                </div>
            </div>

            @if ($threatfoxError)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Tidak Tersedia
                </span>
            @elseif ($threatFoxDetected)
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-circle-xmark mr-1"></i>
                    {{ $threatfoxResult['threat_count'] ?? count($threatfoxResult['threats'] ?? []) }}
                    IOC ditemukan
                </span>
            @elseif ($threatfoxResult !== null)
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Tidak ditemukan ancaman
                </span>
            @else
                <span class="text-xs font-semibold text-slate-500">
                    Belum tersedia
                </span>
            @endif

        </div>

        <div
            class="flex flex-col gap-2 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">

            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                    <i class="fa-solid fa-virus"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        VirusTotal
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Analisis URL menggunakan berbagai security engine
                    </p>
                </div>
            </div>

            @if ($virusTotalError)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Tidak Tersedia
                </span>
            @elseif ($virusTotalDetected)
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-circle-xmark mr-1"></i>
                    Ancaman ditemukan
                </span>
            @elseif (($virusTotalResult['status'] ?? null) === 'not_found')
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Belum dianalisis
                </span>
            @elseif ($virusTotalResult !== null)
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Tidak ditemukan ancaman
                </span>
            @else
                <span class="text-xs font-semibold text-slate-500">
                    Belum tersedia
                </span>
            @endif

        </div>

        {{-- AlienVault OTX --}}
        <div class="flex flex-col gap-2 p-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-400">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        AlienVault OTX
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Threat Intelligence, Threat Pulses, dan Indicators of Compromise
                    </p>
                </div>
            </div>

            @if ($alienVaultError)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    Tidak Tersedia
                </span>
            @elseif ($alienVaultDetected)
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                    {{ $alienVaultResult['pulse_count'] ?? 0 }} laporan ditemukan
                </span>
            @elseif (($alienVaultResult['status'] ?? null) === 'not_found')
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                    <i class="fa-solid fa-circle-minus mr-1"></i>
                    Indikator tidak ditemukan
                </span>
            @elseif ($alienVaultResult !== null)
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Tidak ditemukan laporan ancaman
                </span>
            @else
                <span class="text-xs font-semibold text-slate-500">
                    Belum tersedia
                </span>
            @endif

        </div>

    </div>
</div>
