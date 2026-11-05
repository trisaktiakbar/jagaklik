<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section class="px-5 py-20 lg:px-8">

    <div class="mx-auto max-w-7xl">

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

            <div>

                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    Cyber Security Insights</p>

                <h2 class="mt-2 text-3xl font-extrabold tracking-tight">Kenali Ancaman, Lindungi Aktivitas Digital</h2>

                <p class="mt-3 max-w-xl text-sm leading-7 text-slate-500 dark:text-slate-400">Pelajari berbagai ancaman
                    siber, pahami risikonya,
                    dan tingkatkan kewaspadaan saat menjelajahi internet.</p>

            </div><a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-blue-600">Jelajahi Riwayat Pemeriksaan

                <i class="fa-solid fa-arrow-up-right-from-square"></i></a>

        </div>

        <div class="mt-9 grid gap-5 md:grid-cols-3">

            <a wire:navigate href="{{ route('guest.insight.show', 'phishing-detection') }}"
                class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-soft dark:border-white/10 dark:bg-ink-850">

                <div
                    class="flex items-center justify-center bg-gradient-to-br from-rose-100 to-orange-50 text-rose-500 dark:from-rose-500/15 dark:to-orange-500/10">

                    <img class="w-full aspect-video" src="{{ asset('assets/guest/img/cyber-security-insight/1.jpg') }}"
                        alt="">

                </div>

                <div class="p-5"><span
                        class="text-[10px] font-bold uppercase tracking-wider text-rose-600 dark:text-rose-300">Phishing
                        Detection</span>

                    <h3 class="mt-2 font-bold group-hover:text-blue-600">Cara Mengenali Tautan Phishing dan Situs Palsu
                    </h3>

                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Kenali karakteristik tautan
                        phishing yang digunakan untuk mencuri kredensial dan informasi pribadi.</p><span
                        class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-blue-600">Baca

                        selengkapnya <i class="fa-solid fa-arrow-right"></i></span>

                </div>

            </a>

            <a wire:navigate href="{{ route('guest.insight.show', 'url-reputation') }}"
                class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-soft dark:border-white/10 dark:bg-ink-850">

                <div
                    class="flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-50 text-blue-600 dark:from-blue-500/15 dark:to-cyan-500/10">

                    <img class="w-full aspect-video" src="{{ asset('assets/guest/img/cyber-security-insight/2.jpg') }}"
                        alt="">
                </div>

                <div class="p-5"><span
                        class="text-[10px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-300">URL
                        Reputation</span>

                    <h3 class="mt-2 font-bold group-hover:text-blue-600">Mengapa Reputasi URL Penting Sebelum Mengakses
                        Website?
                    </h3>

                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Pahami bagaimana reputasi URL
                        membantu mengidentifikasi situs yang berpotensi berbahaya.</p><span
                        class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-blue-600">Baca

                        selengkapnya <i class="fa-solid fa-arrow-right"></i></span>

                </div>

            </a>

            <a wire:navigate href="{{ route('guest.insight.show', 'threat-intelligence') }}"
                class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-soft dark:border-white/10 dark:bg-ink-850">

                <div
                    class="flex items-center justify-center bg-gradient-to-br from-violet-100 to-indigo-50 text-violet-600 dark:from-violet-500/15 dark:to-indigo-500/10">

                    <img class="w-full aspect-video" src="{{ asset('assets/guest/img/cyber-security-insight/3.jpg') }}"
                        alt="">

                </div>

                <div class="p-5"><span
                        class="text-[10px] font-bold uppercase tracking-wider text-violet-600 dark:text-violet-300">Threat
                        Intelligence</span>

                    <h3 class="mt-2 font-bold group-hover:text-blue-600">Mengenal Berbagai Ancaman Siber di Internet
                    </h3>

                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Pelajari ancaman seperti
                        malware, scam, dan domain mencurigakan yang dapat membahayakan aktivitas digital.</p><span
                        class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-blue-600">Baca

                        selengkapnya <i class="fa-solid fa-arrow-right"></i></span>

                </div>

            </a>

        </div>

    </div>

</section>
