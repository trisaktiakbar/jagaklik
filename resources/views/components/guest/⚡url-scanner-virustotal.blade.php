<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $virusTotalResult = null;

    #[Reactive]
    public bool $virusTotalDetected = false;
};
?>

<div>
    @if ($virusTotalDetected)

        @php
            $vtStats = $virusTotalResult['stats'] ?? [];
        @endphp

        <div class="rounded-xl border border-rose-200 bg-white p-5 dark:border-rose-400/20 dark:bg-[#101a2b]">

            <div class="mb-4 flex items-center justify-between gap-3">

                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-virus text-lg text-blue-500"></i>
                    <h4 class="font-bold text-slate-900 dark:text-white">
                        VirusTotal
                    </h4>
                </div>

                <span
                    class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-400/20 dark:text-rose-300">
                    Ancaman Terdeteksi
                </span>

            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Berbahaya
                    </p>

                    <p class="mt-1 text-sm font-semibold text-rose-600 dark:text-rose-400">
                        {{ $vtStats['malicious'] ?? 0 }} engine
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Mencurigakan
                    </p>

                    <p class="mt-1 text-sm font-semibold text-amber-600 dark:text-amber-400">
                        {{ $vtStats['suspicious'] ?? 0 }} engine
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Tidak Berbahaya
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $vtStats['harmless'] ?? 0 }} engine
                    </p>
                </div>

            </div>

            @if (!empty($virusTotalResult['engines']) && is_array($virusTotalResult['engines']))

                <div class="mt-4">
                    <p class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                        Detection Engines
                    </p>

                    <div class="grid gap-2 sm:grid-cols-2">

                        @foreach ($virusTotalResult['engines'] as $engine)
                            @php
                                $engineStatus = strtolower($engine['result'] ?? ($engine['category'] ?? 'unrated'));

                                $statusColor = match ($engineStatus) {
                                    'malicious' => 'text-rose-600 dark:text-rose-400',
                                    'suspicious' => 'text-amber-600 dark:text-amber-400',
                                    'harmless' => 'text-emerald-600 dark:text-emerald-400',
                                    'undetected' => 'text-blue-600 dark:text-blue-400',
                                    'unrated' => 'text-slate-500 dark:text-slate-400',
                                    default => 'text-slate-600 dark:text-slate-400',
                                };
                            @endphp

                            <div class="rounded-lg bg-slate-50 p-3 dark:bg-[#0b1220]">

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $engine['engine_name'] ?? ($engine['engine'] ?? 'Unknown Engine') }}
                                </p>

                                <p class="mt-1 break-all text-sm font-semibold {{ $statusColor }}">
                                    {{ $engine['result'] ?? ($engine['category'] ?? 'Unrated') }}
                                </p>

                            </div>
                        @endforeach

                    </div>
                </div>

            @endif

            <div class="mt-4 rounded-lg bg-slate-50 p-3 dark:bg-[#0b1220]">
                <p class="text-xs leading-6 text-slate-600 dark:text-slate-400">
                    VirusTotal menggabungkan hasil analisis dari berbagai engine keamanan.
                    Hasil deteksi dapat berbeda antar-engine dan bukan merupakan kepastian bahwa
                    website telah terinfeksi.
                </p>
            </div>

        </div>

    @endif
</div>
