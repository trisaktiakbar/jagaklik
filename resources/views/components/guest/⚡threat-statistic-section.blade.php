<?php

use App\Models\UrlScan;
use App\Models\UrlReport;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function statistics(): array
    {
        return [
            'total_scans' => UrlScan::count(),

            'malicious' => UrlScan::where('status', 'malicious')->count(),

            'reported' => UrlReport::count(),

            'suspicious' => UrlScan::where('status', 'suspicious')->count(),
        ];
    }
};
?>

<section id="statistik" class="border-y border-slate-200 bg-white/70 py-14 dark:border-white/10 dark:bg-white/[0.02]">

    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        <div class="mb-9 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">

            <div>

                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    Gambaran keamanan
                </p>

                <h2 class="mt-2 text-2xl font-extrabold tracking-tight">
                    Pantau ancaman digital
                </h2>

            </div>

            <p class="max-w-md text-xs leading-6 text-slate-500 dark:text-slate-400">
                Statistik aktivitas pemindaian, ancaman terdeteksi, dan laporan
                keamanan yang tercatat dalam sistem JagaKlik.
            </p>

        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-ink-850">

                <div class="flex items-center justify-between">

                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        Total pemindaian
                    </span>

                    <span class="rounded-lg bg-blue-50 p-2 text-blue-600 dark:bg-blue-400/10 dark:text-blue-300">
                        <i class="fa-solid fa-qrcode"></i>
                    </span>

                </div>

                <p class="mt-4 text-3xl font-black tracking-tight">
                    {{ number_format($this->statistics['total_scans']) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Total URL yang telah diperiksa
                </p>

            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-ink-850">

                <div class="flex items-center justify-between">

                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        Ancaman terdeteksi
                    </span>

                    <span class="rounded-lg bg-rose-50 p-2 text-rose-600 dark:bg-rose-400/10 dark:text-rose-300">
                        <i class="fa-solid fa-shield-virus"></i>
                    </span>

                </div>

                <p class="mt-4 text-3xl font-black tracking-tight">
                    {{ number_format($this->statistics['malicious']) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    URL dengan status berbahaya
                </p>

            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-ink-850">

                <div class="flex items-center justify-between">

                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        URL dilaporkan
                    </span>

                    <span class="rounded-lg bg-amber-50 p-2 text-amber-600 dark:bg-amber-400/10 dark:text-amber-300">
                        <i class="fa-solid fa-flag"></i>
                    </span>

                </div>

                <p class="mt-4 text-3xl font-black tracking-tight">
                    {{ number_format($this->statistics['reported']) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Total laporan dari komunitas
                </p>

            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-ink-850">

                <div class="flex items-center justify-between">

                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                        URL mencurigakan
                    </span>

                    <span class="rounded-lg bg-cyan-50 p-2 text-cyan-600 dark:bg-cyan-400/10 dark:text-cyan-300">
                        <i class="fa-solid fa-shield-halved"></i>
                    </span>

                </div>

                <p class="mt-4 text-3xl font-black tracking-tight">
                    {{ number_format($this->statistics['suspicious']) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    URL dengan indikasi aktivitas mencurigakan
                </p>

            </div>

        </div>

    </div>

</section>
