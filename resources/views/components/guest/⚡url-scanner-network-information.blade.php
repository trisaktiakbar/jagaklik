<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component {
    #[Reactive]
    public ?array $serverLocation = null;
};
?>

<div>

    <div class="mb-3">

        <h4 class="text-sm font-bold text-slate-900 dark:text-white">
            <i class="fa-solid fa-network-wired mr-2 text-blue-500"></i>
            Informasi Jaringan
        </h4>

    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        @foreach ([
        'Alamat IP' => 'query',
        'Negara' => 'country',
        'Kode Negara' => 'countryCode',
        'Wilayah' => 'regionName',
        'Kota' => 'city',
        'Zona Waktu' => 'timezone',
        'Penyedia Layanan Internet (ISP)' => 'isp',
        'Organisasi' => 'org',
        'Nomor ASN' => 'as',
    ] as $label => $field)
            <div class="rounded-xl bg-slate-50 p-3 dark:bg-[#0b1220]">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ $label }}
                </p>

                <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-white">
                    {{ filled($serverLocation[$field] ?? null) ? $serverLocation[$field] : 'Tidak tersedia' }}
                </p>

            </div>
        @endforeach

    </div>

</div>
