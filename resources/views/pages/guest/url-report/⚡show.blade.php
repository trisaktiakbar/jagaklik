<?php

use App\Models\UrlReport;
use Livewire\Component;

new class extends Component {
    public UrlReport $report;

    public function mount(int $id): void
    {
        $this->report = UrlReport::query()->findOrFail($id);
    }

    public function render()
    {
        $keywords = match ($this->report->category) {
            'phishing' => [
                'Laporan Phishing',
                'Link Phishing',
                'Website Phishing',
                'Laporan URL Mencurigakan',
                'Keamanan Digital',
            ],

            'scam' => [
                'Laporan Penipuan Online',
                'Link Penipuan',
                'Website Penipuan',
                'Scam Online',
                'Laporan URL Mencurigakan',
            ],

            'malware' => [
                'Laporan Malware',
                'URL Malware',
                'Website Berbahaya',
                'Ancaman Malware',
                'Keamanan Siber',
            ],

            'spam' => [
                'Laporan Spam',
                'URL Spam',
                'Website Spam',
                'Tautan Mencurigakan',
            ],

            'fake_website' => [
                'Laporan Website Palsu',
                'Situs Palsu',
                'Website Tiruan',
                'Domain Mencurigakan',
            ],

            'prohibited_content' => [
                'Laporan Konten Terlarang',
                'Website Konten Terlarang',
                'Laporan Website',
            ],

            'suspicious' => [
                'Laporan Aktivitas Mencurigakan',
                'URL Mencurigakan',
                'Domain Mencurigakan',
                'Ancaman Siber',
            ],

            default => [
                'Laporan URL',
                'Laporan Komunitas',
                'Keamanan Digital',
            ],
        };

        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Detail Laporan ' . $this->getCategoryLabel() . ' - ' . ($this->report->domain_url ?: 'URL Mencurigakan'),
                'description' => 'Detail laporan komunitas JagaKlik mengenai ' . $this->getCategoryLabel() . ' pada domain ' . ($this->report->domain_url ?: 'yang dilaporkan') . '. Lihat informasi URL, kategori ancaman, dan bukti pendukung laporan.',
                'keywords' => implode(', ', array_merge($keywords, [
                    'Detail Laporan URL',
                    'Laporan Komunitas',
                ])),
                'robots' => 'noindex, follow',
                'url' => route('guest.url-report.show', $this->report->id),
            ],
        ]);
    }

    public function getCategoryLabel(): string
    {
        return match ($this->report->category) {
            'phishing' => 'Phishing',
            'scam' => 'Penipuan Online',
            'malware' => 'Malware',
            'spam' => 'Spam',
            'fake_website' => 'Website Palsu',
            'prohibited_content' => 'Konten Terlarang',
            'suspicious' => 'Aktivitas Mencurigakan',
            'other' => 'Lainnya',
            default => 'Tidak diketahui',
        };
    }

    public function getCategoryIcon(): string
    {
        return match ($this->report->category) {
            'phishing' => 'fa-fish',
            'scam' => 'fa-money-bill-transfer',
            'malware' => 'fa-bug',
            'spam' => 'fa-envelope',
            'fake_website' => 'fa-globe',
            'prohibited_content' => 'fa-ban',
            'suspicious' => 'fa-triangle-exclamation',
            default => 'fa-shield-halved',
        };
    }
};
?>

<div class="min-h-screen bg-slate-50 px-4 py-12 dark:bg-[#0b1220] sm:px-6 lg:px-8">

    <div class="mx-auto max-w-3xl">



        {{-- Page Header --}}
        <div class="mb-8 text-center">

            <div
                class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                <i class="fa-solid fa-file-lines text-2xl"></i>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Detail Laporan URL
            </h1>

            <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400 sm:text-base">
                Informasi lengkap mengenai URL yang telah dilaporkan melalui platform JagaKlik.
            </p>

        </div>

        {{-- Report Information --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-[#101a2b]">

            {{-- Card Header --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-5 dark:border-slate-800 sm:px-8">

                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                        Informasi Laporan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        ID Laporan #{{ $report->id }}
                    </p>
                </div>

                <span
                    class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">

                    <i class="fa-solid {{ $this->getCategoryIcon() }}"></i>

                    {{ $this->getCategoryLabel() }}

                </span>

            </div>

            <div class="space-y-6 p-6 sm:p-8">

                {{-- Reported URL --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        URL Website
                    </label>

                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-[#0b1220]">

                        {{-- Domain --}}
                        <div class="mb-3 flex items-center gap-2">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                <i class="fa-solid fa-globe"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Domain Utama
                                </p>

                                <p class="break-all text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $report->domain_url ?: 'Tidak tersedia' }}
                                </p>

                            </div>

                        </div>

                        <div class="border-t border-slate-200 dark:border-slate-700"></div>

                        {{-- Full URL --}}
                        <div class="mt-3 flex items-start gap-3">

                            <i class="fa-solid fa-link mt-1 text-sm text-slate-400"></i>

                            <div class="min-w-0 flex-1">

                                <p class="mb-1 text-xs text-slate-500 dark:text-slate-400">
                                    URL Lengkap
                                </p>

                                <p class="break-all text-sm font-medium leading-6 text-slate-800 dark:text-slate-200">
                                    {{ $report->url }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Category --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Kategori Laporan
                    </label>

                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 p-4 dark:border-slate-700">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">

                            <i class="fa-solid {{ $this->getCategoryIcon() }}"></i>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                {{ $this->getCategoryLabel() }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                Kategori ancaman yang dipilih oleh pelapor.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Description --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Deskripsi Laporan
                    </label>

                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-[#0b1220]">

                        @if (filled($report->description))
                        <p
                            class="whitespace-pre-line break-words text-sm leading-7 text-slate-700 dark:text-slate-300">
                            {{ $report->description }}
                        </p>
                        @else
                        <div class="flex items-center gap-2 text-slate-400">

                            <i class="fa-regular fa-comment-dots"></i>

                            <p class="text-sm italic">
                                Pelapor tidak memberikan deskripsi tambahan.
                            </p>

                        </div>
                        @endif

                    </div>

                </div>

                {{-- Evidence --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Bukti Pendukung
                    </label>

                    @if ($report->evidence)
                    <div
                        class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-4 dark:border-slate-700">

                        <div class="flex min-w-0 items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">

                                <i class="fa-solid fa-image"></i>

                            </div>

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    Bukti pendukung telah disertakan
                                </p>

                            </div>

                        </div>

                        <a href="{{ Storage::disk('local')->temporaryUrl($report['evidence'], now()->addMinutes(10)) }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition hover:bg-blue-100 dark:bg-blue-400/10 dark:text-blue-400 dark:hover:bg-blue-400/20">

                            <i class="fa-solid fa-eye"></i>

                            Lihat Bukti

                        </a>

                    </div>
                    @else
                    <div
                        class="flex items-center gap-3 rounded-xl border border-slate-200 p-4 dark:border-slate-700">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">

                            <i class="fa-regular fa-image"></i>

                        </div>

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Tidak ada bukti pendukung yang disertakan.
                        </p>

                    </div>
                    @endif

                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-200 dark:border-slate-800"></div>

                {{-- Report Metadata --}}
                <div>

                    <h3 class="mb-4 text-base font-bold text-slate-900 dark:text-white">
                        Informasi Pengiriman
                    </h3>

                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- Reporter --}}
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-[#0b1220]">

                            <div class="mb-2 flex items-center gap-2 text-slate-400">

                                <i class="fa-solid fa-user text-xs"></i>

                                <span class="text-xs font-medium">
                                    Pelapor
                                </span>

                            </div>

                            <p class="break-words text-sm font-semibold text-slate-800 dark:text-slate-200">
                                {{ filled($report->reporter_name) ? $report->reporter_name : 'Anonim' }}
                            </p>

                        </div>

                        {{-- Date --}}
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-[#0b1220]">

                            <div class="mb-2 flex items-center gap-2 text-slate-400">

                                <i class="fa-solid fa-calendar-days text-xs"></i>

                                <span class="text-xs font-medium">
                                    Tanggal Laporan
                                </span>

                            </div>

                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">

                                {{ $report->created_at?->translatedFormat('d F Y, H:i') ?? 'Tidak tersedia' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Disclaimer --}}
        <div
            class="mt-6 flex gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-500/20 dark:bg-amber-500/5">

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">

                <i class="fa-solid fa-circle-info"></i>

            </div>

            <div>

                <h3 class="text-sm font-semibold text-amber-900 dark:text-amber-300">
                    Informasi Penting
                </h3>

                <p class="mt-1 text-sm leading-6 text-amber-800/80 dark:text-amber-300/70">
                    Laporan ini merupakan informasi yang dikirimkan oleh pengguna.
                    Kategori dan deskripsi laporan bukan merupakan konfirmasi bahwa
                    website tersebut terbukti berbahaya. Selalu lakukan pemeriksaan
                    tambahan sebelum mengambil tindakan.
                </p>

            </div>

        </div>

        {{-- Back Button --}}
        <div class="mt-8 flex justify-center">

            <a wire:navigate href="{{ route('guest.url-report.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-slate-700 dark:bg-[#101a2b] dark:text-slate-300 dark:hover:border-blue-500 dark:hover:text-blue-400">

                <i class="fa-solid fa-arrow-left text-xs"></i>

                Kembali ke Daftar Laporan

            </a>

        </div>

    </div>

</div>