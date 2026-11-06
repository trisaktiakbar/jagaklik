<?php

use App\Services\PhishuntService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render(PhishuntService $phishunt)
    {
        $perPage = 50;
        $page = $this->getPage();

        $offset = ($page - 1) * $perPage;

        $search = trim($this->search);
        $contains = null;
        $searchError = null;

        if ($search !== '') {
            if (mb_strlen($search) < 3) {
                $searchError = 'Masukkan minimal 3 karakter untuk melakukan pencarian.';
            } elseif (mb_strlen($search) > 80 || !preg_match('/^[a-zA-Z0-9._-]{3,80}$/', $search)) {
                $searchError = 'Pencarian hanya mendukung huruf, angka, titik, tanda hubung, dan underscore (3–80 karakter).';
            } else {
                $contains = $search;
            }
        }

        $apiError = null;

        try {
            $data = $phishunt->getDomains(limit: $perPage, offset: $offset, contains: $contains);

            $domains = new LengthAwarePaginator($data['results'], (int) ($data['total'] ?? ($data['count'] ?? 0)), $perPage, $page, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        } catch (\Throwable $e) {
            report($e);

            $apiError = 'Tidak dapat mengambil data dari Phishunt. Silakan coba beberapa saat lagi.';

            $domains = new LengthAwarePaginator([], 0, $perPage, $page, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        }

        return $this->view([
            'domains' => $domains,
            'apiError' => $apiError,
            'searchError' => $searchError,
        ])->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Database Ancaman',
                'description' => 'Jelajahi database domain yang terindikasi phishing berdasarkan data threat intelligence Phishunt. Temukan informasi domain, alamat IP, negara server, dan sumber deteksi.',
                'keywords' => implode(', ', ['Database URL Berbahaya', 'Database Phishing', 'Daftar Website Phishing', 'Malicious URL', 'Phishing Database', 'Threat Intelligence']),
                'robots' => 'index, follow',
                'url' => route('guest.threat-database.index'),
            ],
        ]);
    }
};
?>

<div>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden px-5 py-16 lg:px-8">

        <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl">
        </div>

        <div class="relative mx-auto max-w-7xl">

            <div class="mx-auto max-w-3xl text-center">

                <span
                    class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-bold text-blue-600 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="fa-solid fa-database"></i>
                    Threat Intelligence Database
                </span>

                <h1
                    class="mt-7 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 dark:text-white sm:text-5xl">
                    Database URL
                    <span class="text-blue-600">Berbahaya.</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-sm leading-8 text-slate-600 dark:text-slate-400 sm:text-base">
                    Temukan daftar domain yang terindikasi phishing berdasarkan data threat intelligence Phishunt.
                    Gunakan database ini sebagai referensi untuk mengenali potensi ancaman di internet.
                </p>

            </div>

        </div>

    </section>


    {{-- Database Section --}}
    <section class="px-5 pb-20 lg:px-8">

        <div class="mx-auto max-w-7xl">

            {{-- Database Card --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-ink-850">

                {{-- Header --}}
                <div class="border-b border-slate-200 p-5 dark:border-white/10 sm:p-6">

                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white">
                                Daftar Domain Phishing
                            </h2>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                Data diperoleh secara langsung dari Phishunt.
                            </p>
                        </div>

                        <div
                            class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-600 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
                            Live API
                        </div>

                    </div>

                </div>


                {{-- Search --}}
                <div class="border-b border-slate-200 p-5 dark:border-white/10 sm:p-6">

                    <div class="relative">

                        <i
                            class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <input type="text" wire:model.live.debounce.500ms="search"
                            placeholder="Cari domain atau URL phishing..." maxlength="80"
                            class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-white/10 dark:bg-ink-900 dark:text-white dark:focus:border-blue-500">

                        @if ($search)
                            <button type="button" wire:click="$set('search', '')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-red-500"
                                title="Hapus pencarian">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </button>
                        @endif

                    </div>

                    @if ($searchError)
                        <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            {{ $searchError }}
                        </p>
                    @else
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Cari berdasarkan nama domain atau bagian URL. Minimal 3 karakter.
                        </p>
                    @endif

                </div>


                {{-- Loading --}}
                <div wire:loading.delay wire:target="search, gotoPage, nextPage, previousPage"
                    class="border-b border-blue-100 bg-blue-50 px-5 py-3 text-xs font-semibold text-blue-600 dark:border-blue-500/20 dark:bg-blue-500/5 dark:text-blue-400 w-full">
                    <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                    Mengambil data...
                </div>


                {{-- API Error --}}
                @if ($apiError)
                    <div class="p-8 text-center">

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-500 dark:bg-red-500/10">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                        </div>

                        <h3 class="mt-4 font-bold text-slate-900 dark:text-white">
                            Gagal Mengambil Data
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500 dark:text-slate-400">
                            {{ $apiError }}
                        </p>

                        <button type="button" wire:click="$refresh"
                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700">
                            <i class="fa-solid fa-rotate-right"></i>
                            Coba Lagi
                        </button>

                    </div>
                @else
                    {{-- Statistics --}}
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-5 py-4 dark:border-white/10 sm:px-6">

                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            Menampilkan
                            <span class="font-bold text-slate-900 dark:text-white">
                                {{ $domains->count() }}
                            </span>
                            dari
                            <span class="font-bold text-slate-900 dark:text-white">
                                {{ number_format($domains->total()) }}
                            </span>
                            domain
                        </div>


                    </div>


                    {{-- Table --}}
                    @if ($domains->isNotEmpty())

                        <div class="overflow-x-auto">

                            <table wire:loading.remove wire:target='search, gotoPage, nextPage, previousPage'
                                class="w-full min-w-[850px] text-left">

                                <thead class="bg-slate-50 dark:bg-ink-900/70">

                                    <tr
                                        class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">

                                        <th class="px-6 py-4">URL / Domain</th>

                                        <th class="px-6 py-4">Target Brand</th>

                                        <th class="px-6 py-4">IP Address</th>

                                        <th class="px-6 py-4">Negara</th>

                                        <th class="px-6 py-4">Pertama Terdeteksi</th>

                                        <th class="px-6 py-4 text-center">Risk Score</th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100 dark:divide-white/5">

                                    @foreach ($domains as $domain)
                                        <tr wire:key="phishunt-{{ $domain['uuid'] ?? $loop->index }}"
                                            class="transition hover:bg-slate-50 dark:hover:bg-white/[0.02]">

                                            {{-- URL --}}
                                            <td class="max-w-sm px-6 py-4">

                                                <div class="flex items-start gap-3">

                                                    <div
                                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-500 dark:bg-red-500/10">
                                                        <i class="fa-solid fa-shield-virus"></i>
                                                    </div>

                                                    <div class="min-w-0">

                                                        <p
                                                            class="break-all text-xs font-bold leading-6 text-slate-800 dark:text-slate-200">
                                                            {{ $domain['domain'] ?? ($domain['url'] ?? '-') }}
                                                        </p>

                                                        @if (!empty($domain['url']))
                                                            <p
                                                                class="mt-1 break-all text-[11px] leading-5 text-slate-400">
                                                                {{ $domain['url'] }}
                                                            </p>
                                                        @endif

                                                        <span
                                                            class="mt-2 inline-flex items-center gap-1 rounded-md bg-red-50 px-2 py-1 text-[10px] font-bold text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                                            Suspicious
                                                        </span>

                                                    </div>

                                                </div>

                                            </td>


                                            {{-- Company --}}
                                            <td class="px-6 py-4">

                                                @if (!empty($domain['company']))
                                                    <span
                                                        class="inline-flex rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400">
                                                        {{ ucfirst($domain['company']) }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-slate-400">-</span>
                                                @endif

                                            </td>


                                            {{-- IP --}}
                                            <td class="px-6 py-4">

                                                <span class="font-mono text-xs text-slate-600 dark:text-slate-300">
                                                    {{ $domain['ip'] ?? '-' }}
                                                </span>

                                            </td>


                                            {{-- Country --}}
                                            <td class="px-6 py-4">

                                                <span class="text-xs text-slate-600 dark:text-slate-300">
                                                    {{ $domain['country'] ?? '-' }}
                                                </span>

                                            </td>


                                            {{-- First Seen --}}
                                            <td class="px-6 py-4">

                                                <span
                                                    class="whitespace-nowrap text-xs text-slate-600 dark:text-slate-300">
                                                    @if (!empty($domain['first_seen']))
                                                        {{ Carbon::parse($domain['first_seen'])->format('d M Y, H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>

                                            </td>


                                            {{-- Score --}}
                                            <td class="px-6 py-4 text-center">

                                                @if (isset($domain['score']))
                                                    <div class="flex flex-col items-center gap-1">

                                                        <span
                                                            class="text-sm font-extrabold text-red-600 dark:text-red-400">
                                                            {{ $domain['score'] }}/100
                                                        </span>

                                                        @if (!empty($domain['verdict']))
                                                            <span
                                                                class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400">
                                                                {{ $domain['verdict'] }}
                                                            </span>
                                                        @endif

                                                    </div>
                                                @else
                                                    <span class="text-xs text-slate-400">-</span>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>


                        {{-- Pagination --}}
                        <div class="border-t border-slate-200 p-5 dark:border-white/10 sm:p-6">

                            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Halaman
                                    <span class="font-bold text-slate-900 dark:text-white">
                                        {{ $domains->currentPage() }}
                                    </span>
                                    dari
                                    <span class="font-bold text-slate-900 dark:text-white">
                                        {{ max(1, $domains->lastPage()) }}
                                    </span>
                                </p>

                                <div>
                                    {{ $domains->links(data: ['scrollTo' => false]) }}
                                </div>

                            </div>

                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="px-5 py-16 text-center">

                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-white/5 dark:text-slate-500">
                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>

                            <h3 class="mt-5 font-bold text-slate-900 dark:text-white">
                                Tidak Ada Data Ditemukan
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500 dark:text-slate-400">
                                Tidak ditemukan domain yang sesuai dengan pencarian kamu.
                                Coba gunakan kata kunci lainnya.
                            </p>

                            @if ($search)
                                <button type="button" wire:click="$set('search', '')"
                                    class="mt-5 text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                    Hapus Pencarian
                                </button>
                            @endif

                        </div>

                    @endif

                @endif

            </div>


            {{-- Disclaimer --}}
            <div
                class="mt-6 flex gap-4 rounded-2xl border border-amber-200 bg-amber-50 p-5 dark:border-amber-500/20 dark:bg-amber-500/5">

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <div>

                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                        Informasi Penting
                    </h3>

                    <p class="mt-2 text-xs leading-7 text-slate-600 dark:text-slate-400">
                        Data ini bersumber dari Phishunt dan menunjukkan domain yang terindikasi sebagai phishing.
                        Informasi dapat berubah sewaktu-waktu dan berpotensi mengandung false positive.
                        Jangan mengakses URL mencurigakan secara langsung. Gunakan JagaKlik untuk melakukan
                        pemeriksaan tambahan sebelum mengambil keputusan.
                    </p>

                </div>

            </div>

        </div>

    </section>

</div>
