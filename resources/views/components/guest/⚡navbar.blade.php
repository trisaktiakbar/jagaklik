<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<header
    class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl dark:border-white/10 dark:bg-ink-900/85">

    <nav class="mx-auto flex h-[76px] max-w-7xl items-center justify-between px-5 lg:px-8" aria-label="Navigasi utama">

        <a wire:navigate href="{{ route('guest.home.index') }}" class="flex items-center gap-3" aria-label="Beranda">

            <span
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/25">

                <i class="fa-solid fa-shield-halved"></i>

            </span>

            <span class="text-xl font-extrabold tracking-tight">Jaga<span class="text-blue-600">Klik</span></span>

        </a>

        <div class="hidden items-center gap-8 lg:flex">

            <a wire:navigate href="{{ route('guest.home.index') }}"
                class="nav-link text-sm {{ Route::is('guest.home.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Beranda</a>

            <a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                class="nav-link text-sm {{ Route::is('guest.url-scan-history.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Riwayat
                Pemeriksaan</a>

            <a wire:navigate href="{{ route('guest.url-report.index') }}"
                class="nav-link text-sm {{ Route::is('guest.url-report.index') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Laporan
                Komunitas</a>

            <a wire:navigate href="{{ route('guest.url-report.create') }}"
                class="nav-link text-sm {{ Route::is('guest.url-report.create') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Laporkan
                URL</a>
            <a wire:navigate href="{{ route('guest.about.index') }}"
                class="nav-link text-sm {{ Route::is('guest.about.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Tentang
                Kami</a>

        </div>

        <div class="flex items-center gap-2">

            <button id="themeToggle"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-blue-300 hover:text-blue-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-blue-400 hover:cursor-pointer"
                aria-label="Ganti tema" title="Ganti tema">

                <i id="themeIcon" class="fa-solid fa-moon"></i>

            </button>

            <a wire:navigate href="{{ route('guest.check-url.index') }}"
                class="hidden items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 sm:inline-flex">

                <i class="fa-solid fa-expand"></i> Periksa URL

            </a>

            <button id="mobileMenuButton"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 dark:border-white/10 dark:text-slate-200 lg:hidden"
                aria-label="Buka menu">

                <i class="fa-solid fa-bars"></i>

            </button>

        </div>

    </nav>

    <div id="mobileMenu"
        class="hidden border-t border-slate-200 bg-white px-5 py-4 dark:border-white/10 dark:bg-ink-900 lg:hidden">

        <div class="mx-auto flex max-w-7xl flex-col gap-4 text-sm font-semibold">

            <a wire:navigate href="{{ route('guest.home.index') }}"
                class="{{ Route::is('guest.home.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}">Beranda</a>

            <a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                class="{{ Route::is('guest.url-scan-history.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Riwayat
                Pemeriksaan</a>

            <a wire:navigate href="{{ route('guest.url-report.index') }}"
                class="{{ Route::is('guest.url-report.index') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Laporan
                Komunitas</a>

            <a wire:navigate href="{{ route('guest.url-report.create') }}"
                class="{{ Route::is('guest.url-report.create') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Laporkan
                URL</a>
            <a wire:navigate href="{{ route('guest.about.index') }}"
                class="{{ Route::is('guest.about.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Tentang
                Kami</a>
            <a wire:navigate href="{{ route('guest.check-url.index') }}"
                class="{{ Route::is('guest.check-url.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Periksa
                URL</a>

        </div>

    </div>

</header>

@script
    <script>
        const root = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        function updateThemeIcon() {
            const dark = root.classList.contains('dark');

            themeIcon.className = dark ?
                'fa-solid fa-sun' :
                'fa-solid fa-moon';

            themeToggle.setAttribute(
                'aria-label',
                dark ? 'Aktifkan light mode' : 'Aktifkan dark mode'
            );
        }

        themeToggle.addEventListener('click', () => {
            root.classList.toggle('dark');

            localStorage.setItem(
                'jagaklik-theme',
                root.classList.contains('dark') ? 'dark' : 'light'
            );

            updateThemeIcon();
        });

        updateThemeIcon();

        document.getElementById('mobileMenuButton').addEventListener('click', () => {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => document.getElementById('mobileMenu').classList.add('hidden'));
        });
    </script>
@endscript
