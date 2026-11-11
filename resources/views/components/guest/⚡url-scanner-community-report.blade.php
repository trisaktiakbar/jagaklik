<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public array $communityReports = [];
};
?>

<div>
    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

        <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-4 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">
                        Laporan Komunitas
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Informasi laporan dari pengguna JagaKlik
                    </p>
                </div>
            </div>

            <span
                class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                {{ count($communityReports) }} Laporan
            </span>
        </div>

        <div class="p-5">

            @if (count($communityReports) > 0)

                <div class="space-y-4">
                    @foreach ($communityReports as $report)
                        <div wire:key="community-report-{{ $report['id'] ?? $loop->index }}" x-data="{ expanded: false }"
                            class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">

                            <div class="p-4">

                                <div class="flex flex-wrap items-start justify-between gap-3">

                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                            <i class="fa-solid fa-flag"></i>
                                        </span>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                                {{ $report['category'] ?? 'Laporan Tidak Diketahui' }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                                {{ !empty($report['created_at']) ? \Illuminate\Support\Carbon::parse($report['created_at'])->diffForHumans() : 'Waktu tidak diketahui' }}
                                            </p>
                                        </div>
                                    </div>

                                    <span
                                        class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                        Dilaporkan
                                    </span>

                                </div>

                                <div class="mt-4">
                                    <p class="mb-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                        URL yang Dilaporkan
                                    </p>

                                    <div
                                        class="break-all rounded-lg bg-slate-50 px-3 py-2 text-sm text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $report['url'] ?? '-' }}
                                    </div>
                                </div>

                                <button type="button" @click="expanded = !expanded" :aria-expanded="expanded"
                                    class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-blue-500/50 dark:hover:bg-blue-500/10 dark:hover:text-blue-400">
                                    <span x-text="expanded ? 'Sembunyikan Detail' : 'Lihat Detail Laporan'"></span>

                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200"
                                        :class="{ 'rotate-180': expanded }"></i>
                                </button>

                            </div>

                            <div x-show="expanded" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="border-t border-slate-200 bg-slate-50/70 p-4 dark:border-slate-700 dark:bg-slate-800/40">

                                <div class="space-y-4">

                                    <div>
                                        <p class="mb-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                            Domain Utama
                                        </p>

                                        <div
                                            class="flex items-center gap-2 break-all text-sm text-slate-700 dark:text-slate-300">
                                            <i class="fa-solid fa-globe text-blue-500"></i>
                                            {{ $report['domain_url'] ?? '-' }}
                                        </div>
                                    </div>

                                    <div>
                                        <p class="mb-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                            URL Lengkap
                                        </p>

                                        <div
                                            class="break-all rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                            {{ $report['url'] ?? '-' }}
                                        </div>
                                    </div>

                                    @if (!empty($report['description']))
                                        <div>
                                            <p class="mb-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Deskripsi Laporan
                                            </p>

                                            <div
                                                class="rounded-lg border border-slate-200 bg-white p-3 text-sm leading-relaxed text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                                {{ $report['description'] }}
                                            </div>
                                        </div>
                                    @endif

                                    @if (!empty($report['reporter_name']))
                                        <div>
                                            <p class="mb-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Dilaporkan Oleh
                                            </p>

                                            <div
                                                class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                                <i class="fa-solid fa-user-circle text-blue-500"></i>
                                                {{ $report['reporter_name'] }}
                                            </div>
                                        </div>
                                    @endif

                                    @if (!empty($report['evidence']))
                                        <div>
                                            <p class="mb-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Bukti Pendukung
                                            </p>

                                            <a href="{{ Storage::disk('local')->temporaryUrl($report['evidence'], now()->addMinutes(10)) }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-100 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-500/20">
                                                <i class="fa-solid fa-paperclip"></i>
                                                Lihat Bukti
                                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                            </a>
                                        </div>
                                    @endif

                                    <div class="border-t border-slate-200 pt-3 dark:border-slate-700">
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            <i class="fa-regular fa-calendar mr-1"></i>
                                            Waktu Laporan:

                                            <span class="font-medium text-slate-700 dark:text-slate-300">
                                                {{ !empty($report['created_at']) ? \Illuminate\Support\Carbon::parse($report['created_at'])->translatedFormat('d F Y, H:i') : '-' }}
                                            </span>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div
                    class="mt-4 flex items-start gap-2 rounded-xl bg-blue-50 p-3 text-xs leading-relaxed text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>

                    <p>
                        Laporan komunitas merupakan informasi yang dikirimkan oleh pengguna JagaKlik.
                        Gunakan informasi ini sebagai referensi tambahan dan tetap berhati-hati saat mengakses URL.
                    </p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <div
                        class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                        <i class="fa-solid fa-clipboard-check text-2xl"></i>
                    </div>

                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">
                        Belum Ada Laporan Komunitas
                    </h4>

                    <p class="mt-1 max-w-sm text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                        Belum ditemukan laporan dari komunitas untuk URL atau domain yang sedang diperiksa.
                    </p>
                </div>

            @endif

        </div>
    </div>
</div>
