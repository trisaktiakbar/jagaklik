<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public ?array $urlhausResult = null;
};
?>

<div>

    @if (($urlhausResult['is_malicious'] ?? false) === true)

    @php
    $threat = $urlhausResult['threat'] ?? [];
    @endphp

    <div class="rounded-xl border border-rose-200 bg-white p-5 dark:border-rose-400/20 dark:bg-[#101a2b]">

        <div class="mb-4 flex items-center justify-between gap-3">

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-database text-lg text-blue-500"></i>
                <h4 class="font-bold text-slate-900 dark:text-white">
                    URLhaus
                </h4>
            </div>

            <span
                class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-400/20 dark:text-rose-300">
                Berbahaya
            </span>

        </div>

        <div class="grid gap-4 sm:grid-cols-2">

            @foreach ([
            'ID Ancaman' => $threat['id'] ?? null,
            'Status URL' => $threat['url_status'] ?? null,
            'Host' => $threat['host'] ?? null,
            'Jenis Ancaman' => $threat['threat'] ?? null,
            'Tanggal Ditemukan' => $threat['date_added'] ?? null,
            'Pelapor' => $threat['reporter'] ?? null,
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

        @if (!empty($threat['blacklists']) && is_array($threat['blacklists']))
        <div class="mt-4">
            <p class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                Informasi Daftar Hitam
            </p>

            <div class="grid gap-2 sm:grid-cols-2">
                @foreach ($threat['blacklists'] as $name => $blacklist)
                <div class="rounded-lg bg-slate-50 p-3 dark:bg-[#0b1220]">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $name }}
                    </p>

                    <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-white">
                        {{ is_array($blacklist) ? json_encode($blacklist) : $blacklist ?? '-' }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if (!empty($urlhausResult['url']))
        <div class="mt-4">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                URL Terdeteksi
            </p>

            <p class="mt-1 break-all text-sm font-medium text-rose-600 dark:text-rose-400">
                {{ $urlhausResult['url'] }}
            </p>
        </div>
        @endif

    </div>

    @endif
</div>