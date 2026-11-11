<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section class="px-5 py-20 lg:px-8">

    <div class="mx-auto max-w-7xl">

        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

            <div>

                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    Jenis Ancaman Digital

                </p>

                <h2 class="mt-2 text-3xl font-extrabold tracking-tight">Kenali jenis
                    ancamannya</h2>

                <p class="mt-3 max-w-xl text-sm leading-7 text-slate-500 dark:text-slate-400">Kenali berbagai modus yang
                    sering digunakan untuk menipu dan membahayakan pengguna internet.</p>

            </div>

            <a wire:navigate href="{{ route('guest.url-report.create') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700">Laporkan URL
                mencurigakan <i class="fa-solid fa-arrow-up-right-from-square"></i></a>

        </div>

        <div class="mt-9 grid gap-5 md:grid-cols-2 lg:grid-cols-4">

            <article
                class="group rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-rose-200 hover:shadow-soft dark:border-white/10 dark:bg-ink-850 dark:hover:border-rose-400/30">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-400/10 dark:text-rose-300">

                    <i class="fa-solid fa-user-secret text-2xl"></i>

                </div>

                <h3 class="mt-5 font-bold">Phishing</h3>

                <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Situs atau pesan palsu yang mencoba
                    mencuri kata sandi, OTP, dan informasi pribadi.</p>
                <a wire:navigate href="{{ route('guest.threat.show', 'phishing') }}"
                    class="mt-5 inline-flex items-center gap-1 text-xs font-bold text-rose-600 dark:text-rose-300">Pelajari
                    ancaman <i class="fa-solid fa-arrow-right"></i></a>

            </article>

            <article
                class="group rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-amber-200 hover:shadow-soft dark:border-white/10 dark:bg-ink-850 dark:hover:border-amber-400/30">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-300">
                    <i class="fa-solid fa-bug text-2xl"></i>
                </div>

                <h3 class="mt-5 font-bold">Malware</h3>
                <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Perangkat lunak berbahaya yang
                    dapat merusak perangkat atau mengambil data.</p>
                <a wire:navigate href="{{ route('guest.threat.show', 'malware') }}"
                    class="mt-5 inline-flex items-center gap-1 text-xs font-bold text-amber-600 dark:text-amber-300">Pelajari
                    ancaman <i class="fa-solid fa-arrow-right"></i></a>

            </article>

            <article
                class="group rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-soft dark:border-white/10 dark:bg-ink-850 dark:hover:border-orange-400/30">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-600 dark:bg-orange-400/10 dark:text-orange-300">
                    <i class="fa-solid fa-money-bill-transfer text-2xl"></i>
                </div>

                <h3 class="mt-5 font-bold">Scam & Penipuan</h3>
                <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Tautan yang mengarahkan korban ke
                    penawaran palsu, hadiah fiktif, atau transaksi bodong.
                </p>
                <a wire:navigate href="{{ route('guest.threat.show', 'scam') }}"
                    class="mt-5 inline-flex items-center gap-1 text-xs font-bold text-orange-600 dark:text-orange-300">Pelajari
                    ancaman <i class="fa-solid fa-arrow-right"></i></a>

            </article>

            <article
                class="group rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-violet-200 hover:shadow-soft dark:border-white/10 dark:bg-ink-850 dark:hover:border-violet-400/30">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-400/10 dark:text-violet-300">

                    <i class="fa-solid fa-globe text-2xl"></i>

                </div>

                <h3 class="mt-5 font-bold">Domain Mencurigakan</h3>
                <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">Domain dengan pola, reputasi, atau
                    karakteristik yang patut diperiksa lebih lanjut.
                </p>
                <a wire:navigate href="{{ route('guest.threat.show', 'suspicious-domain') }}"
                    class="mt-5 inline-flex items-center gap-1 text-xs font-bold text-violet-600 dark:text-violet-300">Pelajari
                    ancaman <i class="fa-solid fa-arrow-right"></i></a>

            </article>

        </div>

    </div>

</section>
