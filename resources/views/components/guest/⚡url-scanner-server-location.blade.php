<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component {
    #[Reactive]
    public ?array $serverLocation = null;
};
?>

<div class="mb-5 rounded-xl border border-blue-100 bg-blue-50/70 p-4 dark:border-blue-400/10 dark:bg-blue-400/5">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-[#101a2b] dark:text-blue-400">
                <i class="fa-solid fa-location-dot text-xl"></i>
            </div>

            <div>

                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Perkiraan Lokasi Server
                </p>

                <h4 class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                    {{ $serverLocation['city'] ?? 'Kota Tidak Diketahui' }}{{ !empty($serverLocation['city']) && !empty($serverLocation['country']) ? ', ' : '' }}{{ $serverLocation['country'] ?? 'Negara Tidak Diketahui' }}
                </h4>

                @if (!empty($serverLocation['regionName']))
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ $serverLocation['regionName'] }}
                    </p>
                @endif

            </div>

        </div>

        @if (isset($serverLocation['lat'], $serverLocation['lon']) &&
                is_numeric($serverLocation['lat']) &&
                is_numeric($serverLocation['lon']))
            <a href="https://www.openstreetmap.org/?mlat={{ $serverLocation['lat'] }}&mlon={{ $serverLocation['lon'] }}#map=10/{{ $serverLocation['lat'] }}/{{ $serverLocation['lon'] }}"
                target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-200 bg-white px-4 py-2.5 text-xs font-semibold text-blue-600 transition hover:bg-blue-100 dark:border-blue-400/20 dark:bg-[#101a2b] dark:text-blue-400 dark:hover:bg-blue-400/10">

                <i class="fa-solid fa-map-location-dot"></i>
                Lihat di Peta
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>

            </a>
        @endif

    </div>

</div>
