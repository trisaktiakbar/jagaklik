<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $openphishResult = null;
};
?>

<div>
    @if (($openphishResult['is_phishing'] ?? false) === true)

        <div class="rounded-xl border border-rose-200 bg-white p-5 dark:border-rose-400/20 dark:bg-[#101a2b]">

            <div class="mb-4 flex items-center justify-between gap-3">

                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-fish text-lg text-blue-500"></i>
                    <h4 class="font-bold text-slate-900 dark:text-white">
                        OpenPhish
                    </h4>
                </div>

                <span
                    class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-400/20 dark:text-rose-300">
                    Phishing Terdeteksi
                </span>

            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Status Deteksi
                    </p>

                    <p class="mt-1 text-sm font-semibold text-rose-600 dark:text-rose-400">
                        Phishing
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Sumber Intelijen Ancaman
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $openphishResult['source'] ?? 'OpenPhish Community Feed' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Jumlah Data dalam Basis Umpan
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ number_format($openphishResult['feed_count'] ?? 0) }} URL
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Status Kecocokan
                    </p>

                    <p class="mt-1 text-sm font-semibold text-rose-600 dark:text-rose-400">
                        URL Cocok dengan Data Umpan
                    </p>
                </div>

            </div>

            @if (!empty($openphishResult['matched_url']))
                <div class="mt-4">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        URL yang Cocok
                    </p>

                    <p class="mt-1 break-all text-sm font-medium text-rose-600 dark:text-rose-400">
                        {{ $openphishResult['matched_url'] }}
                    </p>
                </div>
            @endif

            <div class="mt-4 rounded-lg bg-slate-50 p-3 dark:bg-[#0b1220]">
                <p class="text-xs leading-6 text-slate-600 dark:text-slate-400">
                    URL ditemukan dalam OpenPhish Community Feed yang berisi daftar tautan
                    phishing.
                </p>
            </div>

        </div>

    @endif
</div>
