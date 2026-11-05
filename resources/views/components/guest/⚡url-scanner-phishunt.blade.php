<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $result = null;

    #[Reactive]
    public ?string $error = null;

    public function getRiskConfigProperty(): array
    {
        $risk = $this->result['live_analysis']['url_risk'] ?? null;

        return match ($risk) {
            'minimal' => [
                'label' => 'Sangat Rendah',
                'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400',
                'color' => 'text-emerald-600 dark:text-emerald-400',
            ],
            'low' => [
                'label' => 'Rendah',
                'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400',
                'color' => 'text-emerald-600 dark:text-emerald-400',
            ],
            'moderate' => [
                'label' => 'Sedang',
                'classes' => 'bg-amber-100 text-amber-700 dark:bg-amber-400/10 dark:text-amber-400',
                'color' => 'text-amber-600 dark:text-amber-400',
            ],
            'high' => [
                'label' => 'Tinggi',
                'classes' => 'bg-orange-100 text-orange-700 dark:bg-orange-400/10 dark:text-orange-400',
                'color' => 'text-orange-600 dark:text-orange-400',
            ],
            'critical' => [
                'label' => 'Kritis',
                'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-400/10 dark:text-rose-400',
                'color' => 'text-rose-600 dark:text-rose-400',
            ],
            default => [
                'label' => 'Tidak diketahui',
                'classes' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                'color' => 'text-slate-600 dark:text-slate-400',
            ],
        };
    }

    public function getVerdictConfigProperty(): array
    {
        $verdict = $this->result['verdict'] ?? null;

        return match ($verdict) {
            'likely_phishing' => [
                'label' => 'Terindikasi Phishing',
                'classes' => 'text-rose-700 bg-rose-100 dark:text-rose-400 dark:bg-rose-400/10',
                'icon' => 'fa-shield-virus',
            ],
            'no_evidence' => [
                'label' => 'Tidak Ada Indikasi Ancaman',
                'classes' => 'text-emerald-700 bg-emerald-100 dark:text-emerald-400 dark:bg-emerald-400/10',
                'icon' => 'fa-shield-check',
            ],
            default => [
                'label' => 'Tidak diketahui',
                'classes' => 'text-slate-700 bg-slate-100 dark:text-slate-300 dark:bg-slate-700',
                'icon' => 'fa-circle-question',
            ],
        };
    }

    public function getProbabilityProperty(): ?float
    {
        $probability = $this->result['probability']['p_malicious'] ?? null;

        return is_numeric($probability) ? (float) $probability * 100 : null;
    }
};
?>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-white/10 dark:bg-[#101a2b]">

    {{-- Header --}}
    <div
        class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4 dark:border-white/10">

        <div class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                <i class="fa-solid fa-fish text-lg"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                    Intelijen Phishunt
                </h3>

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Basis Data Phishing dan Analisis URL
                </p>
            </div>
        </div>

        @if ($result)
            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $this->verdictConfig['classes'] }}">
                {{ $this->verdictConfig['label'] }}
            </span>
        @elseif ($error)
            <span
                class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-400/10 dark:text-rose-400">
                Gagal
            </span>
        @else
            <span
                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                Tidak tersedia
            </span>
        @endif

    </div>

    <div class="p-5">

        @if ($error)

            <div
                class="flex items-start gap-3 rounded-xl bg-rose-50 p-4 text-sm text-rose-700 dark:bg-rose-400/10 dark:text-rose-300">
                <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                <p>{{ $error }}</p>
            </div>
        @elseif ($result)
            @php
                $analysis = $result['live_analysis'] ?? [];
                $known = $result['known'] ?? [];
                $feeds = $result['external_feeds'] ?? [];
                $probability = $result['probability'] ?? [];
                $history = $result['history'] ?? [];

                $score = $analysis['url_risk_score'] ?? null;
                $riskConfig = $this->riskConfig;

                $confidence = $result['verdict_confidence'] ?? null;

                $brandMatch = $analysis['brand_match'] ?? null;

                $why = $analysis['why'] ?? [];

                $feedNames = [
                    'openphish' => 'OpenPhish',
                    'phishtank' => 'PhishTank',
                    'tweetfeed' => 'TweetFeed',
                ];

                $confidenceLabels = [
                    'high' => 'Tinggi',
                    'medium' => 'Sedang',
                    'low' => 'Rendah',
                ];
            @endphp

            {{-- Skor Risiko --}}
            <div class="grid gap-4 sm:grid-cols-2">

                <div class="rounded-xl bg-slate-50 p-4 dark:bg-white/[0.03]">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        Skor Risiko URL
                    </p>

                    <div class="mt-2 flex items-end gap-2">
                        <span class="text-4xl font-extrabold {{ $riskConfig['color'] }}">
                            {{ is_numeric($score) ? $score : '—' }}
                        </span>

                        <span class="mb-1 text-sm text-slate-400">/ 100</span>
                    </div>

                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                        <div class="h-full rounded-full {{ str_replace('text-', 'bg-', explode(' ', $riskConfig['color'])[0]) }}"
                            style="width: {{ is_numeric($score) ? min(100, max(0, $score)) : 0 }}%">
                        </div>
                    </div>

                    <span
                        class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $riskConfig['classes'] }}">
                        {{ $riskConfig['label'] }}
                    </span>
                </div>

                <div class="rounded-xl bg-slate-50 p-4 dark:bg-white/[0.03]">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        Probabilitas URL Berbahaya
                    </p>

                    <div class="mt-2 flex items-end gap-2">
                        <span class="text-4xl font-extrabold text-slate-900 dark:text-white">
                            {{ $this->probability !== null ? round($this->probability) . '%' : '—' }}
                        </span>
                    </div>

                    <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                        Tingkat keyakinan:
                        <span class="font-semibold text-slate-700 dark:text-slate-300">
                            {{ $confidenceLabels[$confidence ?? ''] ?? 'Tidak diketahui' }}
                        </span>
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Kategori probabilitas:
                        <span class="font-semibold text-slate-700 dark:text-slate-300">
                            {{ match ($probability['band'] ?? null) {
                                'very_unlikely' => 'Sangat kecil kemungkinannya',
                                'unlikely' => 'Kecil kemungkinannya',
                                'moderate' => 'Sedang',
                                'likely' => 'Besar kemungkinannya',
                                'very_likely' => 'Sangat besar kemungkinannya',
                                default => 'Tidak diketahui',
                            } }}
                        </span>
                    </p>
                </div>

            </div>

            {{-- Catatan Basis Data Ancaman --}}
            <div class="mt-5">
                <h4 class="mb-3 text-sm font-bold text-slate-800 dark:text-white">
                    <i class="fa-solid fa-database mr-2 text-blue-500"></i>
                    Catatan Basis Data Ancaman
                </h4>

                <div class="grid gap-3 sm:grid-cols-3">

                    <div class="rounded-xl border border-slate-200 p-3 dark:border-white/10">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Daftar Ancaman Aktif
                        </p>

                        <p
                            class="mt-2 text-sm font-bold {{ $known['in_active_feed'] ?? false ? 'text-rose-600' : 'text-emerald-600' }}">
                            {{ $known['in_active_feed'] ?? false ? 'Terdaftar' : 'Tidak ditemukan' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-3 dark:border-white/10">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Riwayat Deteksi
                        </p>

                        <p
                            class="mt-2 text-sm font-bold {{ $known['previously_active'] ?? false ? 'text-rose-600' : 'text-emerald-600' }}">
                            {{ $known['previously_active'] ?? false ? 'Pernah terdeteksi' : 'Tidak ditemukan' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-3 dark:border-white/10">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Daftar Domain Baru
                        </p>

                        <p
                            class="mt-2 text-sm font-bold {{ $known['in_new_registration_feed'] ?? false ? 'text-amber-600' : 'text-emerald-600' }}">
                            {{ $known['in_new_registration_feed'] ?? false ? 'Terdaftar' : 'Tidak ditemukan' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Peniruan Identitas Merek --}}
            <div class="mt-5 rounded-xl border border-slate-200 p-4 dark:border-white/10">

                <h4 class="text-sm font-bold text-slate-800 dark:text-white">
                    <i class="fa-solid fa-fingerprint mr-2 text-blue-500"></i>
                    Peniruan Identitas Merek
                </h4>

                <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-sm text-slate-600 dark:text-slate-400">
                        Status peniruan merek
                    </span>

                    @if ($analysis['impersonation'] ?? false)
                        <span
                            class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-400/10 dark:text-rose-400">
                            Terdeteksi
                        </span>
                    @else
                        <span
                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400">
                            Tidak terdeteksi
                        </span>
                    @endif
                </div>

                @if ($brandMatch)
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                        Merek yang dicurigai:
                        <strong class="text-slate-900 dark:text-white">
                            {{ is_array($brandMatch) ? json_encode($brandMatch, JSON_UNESCAPED_UNICODE) : $brandMatch }}
                        </strong>
                    </p>
                @endif

            </div>

            {{-- Sumber Intelijen Eksternal --}}
            <div class="mt-5">
                <h4 class="mb-3 text-sm font-bold text-slate-800 dark:text-white">
                    <i class="fa-solid fa-network-wired mr-2 text-blue-500"></i>
                    Sumber Intelijen Eksternal
                </h4>

                <div class="space-y-2">

                    @foreach ($feedNames as $key => $name)
                        <div
                            class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-white/[0.03]">
                            <span class="text-sm text-slate-600 dark:text-slate-300">
                                {{ $name }}
                            </span>

                            @if (!($feeds['feeds_ok'] ?? false))
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    <i class="fa-solid fa-circle-minus mr-1"></i>
                                    Tidak tersedia
                                </span>
                            @elseif ($feeds[$key] ?? false)
                                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                    Terdaftar
                                </span>
                            @else
                                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                    <i class="fa-solid fa-circle-check mr-1"></i>
                                    Tidak terdaftar
                                </span>
                            @endif
                        </div>
                    @endforeach

                </div>

                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                    Status sumber:
                    <strong>{{ ($feeds['status'] ?? null) === 'ok' ? 'Berfungsi' : 'Tidak diketahui' }}</strong>
                    · Ketersediaan sumber:
                    <strong>{{ $feeds['feeds_ok'] ?? false ? 'Tersedia' : 'Tidak tersedia' }}</strong>
                </p>
            </div>

            {{-- Faktor Risiko --}}
            @if (count($why))
                <div class="mt-5">
                    <h4 class="mb-3 text-sm font-bold text-slate-800 dark:text-white">
                        <i class="fa-solid fa-magnifying-glass-chart mr-2 text-blue-500"></i>
                        Faktor Pemicu Risiko
                    </h4>

                    <div class="space-y-2">
                        @foreach ($why as $factor)
                            <div
                                class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-slate-200 px-4 py-3 dark:border-white/10">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ str($factor['signal'] ?? 'Tidak diketahui')->replace('_', ' ')->title() }}
                                </span>

                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ number_format((float) ($factor['points'] ?? 0), 1) }} poin
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Riwayat Domain --}}
            <div class="mt-5 rounded-xl border border-slate-200 p-4 dark:border-white/10">
                <h4 class="text-sm font-bold text-slate-800 dark:text-white">
                    <i class="fa-solid fa-clock-rotate-left mr-2 text-blue-500"></i>
                    Riwayat Domain
                </h4>

                <div class="mt-3 grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Jumlah Deteksi Sebelumnya
                        </p>

                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                            {{ $history['apex_prior_detections'] ?? 0 }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Jumlah Domain yang Diamati
                        </p>

                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                            {{ $history['apex_candidates_seen'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            <div
                class="mt-5 flex items-start gap-3 rounded-xl bg-blue-50 p-4 text-xs leading-relaxed text-blue-800 dark:bg-blue-400/10 dark:text-blue-300">
                <i class="fa-solid fa-circle-info mt-0.5"></i>

                <p>
                    Phishunt menggunakan analisis URL pasif tanpa mengunjungi website tujuan.
                    Hasil "Tidak Ada Indikasi Ancaman" bukan jaminan bahwa website sepenuhnya aman.

                </p>
            </div>

            <div class="mt-4 text-xs text-slate-400">
                Waktu pemeriksaan:
                {{ $result['meta']['analyzed_at'] ?? 'Tidak diketahui' }}
                · Versi model:
                {{ $probability['model_version'] ?? 'Tidak diketahui' }}
                ·

            </div>
        @else
            <div class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500 dark:bg-white/[0.03] dark:text-slate-400">
                Belum ada hasil pemeriksaan Phishunt.
            </div>

        @endif

    </div>

</div>
