<?php

use App\Models\UrlScan;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: 'all')]
    public string $status = 'all';

    public function render()
    {
        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Riwayat Pemeriksaan URL',
                'description' => 'Lihat riwayat pemeriksaan URL di JagaKlik. Pantau hasil analisis keamanan tautan, status deteksi phishing, malware, penipuan online, dan berbagai potensi ancaman digital lainnya.',
                'keywords' => implode(', ', [
                    'Riwayat Pemeriksaan URL',
                    'Riwayat Scan URL',
                    'Riwayat Cek Link',
                    'Hasil Pemeriksaan URL',
                    'Riwayat Deteksi Phishing',
                    'Riwayat Deteksi Malware',
                    'Analisis Keamanan URL',
                    'Pemeriksaan Keamanan Website',
                    'URL Scanner',
                ]),
                'robots' => 'noindex, follow',
                'url' => route('guest.url-scan-history.index'),
            ],
        ]);
    }

    #[Computed]
    public function scans()
    {
        return UrlScan::query()
            ->when($this->search !== '', function (Builder $query) {
                $search = trim($this->search);

                $query->where(function (Builder $query) use ($search) {
                    $query->where('url', 'like', "%{$search}%")->orWhere('domain', 'like', "%{$search}%");
                });
            })
            ->when(in_array($this->status, ['malicious', 'suspicious', 'safe', 'partial', 'unavailable'], true), fn(Builder $query) => $query->where('status', $this->status))
            ->latest('scanned_at')
            ->paginate(10);
    }

    /**
     * Statistik keseluruhan riwayat pemindaian.
     */
    #[Computed]
    public function statistics(): array
    {
        return [
            'total' => UrlScan::count(),
            'malicious' => UrlScan::where('status', 'malicious')->count(),
            'suspicious' => UrlScan::where('status', 'suspicious')->count(),
            'safe' => UrlScan::where('status', 'safe')->count(),
        ];
    }

    /**
     * Reset pagination ketika pencarian berubah.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination ketika filter berubah.
     */
    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Menghapus seluruh filter.
     */
    public function clearFilters(): void
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }

    /**
     * Label status pemindaian.
     */
    public function statusLabel(string $status): string
    {
        return match ($status) {
            'malicious' => 'Berbahaya',
            'suspicious' => 'Mencurigakan',
            'safe' => 'Tidak Ditemukan Ancaman',
            'partial' => 'Belum Lengkap',
            'unavailable' => 'Tidak Tersedia',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Warna status pemindaian.
     */
    public function statusClasses(string $status): string
    {
        return match ($status) {
            'malicious' => 'bg-rose-100 text-rose-700 dark:bg-rose-400/10 dark:text-rose-400',
            'suspicious' => 'bg-amber-100 text-amber-700 dark:bg-amber-400/10 dark:text-amber-400',
            'safe' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400',
            'partial' => 'bg-orange-100 text-orange-700 dark:bg-orange-400/10 dark:text-orange-400',
            'unavailable' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
            default => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
        };
    }

    /**
     * Ikon status pemindaian.
     */
    public function statusIcon(string $status): string
    {
        return match ($status) {
            'malicious' => 'fa-shield-virus',
            'suspicious' => 'fa-shield-halved',
            'safe' => 'fa-shield',
            'partial' => 'fa-circle-exclamation',
            'unavailable' => 'fa-triangle-exclamation',
            default => 'fa-circle-question',
        };
    }
};
?>

<div class="min-h-screen bg-slate-50 py-12 dark:bg-[#0b1220]">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-8">

            <div
                class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-400/10 dark:text-blue-400">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Scan History
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Riwayat Pemindaian
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Lihat seluruh riwayat pemeriksaan URL, termasuk status keamanan,
                waktu pemindaian, dan informasi ancaman yang ditemukan.
            </p>

        </div>

        {{-- Statistics --}}
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Total Scans --}}
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700/70 dark:bg-[#101a2b]">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Total Pemindaian
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                            {{ number_format($this->statistics['total']) }}
                        </h3>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">
                        <i class="fa-solid fa-magnifying-glass-chart text-lg"></i>
                    </div>

                </div>

            </div>

            {{-- Malicious --}}
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700/70 dark:bg-[#101a2b]">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Ancaman Terdeteksi
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-rose-600 dark:text-rose-400">
                            {{ number_format($this->statistics['malicious']) }}
                        </h3>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-400/10 dark:text-rose-400">
                        <i class="fa-solid fa-shield-virus text-lg"></i>
                    </div>

                </div>

            </div>

            {{-- Suspicious --}}
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700/70 dark:bg-[#101a2b]">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Mencurigakan
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-amber-600 dark:text-amber-400">
                            {{ number_format($this->statistics['suspicious']) }}
                        </h3>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-400">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                    </div>

                </div>

            </div>

            {{-- Safe --}}
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700/70 dark:bg-[#101a2b]">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Tidak Ditemukan Ancaman
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                            {{ number_format($this->statistics['safe']) }}
                        </h3>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-400">
                        <i class="fa-solid fa-shield text-lg"></i>
                    </div>

                </div>

            </div>

        </div>

        {{-- History Container --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700/70 dark:bg-[#101a2b]">

            {{-- History Header --}}
            <div class="border-b border-slate-200 p-5 sm:p-6 dark:border-slate-700">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                            Daftar Riwayat
                        </h2>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Daftar URL yang pernah diperiksa.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">

                        {{-- Search --}}
                        <div class="relative sm:min-w-72">

                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>

                            <input type="search" wire:model.live.debounce.400ms="search"
                                placeholder="Cari URL atau domain..."
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:focus:border-blue-400">

                        </div>

                        {{-- Status Filter --}}
                        <div class="relative">

                            <select wire:model.live="status"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-medium text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 sm:min-w-48 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:focus:border-blue-400">
                                <option value="all">Semua Status</option>
                                <option value="malicious">Berbahaya</option>
                                <option value="suspicious">Mencurigakan</option>
                                <option value="safe">Tidak Ditemukan Ancaman</option>
                                <option value="partial">Belum Lengkap</option>
                                <option value="unavailable">Tidak Tersedia</option>
                            </select>

                            <i
                                class="fa-solid fa-chevron-down pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>

                        </div>

                    </div>

                </div>

                {{-- Active Filters --}}
                @if ($search !== '' || $status !== 'all')

                <div class="mt-4 flex flex-wrap items-center gap-2">

                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Filter aktif:
                    </span>

                    @if ($search !== '')
                    <span
                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 dark:bg-blue-400/10 dark:text-blue-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        {{ $search }}
                    </span>
                    @endif

                    @if ($status !== 'all')
                    <span
                        class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 dark:bg-blue-400/10 dark:text-blue-400">
                        <i class="fa-solid fa-filter"></i>
                        {{ $this->statusLabel($status) }}
                    </span>
                    @endif

                    <button type="button" wire:click="clearFilters"
                        class="ml-1 text-xs font-semibold text-rose-600 transition hover:text-rose-700 dark:text-rose-400">
                        Hapus Filter
                    </button>

                </div>

                @endif

            </div>

            {{-- History List --}}
            <div>

                @forelse ($this->scans as $scan)

                <div wire:key="scan-history-{{ $scan->id }}"
                    class="border-b border-slate-100 p-5 last:border-b-0 sm:p-6 dark:border-slate-700/70">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">

                        {{-- Status Icon --}}
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $this->statusClasses($scan->status) }}">
                            <i class="fa-solid {{ $this->statusIcon($scan->status) }} text-lg"></i>
                        </div>

                        {{-- Scan Information --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div class="min-w-0">

                                    <h3 class="break-all text-sm font-bold text-slate-900 dark:text-white">
                                        {{ $scan->domain ?: 'Domain tidak diketahui' }}
                                    </h3>

                                    <p class="mt-1 break-all text-xs leading-5 text-slate-500 dark:text-slate-400">
                                        {{ $scan->url }}
                                    </p>

                                </div>

                                {{-- Status Badge --}}
                                <div class="shrink-0">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold {{ $this->statusClasses($scan->status) }}">
                                        <i class="fa-solid {{ $this->statusIcon($scan->status) }}"></i>
                                        {{ $this->statusLabel($scan->status) }}
                                    </span>

                                </div>

                            </div>

                            {{-- Scan Metadata --}}
                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2">

                                <span
                                    class="inline-flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $scan->scanned_at?->format('d M Y') ?? '-' }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $scan->scanned_at?->format('H:i') ?? '-' }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <i class="fa-solid fa-database"></i>
                                    {{ $scan->successful_sources }}/{{ $scan->total_sources }} sumber diperiksa
                                </span>

                                <span
                                    class="inline-flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    {{ $scan->detected_sources }} sumber mendeteksi ancaman
                                </span>

                            </div>

                            {{-- Detail --}}
                            <details class="group mt-4">

                                <summary
                                    class="inline-flex cursor-pointer list-none items-center gap-2 text-xs font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">

                                    <i class="fa-solid fa-circle-info"></i>
                                    Lihat Detail

                                    <i
                                        class="fa-solid fa-chevron-down text-[10px] transition-transform group-open:rotate-180"></i>

                                </summary>

                                <div
                                    class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-[#0b1220]">

                                    <div class="grid gap-4 sm:grid-cols-2">

                                        <div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                URL yang Diperiksa
                                            </p>

                                            <p
                                                class="mt-1 break-all text-sm font-medium text-slate-800 dark:text-slate-200">
                                                {{ $scan->url }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Domain
                                            </p>

                                            <p
                                                class="mt-1 break-all text-sm font-medium text-slate-800 dark:text-slate-200">
                                                {{ $scan->domain ?: '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Status Pemeriksaan
                                            </p>

                                            <p
                                                class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                {{ $this->statusLabel($scan->status) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Waktu Pemindaian
                                            </p>

                                            <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200">
                                                {{ $scan->scanned_at?->format('d F Y, H:i:s') ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Sumber Berhasil Diperiksa
                                            </p>

                                            <p
                                                class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                {{ $scan->successful_sources }} dari {{ $scan->total_sources }}
                                                sumber
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                Sumber yang Mendeteksi Ancaman
                                            </p>

                                            <p
                                                class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                {{ $scan->detected_sources }} sumber
                                            </p>
                                        </div>

                                    </div>

                                    {{-- Source Results --}}
                                    <div class="mt-5 border-t border-slate-200 pt-4 dark:border-slate-700">

                                        <h4 class="text-xs font-bold text-slate-800 dark:text-white">
                                            Hasil Sumber Intelijen
                                        </h4>

                                        <div class="mt-3 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">

                                            @php
                                            $sourceResults = [
                                            'Google Safe Browsing' =>
                                            $scan->results['google_safe_browsing'] ?? null,
                                            'URLhaus' => $scan->results['urlhaus'] ?? null,
                                            'OpenPhish' => $scan->results['openphish'] ?? null,
                                            'ThreatFox' => $scan->results['threatfox'] ?? null,
                                            'VirusTotal' => $scan->results['virustotal'] ?? null,
                                            'AlienVault OTX' => $scan->results['alienvault_otx'] ?? null,
                                            ];

                                            $sourceErrors = $scan->results['errors'] ?? [];

                                            $sourceErrorKeys = [
                                            'Google Safe Browsing' => 'google',
                                            'URLhaus' => 'urlhaus',
                                            'OpenPhish' => 'openphish',
                                            'ThreatFox' => 'threatfox',
                                            'VirusTotal' => 'virustotal',
                                            'AlienVault OTX' => 'alienvault',
                                            ];
                                            @endphp

                                            @foreach ($sourceResults as $sourceName => $sourceResult)
                                            @php
                                            $sourceError =
                                            $sourceErrors[$sourceErrorKeys[$sourceName]] ?? null;
                                            @endphp

                                            <div
                                                class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2.5 dark:border-slate-700 dark:bg-[#101a2b]">

                                                <span
                                                    class="text-xs font-medium text-slate-700 dark:text-slate-300">
                                                    {{ $sourceName }}
                                                </span>

                                                @if ($sourceError || $sourceResult === null)
                                                <span
                                                    class="shrink-0 text-[11px] font-semibold text-amber-600 dark:text-amber-400">
                                                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                                    Tidak Tersedia
                                                </span>
                                                @else
                                                <span
                                                    class="shrink-0 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                                                    <i class="fa-solid fa-circle-check mr-1"></i>
                                                    Tersedia
                                                </span>
                                                @endif

                                            </div>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            </details>

                        </div>

                    </div>

                </div>

                @empty

                {{-- Empty State --}}
                <div class="px-5 py-16 text-center sm:px-8">

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-400/10 dark:text-blue-400">
                        <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                    </div>

                    @if ($search !== '' || $status !== 'all')
                    <h3 class="mt-5 text-base font-bold text-slate-900 dark:text-white">
                        Riwayat Tidak Ditemukan
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Tidak ada riwayat pemindaian yang sesuai dengan pencarian atau filter yang kamu gunakan.
                    </p>

                    <button type="button" wire:click="clearFilters"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                        Hapus Filter
                    </button>
                    @else
                    <h3 class="mt-5 text-base font-bold text-slate-900 dark:text-white">
                        Belum Ada Riwayat Pemindaian
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Kamu belum melakukan pemeriksaan URL. Mulai periksa tautan untuk melihat hasilnya di
                        halaman ini.
                    </p>

                    <a wire:navigate href="{{ route('guest.check-url.index') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Periksa URL Sekarang
                    </a>
                    @endif

                </div>

                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($this->scans->hasPages())
            <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-700 sm:px-6">

                {{ $this->scans->links() }}

            </div>
            @endif

        </div>

        {{-- Information --}}
        <div
            class="mt-6 flex gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-400/20 dark:bg-blue-400/10">

            <i class="fa-solid fa-circle-info mt-0.5 text-blue-500"></i>

            <p class="text-xs leading-6 text-blue-800 dark:text-blue-300">
                Riwayat pemindaian mencatat hasil pemeriksaan URL dari berbagai sumber Threat Intelligence.
                Status keamanan dapat berubah seiring pembaruan database ancaman.
                Hasil pemeriksaan sebelumnya tidak selalu mencerminkan kondisi URL saat ini.
            </p>

        </div>

    </div>

</div>