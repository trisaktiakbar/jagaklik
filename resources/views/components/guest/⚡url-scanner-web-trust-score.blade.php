<?php

use Livewire\Component;

new class extends Component {
    public ?array $result = null;

    public bool $pending = false;

    public ?string $error = null;
};
?>

<div class="overflow-hidden rounded-2xl border border-blue-200 bg-white dark:border-blue-400/20 dark:bg-[#101a2b]">

    {{-- Header Komponen --}}
    <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-700/70">

        <div class="flex items-center gap-3">

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                <i class="fa-solid fa-chart-line text-lg"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                    Reputasi Website
                </h3>

                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                    WebTrustScore
                </p>
            </div>

        </div>

        <span
            class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-400/10 dark:text-blue-300">
            <i class="fa-solid fa-globe"></i>
            Reputasi Website
        </span>

    </div>

    <div class="p-5">

        {{-- Sedang Diproses --}}
        @if ($pending)

            <div class="flex flex-col items-center justify-center py-7 text-center">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                    <i class="fa-solid fa-spinner fa-spin text-xl"></i>
                </div>

                <h4 class="mt-4 text-sm font-bold text-slate-800 dark:text-white">
                    Sedang Menganalisis Reputasi Website
                </h4>

                <p class="mt-2 max-w-md text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                    WebTrustScore sedang mengumpulkan informasi dan menganalisis reputasi domain.
                    Hasil akan ditampilkan secara otomatis.
                </p>

                <span
                    class="mt-4 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 dark:bg-blue-400/10 dark:text-blue-300">
                    <i class="fa-solid fa-clock"></i>
                    Menunggu hasil pemeriksaan
                </span>

            </div>

            {{-- Terjadi Kesalahan --}}
        @elseif ($error)
            <div
                class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-400/20 dark:bg-amber-400/10">

                <i class="fa-solid fa-circle-exclamation mt-0.5 text-amber-600 dark:text-amber-400"></i>

                <div>
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                        Pemeriksaan Reputasi Tidak Tersedia
                    </p>

                    <p class="mt-1 text-xs leading-relaxed text-amber-700 dark:text-amber-400">
                        {{ $error }}
                    </p>
                </div>

            </div>

            {{-- Hasil Pemeriksaan --}}
        @elseif ($result)
            @php
                $score = $result['score'] ?? null;

                $band = $result['band'] ?? null;

                $scoreColor = match (true) {
                    !is_numeric($score) => 'text-slate-500 dark:text-slate-400',
                    $score >= 800 => 'text-emerald-600 dark:text-emerald-400',
                    $score >= 700 => 'text-blue-600 dark:text-blue-400',
                    $score >= 600 => 'text-amber-600 dark:text-amber-400',
                    $score >= 500 => 'text-orange-600 dark:text-orange-400',
                    default => 'text-rose-600 dark:text-rose-400',
                };

                $bandDescription = match ($band) {
                    'Exceptional' => 'Reputasi Sangat Baik',
                    'Strong' => 'Reputasi Baik',
                    'Established' => 'Reputasi Cukup Baik',
                    'Mixed' => 'Reputasi Campuran',
                    'Concerning' => 'Perlu Diwaspadai',
                    'Dangerous' => 'Berbahaya',
                    'Critical Threat' => 'Ancaman Kritis',
                    default => $band,
                };

                $progressColor = match (true) {
                    !is_numeric($score) => 'bg-slate-400',
                    $score >= 700 => 'bg-emerald-500',
                    $score >= 500 => 'bg-amber-500',
                    default => 'bg-rose-500',
                };
            @endphp

            @if (is_numeric($score))

                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- Skor Reputasi --}}
                    <div class="flex flex-col justify-center">

                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Skor Reputasi
                        </p>

                        <div class="mt-2 flex items-baseline gap-2">

                            <span class="text-5xl font-extrabold tracking-tight {{ $scoreColor }}">
                                {{ number_format((float) $score) }}
                            </span>

                            <span class="text-sm font-medium text-slate-400">
                                / 1000
                            </span>

                        </div>

                        @if ($band)
                            <span
                                class="mt-3 inline-flex w-fit items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-400/10 dark:text-blue-300">
                                <i class="fa-solid fa-award"></i>
                                {{ $bandDescription }}
                            </span>
                        @endif

                    </div>

                    {{-- Persentase Skor --}}
                    <div class="flex flex-col justify-center">

                        <div class="flex items-center justify-between text-xs">

                            <span class="font-medium text-slate-500 dark:text-slate-400">
                                Persentase Skor
                            </span>

                            <span class="font-bold text-slate-700 dark:text-slate-200">
                                {{ number_format(min(100, max(0, (float) $score / 10)), 1) }}%
                            </span>

                        </div>

                        <div class="mt-3 h-3 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700">

                            <div class="h-full rounded-full transition-all duration-500 {{ $progressColor }}"
                                style="width: {{ min(100, max(0, (float) $score / 10)) }}%">
                            </div>

                        </div>

                        <p class="mt-3 text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                            Skor dihitung berdasarkan berbagai indikator keamanan, reputasi,
                            identitas kepemilikan, dan transparansi website.
                        </p>

                    </div>

                </div>

                {{-- Tingkat Keyakinan --}}
                @if (isset($result['confidence']))
                    <div
                        class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4 text-xs dark:border-slate-700/70">

                        <span class="text-slate-500 dark:text-slate-400">
                            Tingkat Keyakinan
                        </span>

                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ is_scalar($result['confidence']) ? $result['confidence'] : json_encode($result['confidence'], JSON_UNESCAPED_UNICODE) }}
                        </span>

                    </div>
                @endif

                {{-- Waktu Pemeriksaan --}}
                @if (isset($result['scannedAt']))
                    <div class="mt-3 flex items-center justify-between text-xs">

                        <span class="text-slate-500 dark:text-slate-400">
                            Waktu Pemeriksaan
                        </span>

                        <span class="font-medium text-slate-700 dark:text-slate-200">
                            {{ $result['scannedAt'] }}
                        </span>

                    </div>
                @endif

                {{-- Versi Model --}}
                @if (isset($result['modelVersion']))
                    <div class="mt-3 flex items-center justify-between text-xs">

                        <span class="text-slate-500 dark:text-slate-400">
                            Versi Model
                        </span>

                        <span class="font-medium text-slate-700 dark:text-slate-200">
                            {{ $result['modelVersion'] }}
                        </span>

                    </div>
                @endif
            @else
                <div class="rounded-xl bg-slate-50 p-4 text-sm text-slate-600 dark:bg-slate-800 dark:text-slate-300">

                    <i class="fa-solid fa-circle-info mr-1"></i>

                    WebTrustScore telah memberikan respons, tetapi skor reputasi belum tersedia
                    dalam format yang dikenali.

                </div>

            @endif

            {{-- Belum Ada Hasil --}}
        @else
            <div class="py-6 text-center">

                <i class="fa-solid fa-circle-info text-2xl text-slate-400"></i>

                <p class="mt-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                    Hasil reputasi belum tersedia.
                </p>

            </div>

        @endif

        {{-- Keterangan --}}
        <div class="mt-5 border-t border-slate-100 pt-4 dark:border-slate-700/70">

            <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                WebTrustScore memberikan penilaian reputasi berdasarkan sejumlah indikator website.
                Skor ini merupakan informasi tambahan dan bukan jaminan bahwa website aman atau berbahaya.
            </p>

        </div>

    </div>

</div>
