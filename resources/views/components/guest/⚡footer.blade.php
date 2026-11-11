<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<footer class="border-t border-slate-200 bg-white px-5 pb-8 pt-12 dark:border-white/10 dark:bg-ink-950 lg:px-8">

    <div class="mx-auto grid max-w-7xl gap-10 md:grid-cols-[1.4fr_.7fr_.7fr]">

        <div>
            <a wire:navigate href="{{ route('guest.home.index') }}" class="inline-flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>

                <span class="text-xl font-extrabold tracking-tight">
                    Jaga<span class="text-blue-600">Klik</span>
                </span>
            </a>

            <p class="mt-4 max-w-sm text-xs leading-7 text-slate-500 dark:text-slate-400">
                Platform pemeriksaan tautan untuk membantu masyarakat mengenali potensi ancaman digital.
                Periksa sebelum klik, lebih waspada saat berselancar.
            </p>
        </div>

        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider">
                Navigasi
            </h3>

            <div class="mt-4 flex flex-col gap-3 text-xs text-slate-500 dark:text-slate-400">

                <a wire:navigate href="{{ route('guest.home.index') }}" class="hover:text-blue-600 transition">
                    Beranda
                </a>

                <a wire:navigate href="{{ route('guest.check-url.index') }}" class="hover:text-blue-600 transition">
                    Periksa URL
                </a>

                <a wire:navigate href="{{ route('guest.url-report.create') }}" class="hover:text-blue-600 transition">
                    Laporkan URL
                </a>

            </div>
        </div>

        {{-- Informasi --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider">
                Informasi
            </h3>

            <div class="mt-4 flex flex-col gap-3 text-xs text-slate-500 dark:text-slate-400">

                <a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                    class="hover:text-blue-600 transition">
                    Riwayat Pemeriksaan
                </a>

                <a wire:navigate href="{{ route('guest.url-report.index') }}" class="hover:text-blue-600 transition">
                    Laporan Komunitas
                </a>

                <a wire:navigate href="{{ route('guest.about.index') }}" class="hover:text-blue-600 transition">
                    Tentang Kami
                </a>

            </div>
        </div>

    </div>

    <div
        class="mx-auto mt-10 flex max-w-7xl flex-col justify-between gap-3 border-t border-slate-200 pt-6  text-sm text-slate-400 dark:border-white/10 sm:flex-row">

        <p>2026 © <a wire:navigate href="{{ route('guest.home.index') }}"
                class="text-blue-600 transition hover:text-blue-700">JagaKlik</a></p>

        <p class="inline-flex items-center gap-1.5">
            Developed by
            <a class="font-bold text-blue-600 transition hover:text-blue-700" href="https://trisaktiakbar.com"
                target="_blank" rel="noopener noreferrer">
                Trisakti Akbar
            </a>
            in
            <img class="h-3.5 w-5 rounded-[2px] object-cover shadow-sm"
                src="{{ asset('assets/guest/img/indonesia.webp') }}" alt="Indonesia">
            <span>Indonesia</span>
        </p>

    </div>

</footer>
