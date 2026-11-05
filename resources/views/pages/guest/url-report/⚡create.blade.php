<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $url = '';

    public string $category = '';

    public string $description = '';

    public $evidence = null;

    public string $reporter_name = '';

    public string $reporter_email = '';

    public ?string $successMessage = null;

    public function render()
    {
        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Laporkan URL - Laporkan Tautan Mencurigakan',
                'description' => 'Temukan tautan mencurigakan atau berbahaya? Laporkan URL melalui JagaKlik untuk membantu pengguna lain mengenali phishing, penipuan online, malware, dan ancaman digital.',
                'keywords' => implode(', ', [
                    'Laporkan URL',
                    'Laporkan Link',
                    'Lapor Link Penipuan',
                    'Laporkan Link Penipuan',
                    'Lapor Link Phishing',
                    'Laporkan Link Phishing',
                    'Laporan URL Mencurigakan',
                    'Laporan Website Berbahaya',
                    'Pelaporan Phishing',
                    'Pelaporan Penipuan',
                    'Pelaporan Website',
                    'Laporan Ancaman Siber',
                    'Keamanan Digital',
                ]),
                'robots' => 'index, follow',
                'url' => route('guest.url-report.create'),
            ],
        ]);
    }

    public function submit(): void
    {
        $this->resetValidation();

        $this->successMessage = null;

        // Hilangkan spasi di awal dan akhir URL sebelum validasi.
        $this->url = trim($this->url);

        // Validasi formulir.
        $validated = $this->validate(
            [
                'url' => ['required', 'string', 'url:http,https', 'max:4000'],

                'category' => ['required', 'string', Rule::in(['phishing', 'scam', 'malware', 'spam', 'fake_website', 'prohibited_content', 'suspicious', 'other'])],

                'description' => ['nullable', 'string', 'max:2000'],

                'evidence' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

                'reporter_name' => ['nullable', 'string', 'max:100'],

                'reporter_email' => ['nullable', 'email', 'max:150'],
            ],
            [
                'url.required' => 'Silakan masukkan URL website yang ingin dilaporkan.',
                'url.url' => 'URL tidak valid. Gunakan alamat dengan http:// atau https://.',
                'url.max' => 'URL tidak boleh lebih dari 4000 karakter.',

                'category.required' => 'Silakan pilih kategori laporan.',
                'category.in' => 'Kategori laporan tidak valid.',

                'description.max' => 'Deskripsi tidak boleh lebih dari 2000 karakter.',

                'evidence.image' => 'Bukti pendukung harus berupa gambar.',
                'evidence.mimes' => 'Format gambar harus PNG, JPG, JPEG, atau WEBP.',
                'evidence.max' => 'Ukuran gambar maksimal 5 MB.',

                'reporter_name.max' => 'Nama tidak boleh lebih dari 100 karakter.',

                'reporter_email.email' => 'Format email tidak valid.',
                'reporter_email.max' => 'Email tidak boleh lebih dari 150 karakter.',
            ],
        );

        $uploadedEvidence = null;

        try {
            $url = $validated['url'];

            $parsedUrl = parse_url($url);

            if ($parsedUrl === false || empty($parsedUrl['scheme']) || empty($parsedUrl['host'])) {
                $this->addError('url', 'URL tidak valid. Periksa kembali alamat website.');

                return;
            }

            $scheme = strtolower($parsedUrl['scheme']);

            $host = strtolower($parsedUrl['host']);

            // Tambahkan tanda kurung untuk host IPv6.
            if (str_contains($host, ':') && !str_starts_with($host, '[')) {
                $host = '[' . $host . ']';
            }

            $domainUrl = $scheme . '://' . $host;

            // Pertahankan port jika tersedia.
            if (isset($parsedUrl['port'])) {
                $domainUrl .= ':' . $parsedUrl['port'];
            }

            /*
             * Simpan bukti pendukung.
             * File disimpan pada private local storage,
             * bukan public storage.
             */

            if ($this->evidence) {
                $uploadedEvidence = $this->evidence->store('url-reports/evidence', 'local');
            }

            DB::table('url_reports')->insert([
                'url' => $url,

                'domain_url' => $domainUrl,

                'category' => $validated['category'],

                'description' => $validated['description'] ?: null,

                'evidence' => $uploadedEvidence,

                'reporter_name' => $validated['reporter_name'] ?: null,

                'reporter_email' => $validated['reporter_email'] ?: null,

                'reporter_ip' => request()->ip(),

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            // Reset seluruh input formulir.
            $this->reset(['url', 'category', 'description', 'evidence', 'reporter_name', 'reporter_email']);

            $this->resetValidation();

            // Tampilkan pesan keberhasilan.
            $this->successMessage = 'Laporan berhasil dikirim. Terima kasih telah membantu menjaga keamanan pengguna internet bersama JagaKlik.';

            $this->dispatch('scroll-to-form');
        } catch (\Throwable $exception) {
            // Hapus file bukti jika penyimpanan database gagal.
            if ($uploadedEvidence) {
                Storage::disk('local')->delete($uploadedEvidence);
            }

            // Catat exception untuk kebutuhan debugging.
            report($exception);

            $this->addError('form', 'Terjadi kesalahan saat mengirim laporan. Silakan coba kembali.');

            $this->dispatch('scroll-to-form');
        }
    }
};
?>

<div class="min-h-screen bg-slate-50 px-4 py-12 dark:bg-[#0b1220] sm:px-6 lg:px-8">

    <div class="mx-auto max-w-3xl">


        {{-- Page Header --}}
        <div class="mb-8 text-center">
            <div
                class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                <i class="fa-solid fa-flag text-2xl"></i>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Laporkan URL Mencurigakan
            </h1>

            <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400 sm:text-base">
                Temukan website yang mencurigakan? Bantu lindungi pengguna internet lainnya dengan melaporkan URL
                tersebut kepada JagaKlik.
            </p>
        </div>

        {{-- Information Notice --}}
        <div
            class="mb-6 flex gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-500/20 dark:bg-blue-500/5">
            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                <i class="fa-solid fa-circle-info"></i>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300">
                    Mengapa perlu melaporkan URL?
                </h3>
                <p class="mt-1 text-sm leading-6 text-blue-800/80 dark:text-blue-300/70">
                    Laporan kamu dapat membantu meningkatkan kesadaran keamanan digital dan memberikan informasi
                    tambahan mengenai website yang berpotensi membahayakan pengguna.
                </p>
            </div>
        </div>

        {{-- Report Form --}}
        <div id="form-wrapper"
            class="scroll-mt-24 rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-[#101a2b]">

            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800 sm:px-8">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Formulir Pelaporan
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Lengkapi informasi berikut untuk mengirimkan laporan.
                </p>
            </div>

            <form wire:submit="submit" class="space-y-6 p-6 sm:p-8">

                {{-- Success Message --}}
                @if ($successMessage)
                <div class="flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-500/20 dark:bg-emerald-500/5"
                    role="status">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-emerald-900 dark:text-emerald-300">
                            Laporan Berhasil Dikirim
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-emerald-800/80 dark:text-emerald-300/70">
                            {{ $successMessage }}
                        </p>
                    </div>
                </div>
                @endif

                {{-- General Error Message --}}
                @error('form')
                <div class="flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-500/20 dark:bg-red-500/5"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-500"></i>

                    <p class="text-sm leading-6 text-red-700 dark:text-red-400">
                        {{ $message }}
                    </p>
                </div>
                @enderror

                {{-- URL --}}
                <div>
                    <label for="url" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        URL Website
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fa-solid fa-link"></i>
                        </div>

                        <input type="url" id="url" wire:model="url" placeholder="https://example.com"
                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:placeholder:text-slate-500">

                    </div>

                    @error('url')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        Masukkan alamat website lengkap yang ingin kamu laporkan.
                    </p>
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Kategori Laporan
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                        <select id="category" wire:model="category"
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-10 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white">
                            <option value="">-- Pilih Kategori --</option>
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

                    @error('category')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description"
                        class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Deskripsi
                        <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>

                    <textarea id="description" wire:model="description" rows="4"
                        placeholder="Jelaskan alasan kamu melaporkan website ini. Misalnya, website meminta informasi pribadi, menawarkan hadiah mencurigakan, atau mengarahkan ke halaman login palsu..."
                        class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:placeholder:text-slate-500"></textarea>

                    @error('description')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Evidence --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Bukti Pendukung
                        <span class="font-normal text-slate-400">(Opsional)</span>
                    </label>

                    <label for="evidence"
                        class="group flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50/50 dark:border-slate-700 dark:bg-[#0b1220] dark:hover:border-blue-500 dark:hover:bg-blue-500/5">
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 transition group-hover:scale-105 dark:bg-blue-500/10 dark:text-blue-400">
                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                        </div>

                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Klik untuk mengunggah bukti
                        </p>

                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            PNG, JPG, atau WEBP (Maks. 5 MB)
                        </p>

                        <input type="file" id="evidence" wire:model="evidence"
                            accept="image/png,image/jpeg,image/webp" class="hidden">
                    </label>

                    @error('evidence')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="evidence" class="mt-2 text-xs text-blue-600 dark:text-blue-400">
                        <i class="fa-solid fa-spinner fa-spin mr-1"></i>
                        Mengunggah file...
                    </div>

                    @if ($evidence)
                    <div
                        class="mt-3 flex items-center gap-3 rounded-xl border border-slate-200 p-3 dark:border-slate-700">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <i class="fa-solid fa-image"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">
                                {{ $evidence->getClientOriginalName() }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ number_format($evidence->getSize() / 1024, 0) }} KB
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-200 dark:border-slate-800"></div>

                {{-- Reporter Information --}}
                <div>
                    <div class="mb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            Informasi Pelapor
                        </h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Informasi ini bersifat opsional.
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">

                        {{-- Name --}}
                        <div>
                            <label for="reporter_name"
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Nama
                            </label>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </div>

                                <input type="text" id="reporter_name" wire:model="reporter_name"
                                    placeholder="Nama kamu"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:placeholder:text-slate-500">
                            </div>

                            @error('reporter_name')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="reporter_email"
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Email
                            </label>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>

                                <input type="email" id="reporter_email" wire:model="reporter_email"
                                    placeholder="nama@email.com"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-[#0b1220] dark:text-white dark:placeholder:text-slate-500">
                            </div>

                            @error('reporter_email')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Privacy Notice --}}
                <div class="flex gap-3 rounded-xl bg-slate-100 p-4 dark:bg-slate-800/50">
                    <i class="fa-solid fa-lock mt-0.5 text-slate-500 dark:text-slate-400"></i>
                    <p class="text-xs leading-5 text-slate-600 dark:text-slate-400">
                        Informasi pelapor hanya digunakan untuk keperluan pengelolaan laporan. Jangan menyertakan kata
                        sandi, kode OTP, atau informasi pribadi yang bersifat rahasia.
                    </p>
                </div>

                {{-- Submit --}}
                <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove wire:target="submit">
                        <i class="fa-solid fa-paper-plane mr-1"></i>
                        Kirim Laporan
                    </span>

                    <span wire:loading wire:target="submit">
                        <i class="fa-solid fa-spinner fa-spin mr-1"></i>
                        Mengirim Laporan...
                    </span>
                </button>

                <p class="text-center text-xs text-slate-500 dark:text-slate-400">
                    Terima kasih telah membantu menciptakan lingkungan digital yang lebih aman.
                </p>

            </form>
        </div>

        {{-- Bottom Information --}}
        <div class="mt-6 text-center">
            <a wire:navigate href="{{ route('guest.home.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke halaman utama
            </a>
        </div>

    </div>
</div>


@script
<script>
    $wire.on('scroll-to-form', () => {
        const formWrapper = document.getElementById('form-wrapper');

        if (formWrapper) {
            formWrapper.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
</script>
@endscript