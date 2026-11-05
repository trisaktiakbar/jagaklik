<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section id="laporkan" class="px-5 pb-20 lg:px-8">

    <div
        class="mx-auto max-w-7xl overflow-hidden rounded-[2rem] bg-ink-950 px-7 py-10 text-white shadow-glow sm:px-12 sm:py-12">

        <div class="relative flex flex-col justify-between gap-8 md:flex-row md:items-center">

            <div class="absolute -right-16 -top-40 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>

            <div class="relative max-w-2xl"><span
                    class="inline-flex rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-blue-300">Berpartisipasi</span>

                <h2 class="mt-4 text-2xl font-extrabold tracking-tight sm:text-3xl">
                    Temukan tautan

                    mencurigakan?</h2>

                <p class="mt-3 text-sm leading-7 text-slate-300">Bantu lindungi
                    pengguna lain dengan

                    melaporkan

                    URL yang diduga berbahaya. Laporan dapat ditinjau untuk
                    memperkaya informasi ancaman

                    JagaKlik.</p>

            </div>

            <a wire:navigate href="{{ route('guest.url-report.create') }}"
                class="relative inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-5 py-3.5 text-sm font-bold text-ink-950 transition hover:bg-blue-50">Laporkan

                URL <i class="fa-solid fa-arrow-up-right-from-square"></i></a>

        </div>

    </div>

</section>
