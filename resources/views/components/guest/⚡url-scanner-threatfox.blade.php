<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $threatfoxResult = null;

    #[Reactive]
    public bool $threatFoxDetected = false;
};
?>

<div>
    @if ($threatFoxDetected)

        <div class="rounded-xl border border-rose-200 bg-white p-5 dark:border-rose-400/20 dark:bg-[#101a2b]">

            <div class="mb-4 flex items-center justify-between gap-3">

                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-bug text-lg text-blue-500"></i>
                    <h4 class="font-bold text-slate-900 dark:text-white">
                        ThreatFox
                    </h4>
                </div>

                <span
                    class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-400/20 dark:text-rose-300">
                    Malware IOC Terdeteksi
                </span>

            </div>

            <div class="mb-4 grid gap-4 sm:grid-cols-2">

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Jumlah Ancaman
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $threatfoxResult['threat_count'] ?? count($threatfoxResult['threats'] ?? []) }}
                        IOC
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Status Deteksi
                    </p>

                    <p class="mt-1 text-sm font-semibold text-rose-600 dark:text-rose-400">
                        Berbahaya
                    </p>
                </div>

            </div>

            @foreach ($threatfoxResult['threats'] ?? [] as $index => $threat)
                <div class="{{ !$loop->first ? 'mt-5 border-t border-slate-200 pt-5 dark:border-slate-700' : '' }}">

                    <p class="mb-3 text-sm font-semibold text-slate-700 dark:text-slate-300">
                        IOC #{{ $index + 1 }}
                    </p>

                    <div class="grid gap-4 sm:grid-cols-2">

                        @foreach ([
        'ID Ancaman' => $threat['id'] ?? null,
        'Jenis IOC' => $threat['ioc_type'] ?? null,
        'Jenis Ancaman' => $threat['threat_type_desc'] ?? ($threat['threat_type'] ?? null),
        'Malware' => $threat['malware_printable'] ?? ($threat['malware'] ?? null),
        'Tingkat Kepercayaan' => isset($threat['confidence_level']) ? $threat['confidence_level'] . '%' : null,
        'Pelapor' => $threat['reporter'] ?? null,
        'Pertama Kali Terdeteksi' => $threat['first_seen'] ?? null,
        'Terakhir Kali Terdeteksi' => $threat['last_seen'] ?? null,
    ] as $label => $value)
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $label }}
                                </p>

                                <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-white">
                                    {{ $value ?: 'Tidak tersedia' }}
                                </p>
                            </div>
                        @endforeach

                    </div>

                    @if (!empty($threat['ioc']))
                        <div class="mt-4">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Indikator IOC yang Cocok
                            </p>

                            <p class="mt-1 break-all text-sm font-medium text-rose-600 dark:text-rose-400">
                                {{ $threat['ioc'] }}
                            </p>
                        </div>
                    @endif

                    @if (!empty($threat['reference']))
                        <div class="mt-4">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Referensi
                            </p>

                            <p class="mt-1 break-all text-sm text-slate-700 dark:text-slate-300">
                                {{ $threat['reference'] }}
                            </p>
                        </div>
                    @endif

                    @if (!empty($threat['tags']) && is_array($threat['tags']))
                        <div class="mt-4">
                            <p class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                Label Ancaman
                            </p>

                            <div class="flex flex-wrap gap-2">
                                @foreach ($threat['tags'] as $tag)
                                    <span
                                        class="rounded-full bg-rose-50 px-3 py-1 text-xs font-medium text-rose-600 dark:bg-rose-400/10 dark:text-rose-300">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            @endforeach

            <div class="mt-4 rounded-lg bg-slate-50 p-3 dark:bg-[#0b1220]">
                <p class="text-xs leading-6 text-slate-600 dark:text-slate-400">
                    URL cocok dengan indikator kompromi (IOC) yang tercatat dalam database
                    ThreatFox.
                </p>
            </div>

        </div>

    @endif
</div>
