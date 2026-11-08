<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<header
    class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl dark:border-white/10 dark:bg-ink-900/85">

    <nav class="mx-auto flex h-[76px] max-w-7xl items-center justify-between px-5 lg:px-8" aria-label="Navigasi utama">

        <a wire:navigate href="{{ route('guest.home.index') }}" class="flex items-center gap-1 md:gap-3"
            aria-label="Beranda">

            <span
                class="flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-lg md:rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/25">

                <i class="fa-solid fa-shield-halved"></i>

            </span>

            <span class="text-lg md:text-xl font-extrabold tracking-tight">Jaga<span
                    class="text-blue-600">Klik</span></span>

        </a>

        <div class="hidden items-center gap-8 md:gap-4 xl:flex">

            <a wire:navigate href="{{ route('guest.home.index') }}"
                class="nav-link text-sm {{ Route::is('guest.home.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Beranda</a>

            <a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                class="nav-link text-sm {{ Route::is('guest.url-scan-history.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Riwayat
                Pemeriksaan</a>

            <a wire:navigate href="{{ route('guest.url-report.index') }}"
                class="nav-link text-sm {{ Route::is('guest.url-report.index') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Laporan
                Komunitas</a>

            <a wire:navigate href="{{ route('guest.threat-database.index') }}"
                class="nav-link text-sm {{ Route::is('guest.threat-database.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Database
                Ancaman</a>
            <a wire:navigate href="{{ route('guest.about.index') }}"
                class="nav-link text-sm {{ Route::is('guest.about.*') ? 'font-semibold text-blue-600' : 'font-medium text-slate-600 dark:text-slate-300' }}">Tentang
                Kami</a>

        </div>

        <div class="flex items-center gap-1 sm:gap-2">

            <button id="themeToggle"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-blue-300 hover:text-blue-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-blue-400 hover:cursor-pointer"
                aria-label="Ganti tema" title="Ganti tema">

                <i id="themeIcon" class="fa-solid fa-moon"></i>

            </button>

            <button type="button" id="jagaklik-install-button" id="jagaklik-install-button" title="Install JagaKlik"
                class="hidden items-center justify-center gap-2 rounded-xl border border-blue-600 bg-transparent h-10 w-10 sm:w-auto px-4 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white border-blue-600 text-blue-600 dark:hover:bg-blue-600  dark:hover:border-blue-600 hover:cursor-pointer">
                <i class="fa-solid fa-download"></i>
                <span class="hidden sm:inline">Install JagaKlik</span>
            </button>

            <a wire:navigate href="{{ route('guest.check-url.index') }}"
                class="items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 sm:inline-flex"
                title="Periksa URL">

                <i class="fa-solid fa-expand"></i>
                <span class="hidden sm:inline">Periksa URL</span>

            </a>

            <button id="mobileMenuButton"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 dark:border-white/10 dark:text-slate-200 xl:hidden"
                aria-label="Buka menu">

                <i class="fa-solid fa-bars"></i>

            </button>

        </div>

    </nav>

    <div id="mobileMenu"
        class="hidden border-t border-slate-200 bg-white px-5 py-4 dark:border-white/10 dark:bg-ink-900 xl:hidden">

        <div class="mx-auto flex max-w-7xl flex-col gap-4 text-sm font-semibold">

            <a wire:navigate href="{{ route('guest.home.index') }}"
                class="{{ Route::is('guest.home.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}">Beranda</a>

            <a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                class="{{ Route::is('guest.url-scan-history.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Riwayat
                Pemeriksaan</a>

            <a wire:navigate href="{{ route('guest.url-report.index') }}"
                class="{{ Route::is('guest.url-report.index') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Laporan
                Komunitas</a>

            <a wire:navigate href="{{ route('guest.threat-database.index') }}"
                class="{{ Route::is('guest.threat-database.*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300' }}"">Database
                Ancaman</a>
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
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        /*
        |--------------------------------------------------------------------------
        | Theme Toggle
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Mobile Navigation
        |--------------------------------------------------------------------------
        */

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | PWA Installation
        |--------------------------------------------------------------------------
        */

        let deferredInstallPrompt = null;

        function isJagaKlikInstalled() {
            return window.matchMedia('(display-mode: standalone)').matches ||
                window.navigator.standalone === true;
        }

        function updateJagaKlikInstallButton() {
            const buttons = document.querySelectorAll(
                '#jagaklik-install-button'
            );

            const shouldShow = Boolean(deferredInstallPrompt) &&
                !isJagaKlikInstalled();

            buttons.forEach(button => {
                button.classList.toggle('hidden', !shouldShow);
                button.classList.toggle('inline-flex', shouldShow);
            });
        }

        window.addEventListener('beforeinstallprompt', event => {
            event.preventDefault();

            deferredInstallPrompt = event;

            updateJagaKlikInstallButton();
        });

        document.addEventListener('click', async event => {
            const button = event.target.closest(
                '#jagaklik-install-button'
            );

            if (!button || !deferredInstallPrompt) {
                return;
            }

            const installPrompt = deferredInstallPrompt;

            deferredInstallPrompt = null;

            updateJagaKlikInstallButton();

            try {
                await installPrompt.prompt();

                const {
                    outcome
                } = await installPrompt.userChoice;

                if (outcome === 'accepted') {
                    console.log('JagaKlik berhasil diinstal.');
                } else {
                    console.log('Instalasi JagaKlik dibatalkan.');
                }
            } catch (error) {
                console.error('Gagal menginstal JagaKlik:', error);
            }
        });

        window.addEventListener('appinstalled', () => {
            deferredInstallPrompt = null;

            updateJagaKlikInstallButton();

            console.log('JagaKlik sudah terinstal.');
        });

        document.addEventListener('livewire:navigated', () => {
            updateJagaKlikInstallButton();
        });
    </script>
@endscript
