<?php

use Livewire\Component;

new class extends Component {
    public function render()
    {
        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Tentang Kami',
                'description' => 'Kenali JagaKlik, platform pemeriksaan keamanan URL yang membantu mengidentifikasi phishing, penipuan online, malware, dan berbagai ancaman digital melalui analisis dari berbagai sumber intelijen keamanan.',
                'keywords' => implode(', ', [
                    'Tentang Kami',
                    'About Us',
                    'Pemeriksaan Keamanan URL',
                    'Deteksi Phishing',
                    'Deteksi Malware',
                    'Keamanan Website',
                    'Cyber Security',
                    'Threat Intelligence',
                ]),
                'robots' => 'index, follow',
                'url' => route('guest.about.index'),
            ],
        ]);
    }
};
?>

<div>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden px-5 py-20 lg:px-8">
        <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl">
        </div>

        <div class="relative mx-auto max-w-7xl">
            <div class="mx-auto max-w-3xl text-center">

                <span
                    class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-bold text-blue-600 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="fa-solid fa-shield-halved"></i>
                    About JagaKlik
                </span>

                <h1
                    class="mt-7 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 dark:text-white sm:text-5xl lg:text-6xl">
                    Lebih Aman Menjelajahi Internet,
                    <span class="text-blue-600">Mulai dari Sini.</span>
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-slate-600 dark:text-slate-400 sm:text-base">
                    JagaKlik merupakan platform pemeriksaan keamanan URL yang membantu pengguna mengenali potensi
                    phishing, malware, penipuan online, dan berbagai ancaman digital melalui analisis dari sejumlah
                    sumber keamanan.
                </p>

                <div class="mt-9 flex flex-wrap items-center justify-center gap-3">

                    <a wire:navigate href="{{ route('guest.check-url.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Periksa URL Sekarang
                    </a>

                    <a wire:navigate href="{{ route('guest.url-scan-history.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:text-blue-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Aktivitas Pemindaian
                    </a>

                </div>
            </div>

            {{-- Hero Illustration --}}
            <div class="mx-auto mt-16 max-w-4xl">
                <div
                    class="relative overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-br from-blue-50 via-white to-cyan-50 p-8 dark:border-white/10 dark:from-blue-500/10 dark:via-ink-850 dark:to-cyan-500/10 sm:p-12">

                    <div class="mx-auto flex max-w-lg flex-col items-center text-center">

                        <div
                            class="relative flex h-28 w-28 items-center justify-center rounded-[2rem] bg-blue-600 text-white shadow-2xl shadow-blue-600/30">
                            <i class="fa-solid fa-shield-halved text-5xl"></i>

                            <span
                                class="absolute -right-2 -top-2 flex h-9 w-9 items-center justify-center rounded-full border-4 border-white bg-cyan-500 text-white dark:border-ink-850">
                                <i class="fa-solid fa-check text-sm"></i>
                            </span>
                        </div>

                        <h2 class="mt-7 text-xl font-extrabold text-slate-900 dark:text-white">
                            Your Digital Safety Matters
                        </h2>

                        <p class="mt-3 text-sm leading-7 text-slate-500 dark:text-slate-400">
                            Membantu pengguna mendapatkan informasi keamanan sebelum mengakses sebuah tautan.
                        </p>

                        <div class="mt-8 flex flex-wrap justify-center gap-2">
                            <span
                                class="rounded-full border border-blue-200 bg-white px-3 py-1.5 text-xs font-semibold text-blue-600 dark:border-blue-500/20 dark:bg-white/5 dark:text-blue-400">
                                URL Analysis
                            </span>
                            <span
                                class="rounded-full border border-cyan-200 bg-white px-3 py-1.5 text-xs font-semibold text-cyan-600 dark:border-cyan-500/20 dark:bg-white/5 dark:text-cyan-400">
                                Threat Intelligence
                            </span>
                            <span
                                class="rounded-full border border-violet-200 bg-white px-3 py-1.5 text-xs font-semibold text-violet-600 dark:border-violet-500/20 dark:bg-white/5 dark:text-violet-400">
                                Community Reports
                            </span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- About Section --}}
    <section
        class="border-y border-slate-200/80 bg-slate-50 px-5 py-20 dark:border-white/10 dark:bg-ink-850/50 lg:px-8">
        <div class="mx-auto grid max-w-7xl items-center gap-12 lg:grid-cols-2">

            <div>
                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    Who We Are
                </p>

                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Mengenal Lebih Dekat JagaKlik
                </h2>

                <p class="mt-5 text-sm leading-8 text-slate-600 dark:text-slate-400">
                    JagaKlik hadir sebagai platform pemeriksaan URL yang dirancang untuk membantu masyarakat
                    meningkatkan kewaspadaan terhadap berbagai ancaman di internet.
                </p>

                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-400">
                    Melalui integrasi dengan berbagai layanan keamanan dan threat intelligence, JagaKlik menganalisis
                    alamat URL untuk mencari indikasi aktivitas berbahaya, seperti phishing, malware, dan domain yang
                    telah dilaporkan.
                </p>

                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-400">
                    Hasil pemeriksaan disajikan dalam bentuk informasi yang mudah dipahami sehingga pengguna dapat
                    mempertimbangkan risiko sebelum mengunjungi sebuah website.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="fa-solid fa-link text-xl"></i>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900 dark:text-white">
                        URL Inspection
                    </h3>
                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">
                        Membantu memeriksa URL berdasarkan informasi dari berbagai sumber keamanan.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400">
                        <i class="fa-solid fa-shield-virus text-xl"></i>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900 dark:text-white">
                        Threat Detection
                    </h3>
                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">
                        Membantu mengidentifikasi indikasi phishing, malware, dan ancaman lainnya.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900 dark:text-white">
                        Community Reports
                    </h3>
                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">
                        Menampilkan informasi laporan URL dari komunitas sebagai referensi tambahan.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <i class="fa-solid fa-chart-simple text-xl"></i>
                    </div>
                    <h3 class="mt-5 font-bold text-slate-900 dark:text-white">
                        Scan History
                    </h3>
                    <p class="mt-2 text-xs leading-6 text-slate-500 dark:text-slate-400">
                        Menyediakan informasi aktivitas pemeriksaan URL yang telah dilakukan.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- Mission Section --}}
    <section class="px-5 py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    Our Purpose
                </p>

                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Tujuan dan Komitmen Kami
                </h2>

                <p class="mt-4 text-sm leading-7 text-slate-500 dark:text-slate-400">
                    Mendorong pengalaman digital yang lebih aman melalui informasi, teknologi, dan partisipasi
                    komunitas.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-7 transition hover:-translate-y-1 hover:shadow-soft dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="fa-solid fa-bullseye text-xl"></i>
                    </div>

                    <h3 class="mt-5 text-lg font-extrabold text-slate-900 dark:text-white">
                        Tujuan
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500 dark:text-slate-400">
                        Membantu pengguna mengenali potensi ancaman siber melalui pemeriksaan URL yang praktis dan
                        informatif.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-7 transition hover:-translate-y-1 hover:shadow-soft dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400">
                        <i class="fa-solid fa-eye text-xl"></i>
                    </div>

                    <h3 class="mt-5 text-lg font-extrabold text-slate-900 dark:text-white">
                        Kesadaran Digital
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500 dark:text-slate-400">
                        Meningkatkan kesadaran masyarakat mengenai phishing, malware, penipuan online, dan ancaman
                        digital lainnya.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-7 transition hover:-translate-y-1 hover:shadow-soft dark:border-white/10 dark:bg-ink-850">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                        <i class="fa-solid fa-handshake-angle text-xl"></i>
                    </div>

                    <h3 class="mt-5 text-lg font-extrabold text-slate-900 dark:text-white">
                        Kolaborasi
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500 dark:text-slate-400">
                        Menghadirkan informasi tambahan melalui integrasi sumber keamanan dan partisipasi komunitas.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- How It Works --}}
    <section
        class="border-y border-slate-200/80 bg-slate-50 px-5 py-20 dark:border-white/10 dark:bg-ink-850/50 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    How It Works
                </p>

                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Bagaimana JagaKlik Bekerja?
                </h2>

                <p class="mt-4 text-sm leading-7 text-slate-500 dark:text-slate-400">
                    Proses pemeriksaan URL dilakukan melalui beberapa tahapan untuk memberikan gambaran mengenai potensi
                    risiko sebuah tautan.
                </p>
            </div>

            <div class="relative mt-14 grid gap-8 md:grid-cols-3">

                <div
                    class="hidden absolute left-[20%] right-[20%] top-9 border-t border-dashed border-blue-300 dark:border-blue-500/30 md:block">
                </div>

                <div class="relative text-center">
                    <div
                        class="relative mx-auto flex h-18 w-18 items-center justify-center rounded-2xl border border-blue-200 bg-white text-blue-600 shadow-sm dark:border-blue-500/20 dark:bg-ink-850">
                        <i class="fa-solid fa-link text-2xl"></i>
                        <span
                            class="absolute -right-2 -top-2 flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">1</span>
                    </div>

                    <h3 class="mt-6 font-extrabold text-slate-900 dark:text-white">
                        Masukkan URL
                    </h3>

                    <p class="mx-auto mt-2 max-w-xs text-sm leading-7 text-slate-500 dark:text-slate-400">
                        Masukkan alamat website yang ingin diperiksa melalui halaman pemeriksaan JagaKlik.
                    </p>
                </div>

                <div class="relative text-center">
                    <div
                        class="relative mx-auto flex h-18 w-18 items-center justify-center rounded-2xl border border-blue-200 bg-white text-blue-600 shadow-sm dark:border-blue-500/20 dark:bg-ink-850">
                        <i class="fa-solid fa-magnifying-glass-chart text-2xl"></i>
                        <span
                            class="absolute -right-2 -top-2 flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">2</span>
                    </div>

                    <h3 class="mt-6 font-extrabold text-slate-900 dark:text-white">
                        Analisis Keamanan
                    </h3>

                    <p class="mx-auto mt-2 max-w-xs text-sm leading-7 text-slate-500 dark:text-slate-400">
                        URL dianalisis menggunakan berbagai layanan keamanan dan sumber threat intelligence.
                    </p>
                </div>

                <div class="relative text-center">
                    <div
                        class="relative mx-auto flex h-18 w-18 items-center justify-center rounded-2xl border border-blue-200 bg-white text-blue-600 shadow-sm dark:border-blue-500/20 dark:bg-ink-850">
                        <i class="fa-solid fa-file-shield text-2xl"></i>
                        <span
                            class="absolute -right-2 -top-2 flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">3</span>
                    </div>

                    <h3 class="mt-6 font-extrabold text-slate-900 dark:text-white">
                        Lihat Hasil
                    </h3>

                    <p class="mx-auto mt-2 max-w-xs text-sm leading-7 text-slate-500 dark:text-slate-400">
                        Pengguna mendapatkan ringkasan hasil pemeriksaan dan informasi mengenai potensi ancaman.
                    </p>
                </div>

            </div>
        </div>
    </section>


    {{-- Intelligence Sources --}}
    <section class="px-5 py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">
                    Security Intelligence
                </p>

                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Didukung Berbagai Sumber Keamanan
                </h2>

                <p class="mt-4 text-sm leading-7 text-slate-500 dark:text-slate-400">
                    JagaKlik mengintegrasikan beberapa layanan keamanan untuk memperoleh informasi dan indikasi ancaman
                    dari berbagai sumber.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-8">

                @foreach ([['name' => 'WebTrustScore', 'icon' => 'fa-solid fa-chart-line'], ['name' => 'Google Safe Browsing', 'icon' => 'fa-brands fa-google'], ['name' => 'URLhaus', 'icon' => 'fa-solid fa-database'], ['name' => 'OpenPhish', 'icon' => 'fa-solid fa-fish'], ['name' => 'ThreatFox', 'icon' => 'fa-solid fa-bug'], ['name' => 'VirusTotal', 'icon' => 'fa-solid fa-shield-virus'], ['name' => 'AlienVault OTX', 'icon' => 'fa-solid fa-globe'], ['name' => 'Phishunt', 'icon' => 'fa-solid fa-magnifying-glass-chart']] as $source)
                <div
                    class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white p-5 text-center dark:border-white/10 dark:bg-ink-850">
                    <i class="{{ $source['icon'] }} text-2xl text-blue-600 dark:text-blue-400"></i>
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">
                        {{ $source['name'] }}
                    </span>
                </div>
                @endforeach

            </div>

            <p class="mt-5 text-center text-xs leading-6 text-slate-500 dark:text-slate-400">
                JagaKlik juga menggunakan IP-API untuk memperoleh informasi lokasi dan jaringan server website yang
                diperiksa.
            </p>

        </div>
    </section>


    {{-- Disclaimer --}}
    <section class="px-5 pb-20 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div
                class="flex flex-col gap-5 rounded-2xl border border-amber-200 bg-amber-50 p-6 dark:border-amber-500/20 dark:bg-amber-500/5 sm:flex-row sm:items-start sm:p-8">

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                    <i class="fa-solid fa-circle-info text-xl"></i>
                </div>

                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white">
                        Informasi Penting
                    </h3>

                    <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-400">
                        Hasil pemeriksaan JagaKlik merupakan informasi pendukung berdasarkan data yang tersedia dari
                        sumber keamanan yang terintegrasi. Hasil yang menunjukkan tidak adanya deteksi bukan merupakan
                        jaminan bahwa sebuah website sepenuhnya aman. Selalu berhati-hati saat mengakses website dan
                        jangan membagikan informasi sensitif kepada pihak yang tidak dapat dipercaya.
                    </p>
                </div>

            </div>

        </div>
    </section>


    {{-- CTA --}}
    <section class="px-5 pb-20 lg:px-8">
        <div
            class="relative mx-auto max-w-7xl overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-blue-700 px-7 py-14 text-center shadow-xl shadow-blue-600/15 sm:px-12">

            <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute -bottom-32 -left-20 h-64 w-64 rounded-full bg-cyan-400/20 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-2xl">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 text-white">
                    <i class="fa-solid fa-shield-halved text-2xl"></i>
                </div>

                <h2 class="mt-6 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Lindungi Aktivitas Digitalmu Mulai Sekarang
                </h2>

                <p class="mt-4 text-sm leading-7 text-blue-100">
                    Jangan langsung percaya pada setiap tautan yang kamu temukan di internet. Periksa terlebih dahulu
                    menggunakan JagaKlik.
                </p>

                <a wire:navigate href="{{ route('guest.check-url.index') }}"
                    class="mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-blue-700 transition hover:bg-blue-50">
                    Mulai Periksa URL
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>
        </div>
    </section>

</div>