<?php

use App\Models\UrlReport;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public string $category = '';

    /**
     * Mengambil daftar laporan URL.
     */
    #[Computed]
    public function reports()
    {
        return UrlReport::query()
            ->select(['id', 'url', 'domain_url', 'category', 'description', 'created_at'])
            ->when(trim($this->search) !== '', function ($query) {
                $search = trim($this->search);

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('url', 'like', "%{$search}%")
                        ->orWhere('domain_url', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($this->category !== '', function ($query) {
                $query->where('category', $this->category);
            })
            ->latest()
            ->paginate(50);
    }

    /**
     * Mengambil total seluruh laporan.
     * Tidak terpengaruh pencarian maupun filter kategori.
     */
    #[Computed]
    public function totalReports(): int
    {
        return UrlReport::count();
    }

    /**
     * Reset halaman ketika pencarian berubah.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset halaman ketika kategori berubah.
     */
    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    /**
     * Menghapus seluruh filter.
     */
    public function clearFilters(): void
    {
        $this->reset(['search', 'category']);

        $this->resetPage();
    }

    /**
     * Metadata halaman.
     */
    public function render()
    {
        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Laporan URL',
                'description' => 'Jelajahi laporan komunitas JagaKlik mengenai URL mencurigakan, situs phishing, penipuan online, malware, dan berbagai ancaman digital yang dilaporkan pengguna.',
                'keywords' => implode(', ', [
                    'Laporan Komunitas',
                    'Laporan URL Mencurigakan',
                    'Daftar Link Penipuan',
                    'Daftar Link Phishing',
                    'Laporan Phishing',
                    'Laporan Website Berbahaya',
                    'Laporan Malware',
                    'Database URL Berbahaya',
                    'Ancaman Siber',
                    'Keamanan Digital',
                    'Daftar Website Berbahaya',
                ]),
                'robots' => 'index, follow',
                'url' => route('guest.url-report.index'),
            ],
        ]);
    }

    /**
     * Label kategori laporan.
     */
    public function getCategoryLabel(string $category): string
    {
        return match ($category) {
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

    /**
     * Icon kategori laporan.
     */
    public function getCategoryIcon(string $category): string
    {
        return match ($category) {
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

    <div class="mx-auto max-w-7xl pt-4">


        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div
                    class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="fa-solid fa-shield-halved"></i>
                    Kontribusi Komunitas
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Laporan URL Mencurigakan
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-400 sm:text-base">
                    Temukan informasi URL yang telah dilaporkan oleh komunitas untuk membantu meningkatkan
                    kesadaran terhadap berbagai ancaman digital.
                </p>
            </div>

            <a wire:navigate href="{{ route('guest.url-report.create') }}"
                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                <i class="fa-solid fa-flag"></i>
                Laporkan URL
            </a>

        </div>

        {{-- Statistics --}}
        <div class="mb-6 grid gap-4 sm:grid-cols-2">

            {{-- Total Reports --}}
            <div
                class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-[#101a2b]">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="fa-solid fa-file-lines text-lg"></i>
                </div>

                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Total Laporan
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">
                        {{ number_format($this->totalReports) }}
                    </p>
                </div>

            </div>

            {{-- Community Contribution --}}
            <div
                class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-[#101a2b]">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>

                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Kontribusi Komunitas
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">
                        Bersama menjaga keamanan digital
                    </p>
                </div>

            </div>

        </div>

        {{-- Report List --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-[#101a2b]">

            {{-- Search and Filter --}}
            <div class="border-b border-slate-200 p-5 dark:border-slate-800 sm:p-6">

                <div class="mb-5">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                        Daftar Laporan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Jelajahi laporan URL berdasarkan kata kunci atau kategori.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">

                    {{-- Search --}}
                    <div class="relative flex-1">

                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <input type="search" wire:model.live.debounce.400ms="search"
                            placeholder="Cari URL, domain, atau deskripsi laporan..."
                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:placeholder:text-slate-500">

                    </div>

                    {{-- Category Filter --}}
                    <div class="relative sm:w-64">

                        <select wire:model.live="category"
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 pr-10 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-slate-200">

                            <option value="">Semua Kategori</option>
                            <option value="phishing">Phishing</option>
                            <option value="scam">Penipuan Online</option>
                            <option value="malware">Malware</option>
                            <option value="spam">Spam</option>
                            <option value="fake_website">Website Palsu</option>
                            <option value="prohibited_content">Konten Terlarang</option>
                            <option value="suspicious">Aktivitas Mencurigakan</option>
                            <option value="other">Lainnya</option>

                        </select>

                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>

                    </div>

                    {{-- Clear Filter --}}
                    @if ($search !== '' || $category !== '')
                    <button type="button" wire:click="clearFilters"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-3 text-sm font-medium text-slate-600 transition hover:border-red-300 hover:text-red-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-red-500 dark:hover:text-red-400">

                        <i class="fa-solid fa-xmark"></i>
                        Reset

                    </button>
                    @endif

                </div>

            </div>

            {{-- Loading Indicator --}}
            <div wire:loading.delay wire:target="search, category"
                class="border-b border-blue-100 bg-blue-50 px-6 py-3 text-xs font-medium text-blue-600 dark:border-blue-500/10 dark:bg-blue-500/5 dark:text-blue-400">

                <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                Memuat laporan...

            </div>

            {{-- Results --}}
            <div class="p-5 sm:p-6">

                @forelse ($this->reports as $report)
                <div wire:key="report-{{ $report->id }}"
                    class="group mb-4 rounded-xl border border-slate-200 p-5 transition hover:border-blue-300 hover:shadow-sm dark:border-slate-700 dark:hover:border-blue-500/50">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">

                        {{-- Category Icon --}}
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">

                            <i class="fa-solid {{ $this->getCategoryIcon($report->category) }} text-lg"></i>

                        </div>

                        {{-- Report Content --}}
                        <div class="min-w-0 flex-1">

                            {{-- Category and ID --}}
                            <div class="mb-2 flex flex-wrap items-center gap-2">

                                <span
                                    class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                    {{ $this->getCategoryLabel($report->category) }}
                                </span>

                                <span class="text-xs text-slate-400">
                                    #{{ $report->id }}
                                </span>

                            </div>

                            {{-- Domain --}}
                            <div class="mb-1 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">

                                <i class="fa-solid fa-globe"></i>

                                <span class="break-all">
                                    {{ $report->domain_url }}
                                </span>

                            </div>

                            {{-- Full URL --}}
                            <h3 class="break-all text-sm font-bold leading-6 text-slate-900 dark:text-white">
                                {{ $report->url }}
                            </h3>

                            {{-- Description --}}
                            <p
                                class="mt-2 line-clamp-2 break-words text-sm leading-6 text-slate-500 dark:text-slate-400">
                                {{ $report->description ?: 'Tidak ada deskripsi tambahan.' }}
                            </p>

                            {{-- Metadata --}}
                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-400">

                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{ $report->created_at->format('d M Y') }}
                                </span>

                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-clock"></i>
                                    {{ $report->created_at->format('H:i') }}
                                </span>

                            </div>

                        </div>

                        {{-- Detail Link --}}
                        <div class="shrink-0 sm:self-center">

                            <a wire:navigate href="{{ route('guest.url-report.show', $report->id) }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-blue-500 dark:hover:bg-blue-500/10 dark:hover:text-blue-400">

                                Lihat Detail

                                <i class="fa-solid fa-arrow-right text-[10px]"></i>

                            </a>

                        </div>

                    </div>

                </div>

                @empty

                {{-- Empty State --}}
                <div class="py-16 text-center">

                    <div
                        class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">

                        <i class="fa-solid fa-folder-open text-2xl"></i>

                    </div>

                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        Tidak Ada Laporan Ditemukan
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">

                        @if ($search !== '' || $category !== '')
                        Tidak ditemukan laporan yang sesuai dengan pencarian atau kategori yang dipilih.
                        @else
                        Belum ada laporan URL yang dikirimkan. Jadilah yang pertama berkontribusi untuk keamanan
                        digital.
                        @endif

                    </p>

                    @if ($search !== '' || $category !== '')
                    <button type="button" wire:click="clearFilters"
                        class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">

                        <i class="fa-solid fa-rotate-left"></i>
                        Reset Filter

                    </button>
                    @else
                    <a wire:navigate href="{{ route('guest.url-report.create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                        <i class="fa-solid fa-flag"></i>
                        Laporkan URL

                    </a>
                    @endif

                </div>
                @endforelse

                {{-- Pagination --}}
                @if ($this->reports->hasPages())
                <div class="mt-6 border-t border-slate-200 pt-6 dark:border-slate-800">
                    {{ $this->reports->links() }}
                </div>
                @endif

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
                    Informasi dalam daftar ini berasal dari laporan pengguna dan belum tentu menunjukkan bahwa
                    URL tersebut terbukti berbahaya. Selalu lakukan pemeriksaan sebelum mengunjungi suatu website.
                </p>

            </div>

        </div>

    </div>

</div>