<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $googleResult = null;
};
?>

<div>

    @if (($googleResult['is_safe'] ?? true) === false)

        <div class="rounded-xl border border-rose-200 bg-white p-5 dark:border-rose-400/20 dark:bg-[#101a2b]">

            <div class="mb-4 flex items-center justify-between gap-3">

                <div class="flex items-center gap-2">
                    <i class="fa-brands fa-google text-lg text-blue-500"></i>
                    <h4 class="font-bold text-slate-900 dark:text-white">
                        Google Safe Browsing
                    </h4>
                </div>

                <span
                    class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-400/20 dark:text-rose-300">
                    Berbahaya
                </span>

            </div>

            @foreach ($googleResult['threats'] ?? [] as $index => $threat)
                <div class="{{ !$loop->first ? 'mt-4 border-t border-slate-200 pt-4 dark:border-slate-700' : '' }}">

                    <p class="mb-3 text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Ancaman #{{ $index + 1 }}
                    </p>

                    <div class="grid gap-4 sm:grid-cols-2">

                        @php
                            $threatDetails = [
                                'Threat Type' => $threat['threatType'] ?? 'Tidak Diketahui',
                                'Platform' => $threat['platformType'] ?? 'Tidak Diketahui',
                                'Threat Entry Type' => $threat['threatEntryType'] ?? 'Tidak Diketahui',
                                'Durasi Penyimpanan' => $threat['cacheDuration'] ?? 'Tidak tersedia',
                            ];
                        @endphp

                        @foreach ($threatDetails as $label => $value)
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $label }}
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                                    {{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : (string) $value }}
                                </p>
                            </div>
                        @endforeach

                    </div>

                    @if (!empty($threat['threat']['url']))
                        <div class="mt-4">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                URL Terdeteksi
                            </p>

                            <p class="mt-1 break-all text-sm font-medium text-rose-600 dark:text-rose-400">
                                {{ $threat['threat']['url'] }}
                            </p>
                        </div>
                    @endif

                    @if (!empty($threat['threatEntryMetadata']['entries']) && is_array($threat['threatEntryMetadata']['entries']))
                        <div class="mt-4">

                            <p class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                Metadata Ancaman
                            </p>

                            @foreach ($threat['threatEntryMetadata']['entries'] as $metadata)
                                <div class="mb-2 rounded-lg bg-slate-50 p-3 dark:bg-[#0b1220]">

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $metadata['key'] ?? '-' }}
                                    </p>

                                    <p class="mt-1 break-all text-sm text-slate-800 dark:text-white">
                                        {{ $metadata['value'] ?? '-' }}
                                    </p>

                                </div>
                            @endforeach

                        </div>
                    @endif

                </div>
            @endforeach

        </div>

    @endif
</div>
