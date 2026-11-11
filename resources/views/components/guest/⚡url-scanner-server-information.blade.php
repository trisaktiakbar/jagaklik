<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component {
    #[Reactive]
    public ?array $serverLocation = null;

    #[Reactive]
    public ?string $serverLocationError = null;
};
?>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-[#101a2b]">

    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-700">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                    <i class="fa-solid fa-server text-lg"></i>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white">
                        Server & Network Information
                    </h3>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Informasi lokasi dan infrastruktur jaringan website.
                    </p>
                </div>

            </div>

            @if ($serverLocation)
                <span
                    class="inline-flex w-fit items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check"></i>
                    Informasi Ditemukan
                </span>
            @elseif ($serverLocationError)
                <span
                    class="inline-flex w-fit items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 dark:bg-amber-400/10 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Tidak Tersedia
                </span>
            @endif

        </div>

    </div>

    <div class="p-5">

        @if ($serverLocation)
            <livewire:guest.url-scanner-server-location :server-location="$serverLocation" />

            <livewire:guest.url-scanner-network-information :server-location="$serverLocation" />

            <livewire:guest.url-scanner-network-classification :server-location="$serverLocation" />
        @elseif ($serverLocationError)
            <div
                class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-400/20 dark:bg-amber-400/10">

                <div class="flex items-start gap-3">

                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-amber-600 dark:text-amber-400"></i>

                    <div>

                        <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                            Informasi Lokasi Server Tidak Tersedia
                        </h4>

                        <p class="mt-1 text-xs leading-6 text-amber-700 dark:text-amber-400">
                            {{ $serverLocationError }}
                        </p>

                    </div>

                </div>

            </div>
        @else
            <div class="py-5 text-center">

                <i class="fa-solid fa-server text-2xl text-slate-300 dark:text-slate-600"></i>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                    Informasi lokasi server belum tersedia.
                </p>

            </div>
        @endif

    </div>

</div>
