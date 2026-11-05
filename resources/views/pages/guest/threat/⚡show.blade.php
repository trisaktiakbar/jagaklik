<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    public string $type;

    public array $threat = [];

    public function mount(string $type): void
    {
        $threats = [
            'phishing' => [
                'title' => 'Phishing',
                'subtitle' => 'Kenali dan hindari upaya pencurian informasi pribadi melalui situs atau tautan palsu.',
                'icon' => 'fa-user-secret',
                'color' => 'rose',
                'description' => 'Phishing merupakan bentuk kejahatan siber yang menggunakan situs web, email, pesan, atau tautan palsu untuk mengelabui korban agar memberikan informasi sensitif. Informasi tersebut dapat berupa kata sandi, kode OTP, data perbankan, hingga identitas pribadi.',
                'examples' => ['Situs login palsu yang menyerupai layanan perbankan.', 'Pesan yang mengatasnamakan perusahaan atau instansi resmi.', 'Tautan palsu untuk verifikasi akun atau pembaruan data.', 'Halaman hadiah atau undian yang meminta informasi pribadi.'],
                'indicators' => ['Alamat domain menyerupai situs resmi tetapi memiliki perbedaan karakter.', 'Meminta kata sandi, PIN, atau kode OTP secara tidak wajar.', 'Pesan menggunakan nada mendesak atau ancaman pemblokiran akun.', 'Tautan mengarah ke halaman login yang tidak dikenal.', 'Informasi pengirim atau identitas situs sulit diverifikasi.'],
                'prevention' => ['Periksa alamat URL sebelum memasukkan informasi pribadi.', 'Jangan pernah membagikan kata sandi, PIN, atau kode OTP.', 'Akses layanan melalui situs atau aplikasi resminya.', 'Hindari membuka tautan dari pengirim yang tidak dikenal.', 'Aktifkan autentikasi multifaktor pada akun penting.'],
            ],

            'malware' => [
                'title' => 'Malware',
                'subtitle' => 'Pahami ancaman perangkat lunak berbahaya yang dapat mengganggu sistem dan mencuri data.',
                'icon' => 'fa-bug',
                'color' => 'amber',
                'description' => 'Malware atau malicious software adalah perangkat lunak yang dirancang untuk melakukan aktivitas berbahaya pada perangkat atau sistem. Malware dapat digunakan untuk mencuri informasi, merusak file, memantau aktivitas, hingga mengambil alih kendali perangkat.',
                'examples' => ['Virus yang dapat menginfeksi dan merusak file.', 'Trojan yang menyamar sebagai aplikasi yang sah.', 'Ransomware yang mengenkripsi file dan meminta tebusan.', 'Spyware yang memantau aktivitas pengguna.', 'Keylogger yang merekam aktivitas pengetikan.'],
                'indicators' => ['Perangkat tiba-tiba menjadi lambat atau tidak responsif.', 'Muncul aplikasi atau proses yang tidak dikenal.', 'Terdapat aktivitas jaringan yang tidak biasa.', 'File berubah, hilang, atau tidak dapat diakses.', 'Muncul iklan atau jendela pop-up secara berlebihan.'],
                'prevention' => ['Unduh aplikasi hanya dari sumber yang tepercaya.', 'Gunakan antivirus dan lakukan pemindaian secara berkala.', 'Perbarui sistem operasi dan aplikasi secara rutin.', 'Hindari membuka lampiran yang mencurigakan.', 'Lakukan pencadangan data penting secara berkala.'],
            ],

            'scam' => [
                'title' => 'Scam & Penipuan',
                'subtitle' => 'Waspadai tautan dan situs yang digunakan untuk menjalankan berbagai modus penipuan digital.',
                'icon' => 'fa-money-bill-transfer',
                'color' => 'orange',
                'description' => 'Scam merupakan tindakan penipuan yang dilakukan dengan berbagai cara untuk memperoleh uang, data, atau keuntungan dari korban. Dalam aktivitas digital, pelaku sering memanfaatkan situs palsu, penawaran tidak masuk akal, dan manipulasi psikologis untuk meyakinkan korbannya.',
                'examples' => ['Penawaran hadiah atau undian fiktif.', 'Situs investasi dengan janji keuntungan tidak realistis.', 'Toko online palsu yang tidak mengirimkan barang.', 'Penipuan lowongan kerja yang meminta biaya pendaftaran.', 'Tautan pembayaran atau transaksi palsu.'],
                'indicators' => ['Menawarkan keuntungan besar dalam waktu singkat.', 'Meminta pembayaran sebelum layanan atau hadiah diberikan.', 'Tidak memiliki informasi bisnis yang dapat diverifikasi.', 'Menggunakan testimoni atau bukti transaksi yang meragukan.', 'Mendesak korban untuk segera melakukan pembayaran.'],
                'prevention' => ['Verifikasi identitas penjual atau penyedia layanan.', 'Periksa reputasi situs sebelum melakukan transaksi.', 'Jangan mudah percaya pada penawaran yang terlalu menggiurkan.', 'Gunakan metode pembayaran yang memiliki perlindungan konsumen.', 'Simpan bukti transaksi dan komunikasi.'],
            ],

            'suspicious-domain' => [
                'title' => 'Domain Mencurigakan',
                'subtitle' => 'Kenali karakteristik domain yang berpotensi digunakan untuk aktivitas berbahaya.',
                'icon' => 'fa-globe',
                'color' => 'violet',
                'description' => 'Domain mencurigakan adalah alamat situs yang memiliki karakteristik, pola, atau reputasi tertentu yang perlu diperiksa lebih lanjut. Domain semacam ini dapat digunakan untuk phishing, distribusi malware, penipuan, maupun aktivitas berbahaya lainnya.',
                'examples' => ['Domain yang meniru nama situs atau merek terkenal.', 'Domain dengan kombinasi karakter yang tidak lazim.', 'Domain yang baru dibuat dan digunakan untuk aktivitas mencurigakan.', 'Subdomain atau alamat URL yang mengarahkan ke halaman tidak dikenal.', 'Domain yang tercatat dalam database ancaman siber.'],
                'indicators' => ['Terdapat kesalahan ejaan atau tambahan karakter pada nama domain.', 'Menggunakan nama merek terkenal tanpa keterkaitan resmi.', 'Memiliki reputasi buruk pada layanan threat intelligence.', 'Menggunakan struktur URL yang tidak lazim.', 'Memiliki riwayat aktivitas phishing atau malware.'],
                'prevention' => ['Periksa nama domain secara teliti sebelum mengakses situs.', 'Pastikan domain sesuai dengan alamat resmi layanan.', 'Jangan mengabaikan peringatan keamanan browser.', 'Periksa reputasi domain menggunakan layanan pemeriksaan URL.', 'Hindari memasukkan informasi sensitif pada situs yang belum terverifikasi.'],
            ],
        ];

        abort_unless(isset($threats[$type]), 404);

        $this->type = $type;
        $this->threat = $threats[$type];
    }



    public function render()
    {
        $keywords = match ($this->type) {
            'phishing' => [
                'Phishing',
                'Pengertian Phishing',
                'Ciri-Ciri Phishing',
                'Cara Menghindari Phishing',
                'Link Phishing',
                'Website Palsu',
                'Pencurian Data',
                'Keamanan Digital',
                'JagaKlik',
            ],

            'malware' => [
                'Malware',
                'Pengertian Malware',
                'Jenis-Jenis Malware',
                'Virus Komputer',
                'Ransomware',
                'Spyware',
                'Trojan',
                'Deteksi Malware',
                'Keamanan Siber',
                'JagaKlik',
            ],

            'scam' => [
                'Scam',
                'Penipuan Online',
                'Modus Penipuan Online',
                'Ciri-Ciri Penipuan',
                'Situs Penipuan',
                'Link Penipuan',
                'Penipuan Digital',
                'Keamanan Transaksi Online',
                'JagaKlik',
            ],

            'suspicious-domain' => [
                'Domain Mencurigakan',
                'Domain Berbahaya',
                'Ciri-Ciri Domain Palsu',
                'Reputasi Domain',
                'Analisis Domain',
                'Deteksi Domain Phishing',
                'Website Berbahaya',
                'Pemeriksaan Keamanan URL',
                'Threat Intelligence',
                'JagaKlik',
            ],

            default => [
                'Threat Intelligence',
                'Ancaman Siber',
                'Keamanan Siber',
                'Keamanan Digital',
                'JagaKlik',
            ],
        };

        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => $this->threat['title'] ?? null,
                'description' => $this->threat['description'] ?? null,
                'keywords' => implode(', ', $keywords),
                'robots' => 'index, follow',
                'url' => route('guest.threat.show', $this->type),
            ],
        ]);
    }
};
?>

<div class="px-5 py-16 lg:px-8">
    <div class="mx-auto max-w-5xl">

        {{-- Header --}}
        <div class="text-center">
            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-{{ $threat['color'] }}-50 text-{{ $threat['color'] }}-600 dark:bg-{{ $threat['color'] }}-400/10 dark:text-{{ $threat['color'] }}-300">
                <i class="fa-solid {{ $threat['icon'] }} text-3xl"></i>
            </div>

            <p class="mt-6 text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                Threat Intelligence
            </p>

            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                {{ $threat['title'] }}
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-slate-500 dark:text-slate-400">
                {{ $threat['subtitle'] }}
            </p>
        </div>

        {{-- Description --}}
        <section
            class="mt-12 rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850 sm:p-8">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                Mengenal {{ $threat['title'] }}
            </h2>

            <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-400">
                {{ $threat['description'] }}
            </p>
        </section>

        {{-- Examples --}}
        <section class="mt-8">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                Contoh Ancaman
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Beberapa bentuk ancaman yang perlu kamu ketahui.
            </p>

            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                @foreach ($threat['examples'] as $example)
                <div
                    class="flex gap-3 rounded-xl border border-slate-200 bg-white p-5 dark:border-white/10 dark:bg-ink-850">
                    <i class="fa-solid fa-circle-exclamation mt-1 text-{{ $threat['color'] }}-500"></i>
                    <p class="text-sm leading-6 text-slate-600 dark:text-slate-400">
                        {{ $example }}
                    </p>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Indicators --}}
        <section class="mt-12">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                Ciri-Ciri yang Perlu Diwaspadai
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Perhatikan beberapa indikasi berikut untuk mengenali potensi ancaman.
            </p>

            <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850">
                <div class="space-y-5">
                    @foreach ($threat['indicators'] as $indicator)
                    <div class="flex gap-3">
                        <i class="fa-solid fa-triangle-exclamation mt-1 text-amber-500"></i>
                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-400">
                            {{ $indicator }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Prevention --}}
        <section class="mt-12">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                Cara Menghindarinya
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Terapkan langkah-langkah berikut untuk meningkatkan keamanan digital.
            </p>

            <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850">
                <div class="space-y-5">
                    @foreach ($threat['prevention'] as $step)
                    <div class="flex gap-3">
                        <i class="fa-solid fa-shield-halved mt-1 text-emerald-500"></i>
                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-400">
                            {{ $step }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="mt-12 rounded-2xl bg-blue-600 p-7 text-center sm:p-10">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-white">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>

            <h2 class="mt-5 text-2xl font-extrabold text-white">
                Periksa URL Sebelum Mengaksesnya
            </h2>

            <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-blue-100">
                Gunakan JagaKlik untuk membantu memeriksa reputasi URL dan mengidentifikasi potensi ancaman digital.
            </p>

            <a wire:navigate href="{{ route('guest.check-url.index') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-blue-700 transition hover:bg-blue-50">
                Periksa URL Sekarang
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </section>

    </div>
</div>