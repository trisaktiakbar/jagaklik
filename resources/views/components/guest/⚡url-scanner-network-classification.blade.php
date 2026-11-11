<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component {
    #[Reactive]
    public ?array $serverLocation = null;
};
?>

<div class="mt-5">

    <h4 class="mb-3 text-sm font-bold text-slate-900 dark:text-white">
        <i class="fa-solid fa-shield-halved mr-2 text-blue-500"></i>
        Klasifikasi Hosting & Jaringan
    </h4>

    <div class="grid gap-3 sm:grid-cols-3">

        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-server text-blue-500"></i>

                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Hosting
                </p>
            </div>

            @if (isset($serverLocation['hosting']))
                <p
                    class="mt-2 text-sm font-bold {{ $serverLocation['hosting'] ? 'text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300' }}">
                    {{ $serverLocation['hosting'] ? 'Penyedia Hosting' : 'Bukan Hosting' }}
                </p>
            @else
                <p class="mt-2 text-sm font-semibold text-slate-500">
                    Tidak diketahui
                </p>
            @endif

        </div>

        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-shuffle text-amber-500"></i>

                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Proxy
                </p>
            </div>

            @if (isset($serverLocation['proxy']))
                <p
                    class="mt-2 text-sm font-bold {{ $serverLocation['proxy'] ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                    {{ $serverLocation['proxy'] ? 'Proxy Terdeteksi' : 'Tidak Terdeteksi' }}
                </p>
            @else
                <p class="mt-2 text-sm font-semibold text-slate-500">
                    Tidak diketahui
                </p>
            @endif

        </div>

        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-mobile-screen-button text-cyan-500"></i>

                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Jaringan Seluler
                </p>
            </div>

            @if (isset($serverLocation['mobile']))
                <p class="mt-2 text-sm font-bold text-slate-700 dark:text-slate-300">
                    {{ $serverLocation['mobile'] ? 'Jaringan Seluler' : 'Tidak Terdeteksi' }}
                </p>
            @else
                <p class="mt-2 text-sm font-semibold text-slate-500">
                    Tidak diketahui
                </p>
            @endif

        </div>

    </div>

    @if (isset($serverLocation['lat'], $serverLocation['lon']) &&
            is_numeric($serverLocation['lat']) &&
            is_numeric($serverLocation['lon']))
        <div
            class="mt-4 flex flex-col gap-2 rounded-xl bg-slate-50 p-4 dark:bg-[#0b1220] sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-crosshairs text-blue-500"></i>

                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Perkiraan Koordinat
                </p>

            </div>

            <p class="font-mono text-xs font-semibold text-slate-800 dark:text-slate-200">
                {{ $serverLocation['lat'] }}, {{ $serverLocation['lon'] }}
            </p>

        </div>
    @endif

    <div class="mt-4 flex gap-3 rounded-xl bg-blue-50 p-3 dark:bg-blue-400/10">

        <i class="fa-solid fa-circle-info mt-0.5 text-blue-500"></i>

        <p class="text-xs leading-6 text-blue-800 dark:text-blue-300">
            Informasi lokasi diperoleh berdasarkan geolokasi alamat IP menggunakan
            layanan IP-API. Lokasi yang ditampilkan merupakan perkiraan lokasi IP dan tidak selalu
            menunjukkan lokasi fisik server sebenarnya. Jika website menggunakan CDN atau proxy,
            IP yang terdeteksi mungkin merupakan IP milik penyedia layanan tersebut.
        </p>

    </div>

</div>
