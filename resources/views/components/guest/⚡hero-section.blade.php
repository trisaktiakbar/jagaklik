<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section id="beranda" class="relative overflow-hidden">

    <div
        class="mx-auto grid max-w-7xl items-center gap-14 px-5 pb-20 pt-20 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:pb-28 lg:pt-28">

        <div class="relative z-10">

            <div
                class="mb-7 inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-700 dark:border-blue-400/20 dark:bg-blue-400/10 dark:text-blue-300">

                <span class="relative flex h-2 w-2"><span
                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span><span
                        class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span></span>

                RUANG DIGITAL LEBIH AMAN DIMULAI DARI SINI

            </div>

            <h1 class="max-w-2xl text-4xl font-black leading-[1.12] tracking-tight sm:text-5xl lg:text-[64px]">

                Jangan asal klik.<br><span
                    class="bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-400 bg-clip-text text-transparent">Pastikan

                    aman</span> dulu.

            </h1>

            <p class="mt-6 max-w-xl text-base leading-8 text-slate-600 dark:text-slate-300 sm:text-lg">

                Periksa tautan mencurigakan sebelum membukanya. JagaKlik membantu
                mengenali indikasi

                phishing,

                penipuan, malware, dan ancaman digital lainnya.

            </p>

            <div class="mt-9 flex flex-col gap-3 sm:flex-row">

                <a wire:navigate href="{{ route('guest.check-url.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-glow transition hover:-translate-y-0.5 hover:bg-blue-700">

                    Periksa tautan sekarang <i class="fa-solid fa-arrow-up-right-from-square"></i>

                </a>

                <a href="#how-it-works"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white/70 px-6 py-3.5 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:text-blue-600 dark:border-white/15 dark:bg-white/5 dark:text-slate-200 dark:hover:border-blue-400">

                    <i class="fa-solid fa-circle-play"></i> Cara kerja
                    JagaKlik

                </a>

            </div>

            <div
                class="mt-9 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs font-medium text-slate-500 dark:text-slate-400">

                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i>
                    Tanpa registrasi</span>

                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-lock text-emerald-500"></i>
                    Aman dan terlindungi</span>

                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-rocket text-emerald-500"></i>
                    Praktis dan mudah</span>

            </div>

        </div>

        <!-- Hero visual -->

        <div class="relative mx-auto w-full max-w-[560px]">

            <div class="absolute -inset-8 rounded-full hero-orb blur-2xl"></div>

            <div
                class="relative rounded-[2rem] border border-slate-200 bg-white/90 p-5 shadow-2xl shadow-slate-900/10 backdrop-blur dark:border-white/10 dark:bg-ink-850/90 dark:shadow-black/30 sm:p-7">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-300">

                            <i class="fa-solid fa-expand"></i>

                        </div>

                        <div>

                            <p class="text-sm font-bold">URL Security Check
                            </p>

                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Contoh tampilan

                                hasil

                                analisis</p>

                        </div>

                    </div>

                    <span
                        class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">Demo</span>

                </div>

                <div
                    class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-white/10 dark:bg-white/[0.03]">

                    <p class="mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">URL

                        yang

                        diperiksa</p>

                    <div
                        class="flex items-center gap-2 break-all text-sm font-semibold text-slate-700 dark:text-slate-200">

                        <i class="fa-solid fa-link shrink-0 text-blue-500"></i>

                        https://contoh-website.id

                    </div>

                </div>

                <div class="py-7 text-center">

                    <div
                        class="scan-ring mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <i class="fa-solid fa-shield-halved text-4xl"></i>

                    </div>

                    <p class="mt-6 text-xl font-extrabold">Analisis ditampilkan di
                        sini</p>

                    <p class="mx-auto mt-2 max-w-xs text-xs leading-6 text-slate-500 dark:text-slate-400">

                        Status keamanan, tingkat risiko, dan alasan deteksi akan
                        muncul setelah integrasi

                        scanner aktif.</p>

                </div>

                <div class="grid grid-cols-3 gap-2 border-t border-slate-200 pt-4 dark:border-white/10">

                    <div class="rounded-lg bg-slate-50 p-3 text-center dark:bg-white/[0.04]"><i
                            class="fa-solid fa-globe mx-auto text-blue-500"></i>

                        <p class="mt-2 text-[10px] font-semibold text-slate-500 dark:text-slate-400">Domain

                        </p>

                        <p class="mt-1 text-xs font-bold">Check</p>

                    </div>

                    <div class="rounded-lg bg-slate-50 p-3 text-center dark:bg-white/[0.04]"><i
                            class="fa-solid fa-triangle-exclamation mx-auto text-amber-500"></i>

                        <p class="mt-2 text-[10px] font-semibold text-slate-500 dark:text-slate-400">Threat

                        </p>

                        <p class="mt-1 text-xs font-bold">Scan</p>

                    </div>

                    <div class="rounded-lg bg-slate-50 p-3 text-center dark:bg-white/[0.04]"><i
                            class="fa-solid fa-ranking-star mx-auto text-cyan-500"></i>

                        <p class="mt-2 text-[10px] font-semibold text-slate-500 dark:text-slate-400">

                            Reputation

                        </p>

                        <p class="mt-1 text-xs font-bold">Review</p>

                    </div>

                </div>

            </div>

            <div
                class="absolute -bottom-13 -left-5 hidden items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-soft dark:border-white/10 dark:bg-ink-800 sm:flex">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 dark:bg-cyan-400/10 dark:text-cyan-300">

                    <i class="fas fa-satellite-dish"></i>

                </div>

                <div>

                    <p class="text-xs font-bold">Threat Intelligence</p>

                    <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-400">
                        Analisis dari sumber

                        tepercaya</p>

                </div>

            </div>

        </div>

    </div>

</section>
