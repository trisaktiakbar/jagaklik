<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $alienVaultResult = null;

    #[Reactive]
    public bool $alienVaultDetected = false;
};
?>

<div>
    @if ($alienVaultDetected)

        <div class="rounded-xl border border-amber-200 bg-white p-5 dark:border-amber-400/20 dark:bg-[#101a2b]">

            <div class="mb-4 flex items-center justify-between gap-3">

                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-lg text-amber-500"></i>
                    <h4 class="font-bold text-slate-900 dark:text-white">
                        AlienVault OTX
                    </h4>
                </div>

                <span
                    class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700 dark:bg-amber-400/20 dark:text-amber-300">
                    Mencurigakan
                </span>

            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Laporan Ancaman
                    </p>

                    <p class="mt-1 text-sm font-semibold text-amber-600 dark:text-amber-400">
                        {{ $alienVaultResult['pulse_count'] ?? 0 }} laporan
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Jenis Indikator
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $alienVaultResult['type'] ?? 'URL' }}
                    </p>
                </div>

                @if (isset($alienVaultResult['reputation']))
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Reputasi
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                            {{ $alienVaultResult['reputation'] }}
                        </p>
                    </div>
                @endif

            </div>

            @if (!empty($alienVaultResult['url']))
                <div class="mt-4">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Indikator yang Ditemukan
                    </p>

                    <p class="mt-1 break-all text-sm font-medium text-amber-600 dark:text-amber-400">
                        {{ $alienVaultResult['url'] }}
                    </p>
                </div>
            @endif

            @if (!empty($alienVaultResult['pulses']) && is_array($alienVaultResult['pulses']))

                <div class="mt-5 border-t border-slate-200 pt-5 dark:border-slate-700">

                    <p class="mb-3 text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Laporan Intelijen Ancaman
                    </p>

                    @foreach ($alienVaultResult['pulses'] as $index => $pulse)
                        <div
                            class="{{ !$loop->first ? 'mt-5 border-t border-slate-200 pt-5 dark:border-slate-700' : '' }}">

                            <p class="mb-3 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                Laporan #{{ $index + 1 }}
                            </p>

                            <div class="grid gap-4 sm:grid-cols-2">

                                <div class="sm:col-span-2">
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Nama Laporan Ancaman
                                    </p>

                                    <p class="mt-1 break-words text-sm font-semibold text-slate-800 dark:text-white">
                                        {{ $pulse['name'] ?? 'Ancaman Tidak Diketahui' }}
                                    </p>
                                </div>

                                @foreach ([
        'Penulis' => $pulse['author'] ?? null,
        'Tanggal Dibuat' => $pulse['created'] ?? null,
        'Terakhir Diubah' => $pulse['modified'] ?? null,
        'Pihak Penyerang' => $pulse['adversary'] ?? null,
    ] as $label => $value)
                                    @if (!empty($value))
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $label }}
                                            </p>

                                            <p
                                                class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-white">
                                                {{ $value }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach

                            </div>

                            @if (!empty($pulse['description']))
                                <div class="mt-4">
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Deskripsi
                                    </p>

                                    <p
                                        class="mt-1 whitespace-pre-line break-words text-sm leading-6 text-slate-700 dark:text-slate-300">
                                        {{ $pulse['description'] }}
                                    </p>
                                </div>
                            @endif

                            @foreach ([
        'Label Ancaman' => [
            'items' => $pulse['tags'] ?? [],
            'classes' => 'bg-amber-50 text-amber-700 dark:bg-amber-400/10 dark:text-amber-300',
        ],
        'Keluarga Malware' => [
            'items' => $pulse['malware_families'] ?? [],
            'classes' => 'bg-rose-50 text-rose-600 dark:bg-rose-400/10 dark:text-rose-300',
        ],
        'Negara Sasaran' => [
            'items' => $pulse['targeted_countries'] ?? [],
            'classes' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
        ],
    ] as $label => $group)
                                @if (!empty($group['items']) && is_array($group['items']))
                                    <div class="mt-4">
                                        <p class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                            {{ $label }}
                                        </p>

                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($group['items'] as $item)
                                                <span
                                                    class="rounded-full px-3 py-1 text-xs font-medium {{ $group['classes'] }}">
                                                    {{ is_array($item) ? json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $item }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if (!empty($pulse['references']) && is_array($pulse['references']))
                                <div class="mt-4">
                                    <p class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        Referensi
                                    </p>

                                    <div class="space-y-2">
                                        @foreach ($pulse['references'] as $reference)
                                            <p class="break-all text-xs text-slate-600 dark:text-slate-400">
                                                {{ $reference }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endforeach

                </div>

            @endif

            <div class="mt-4 rounded-lg bg-amber-50 p-3 dark:bg-amber-400/10">
                <p class="text-xs leading-6 text-amber-800 dark:text-amber-300">
                    AlienVault OTX menemukan laporan intelijen ancaman yang berkaitan
                    dengan indikator ini. Laporan berasal dari kontribusi komunitas keamanan
                    siber dan perlu dievaluasi lebih lanjut. Temuan ini bukan bukti pasti
                    bahwa URL berbahaya.
                </p>
            </div>

        </div>

    @endif
</div>
