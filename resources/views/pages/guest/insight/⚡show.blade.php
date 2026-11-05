<?php

use Livewire\Component;

new class extends Component {
    public string $slug = '';

    public array $article = [];

    public function mount(string $slug): void
    {
        $articles = [
            'phishing-detection' => [
                'category' => 'Phishing Detection',
                'title' => 'Cara Mengenali Tautan Phishing dan Situs Palsu',
                'description' => 'Kenali karakteristik tautan phishing yang digunakan untuk mencuri kredensial, informasi pribadi, dan data penting lainnya.',
                'image' => 'assets/guest/img/cyber-security-insight/1.jpg',
                'read_time' => '5 menit membaca',
                'sections' => [
                    [
                        'heading' => 'Apa Itu Phishing?',
                        'paragraphs' => ['Phishing merupakan salah satu bentuk kejahatan siber yang dilakukan dengan cara menyamar sebagai pihak atau layanan terpercaya untuk mengelabui korban.', 'Pelaku biasanya menggunakan tautan atau website palsu yang menyerupai layanan asli. Korban kemudian diarahkan untuk memasukkan informasi sensitif seperti username, password, kode OTP, atau data pribadi lainnya.', 'Serangan phishing sering disebarkan melalui email, pesan instan, media sosial, maupun SMS.'],
                    ],
                    [
                        'heading' => 'Ciri-Ciri Tautan Phishing',
                        'paragraphs' => ['Tautan phishing terkadang terlihat meyakinkan. Namun, terdapat beberapa karakteristik yang dapat menjadi indikasi bahwa sebuah URL patut dicurigai.'],
                        'points' => [
                            [
                                'title' => 'Nama domain menyerupai website asli',
                                'description' => 'Pelaku menggunakan nama domain yang mirip dengan layanan resmi, tetapi memiliki perbedaan karakter atau ejaan.',
                            ],
                            [
                                'title' => 'Menggunakan alamat URL yang tidak wajar',
                                'description' => 'URL memiliki kombinasi karakter, subdomain, atau struktur alamat yang tidak biasa.',
                            ],
                            [
                                'title' => 'Meminta informasi sensitif',
                                'description' => 'Website meminta password, PIN, kode OTP, atau informasi pribadi tanpa alasan yang jelas.',
                            ],
                            [
                                'title' => 'Menggunakan pesan yang mendesak',
                                'description' => 'Pesan mengancam pemblokiran akun, kehilangan akses, atau menawarkan hadiah agar korban segera membuka tautan.',
                            ],
                            [
                                'title' => 'Tidak memiliki reputasi yang jelas',
                                'description' => 'Domain baru atau tidak dikenal dapat menjadi alasan untuk melakukan pemeriksaan lebih lanjut.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Cara Menghindari Serangan Phishing',
                        'paragraphs' => ['Meningkatkan kewaspadaan sebelum membuka tautan merupakan salah satu langkah penting untuk mengurangi risiko serangan phishing.'],
                        'points' => [
                            [
                                'title' => 'Periksa alamat URL',
                                'description' => 'Pastikan nama domain sesuai dengan website resmi yang ingin dikunjungi.',
                            ],
                            [
                                'title' => 'Jangan sembarangan memasukkan data',
                                'description' => 'Hindari memasukkan password, PIN, dan kode OTP pada website yang belum dipastikan keasliannya.',
                            ],
                            [
                                'title' => 'Hindari tautan mencurigakan',
                                'description' => 'Jangan langsung membuka tautan dari pesan atau sumber yang tidak dikenal.',
                            ],
                            [
                                'title' => 'Gunakan pemeriksaan keamanan URL',
                                'description' => 'Manfaatkan layanan pemeriksaan URL untuk membantu mengidentifikasi indikasi phishing dan ancaman lainnya.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Kesimpulan',
                        'paragraphs' => ['Phishing dapat menyerang siapa saja melalui tautan yang terlihat seperti website terpercaya. Oleh karena itu, selalu periksa alamat URL dan jangan mudah percaya terhadap pesan yang meminta informasi sensitif.', 'Kewaspadaan dan kebiasaan memeriksa tautan sebelum mengaksesnya dapat membantu melindungi aktivitas digital dari berbagai ancaman.'],
                    ],
                ],
            ],

            'url-reputation' => [
                'category' => 'URL Reputation',
                'title' => 'Mengapa Reputasi URL Penting Sebelum Mengakses Website?',
                'description' => 'Pahami bagaimana reputasi URL membantu mengidentifikasi website yang berpotensi berbahaya sebelum kamu mengaksesnya.',
                'image' => 'assets/guest/img/cyber-security-insight/2.jpg',
                'read_time' => '5 menit membaca',
                'sections' => [
                    [
                        'heading' => 'Apa Itu URL Reputation?',
                        'paragraphs' => ['URL Reputation merupakan penilaian terhadap tingkat kepercayaan atau risiko suatu alamat website berdasarkan informasi dan riwayat keamanan yang tersedia.', 'Sebuah URL dapat memiliki reputasi baik, mencurigakan, atau berbahaya berdasarkan laporan, aktivitas, dan hasil analisis dari berbagai sumber keamanan.', 'Informasi reputasi ini dapat membantu pengguna mempertimbangkan risiko sebelum membuka sebuah website.'],
                    ],
                    [
                        'heading' => 'Mengapa Reputasi URL Penting?',
                        'paragraphs' => ['Tidak semua website yang terlihat profesional dan menggunakan HTTPS dapat dipastikan aman. Website berbahaya juga dapat menggunakan tampilan yang meyakinkan serta sertifikat HTTPS.'],
                        'points' => [
                            [
                                'title' => 'Mengenali website berbahaya',
                                'description' => 'Reputasi URL membantu menemukan indikasi website yang pernah dikaitkan dengan phishing, malware, atau aktivitas mencurigakan.',
                            ],
                            [
                                'title' => 'Mengurangi risiko pencurian data',
                                'description' => 'Pemeriksaan sebelum mengakses website dapat membantu pengguna menghindari halaman yang berpotensi mencuri informasi pribadi.',
                            ],
                            [
                                'title' => 'Memanfaatkan informasi keamanan',
                                'description' => 'Data dari berbagai sumber threat intelligence dapat memberikan gambaran tambahan mengenai reputasi sebuah URL.',
                            ],
                            [
                                'title' => 'Meningkatkan kewaspadaan digital',
                                'description' => 'Pengguna dapat mengambil keputusan yang lebih berhati-hati sebelum berinteraksi dengan sebuah website.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Bagaimana Reputasi URL Diperiksa?',
                        'paragraphs' => ['Pemeriksaan reputasi URL dapat dilakukan dengan membandingkan alamat website terhadap database dan sumber informasi keamanan yang mengumpulkan indikator ancaman.'],
                        'points' => [
                            [
                                'title' => 'Pemeriksaan database keamanan',
                                'description' => 'URL diperiksa terhadap database yang berisi daftar website berbahaya atau URL yang telah dilaporkan.',
                            ],
                            [
                                'title' => 'Analisis threat intelligence',
                                'description' => 'Informasi dari sumber threat intelligence digunakan untuk mengetahui apakah URL berkaitan dengan aktivitas berbahaya.',
                            ],
                            [
                                'title' => 'Analisis laporan komunitas',
                                'description' => 'Laporan dari pengguna atau komunitas dapat menjadi informasi tambahan dalam menilai sebuah URL.',
                            ],
                            [
                                'title' => 'Evaluasi hasil pemeriksaan',
                                'description' => 'Hasil dari berbagai sumber dianalisis untuk memberikan gambaran mengenai tingkat risiko URL.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Apakah Website dengan HTTPS Selalu Aman?',
                        'paragraphs' => ['Tidak. HTTPS menunjukkan bahwa koneksi antara browser dan website menggunakan enkripsi. Namun, HTTPS tidak menjamin bahwa website tersebut bebas dari phishing, malware, atau aktivitas penipuan.', 'Karena itu, pengguna tetap perlu memperhatikan reputasi domain dan melakukan pemeriksaan keamanan sebelum memasukkan informasi sensitif.'],
                    ],
                    [
                        'heading' => 'Kesimpulan',
                        'paragraphs' => ['Reputasi URL merupakan salah satu informasi penting untuk membantu mengenali risiko sebuah website. Dengan melakukan pemeriksaan sebelum mengakses tautan, pengguna dapat meningkatkan kewaspadaan terhadap berbagai ancaman siber.'],
                    ],
                ],
            ],

            'threat-intelligence' => [
                'category' => 'Threat Intelligence',
                'title' => 'Mengenal Berbagai Ancaman Siber di Internet',
                'description' => 'Pelajari berbagai jenis ancaman siber seperti phishing, malware, scam, dan domain mencurigakan yang dapat membahayakan aktivitas digital.',
                'image' => 'assets/guest/img/cyber-security-insight/3.jpg',
                'read_time' => '6 menit membaca',
                'sections' => [
                    [
                        'heading' => 'Apa Itu Ancaman Siber?',
                        'paragraphs' => ['Ancaman siber merupakan berbagai aktivitas atau tindakan yang dapat membahayakan sistem, jaringan, perangkat, maupun informasi digital.', 'Ancaman tersebut dapat dilakukan melalui website, email, aplikasi, file, atau berbagai saluran komunikasi digital lainnya.', 'Memahami jenis ancaman siber merupakan langkah awal untuk meningkatkan keamanan saat menggunakan internet.'],
                    ],
                    [
                        'heading' => 'Jenis-Jenis Ancaman Siber',
                        'paragraphs' => ['Terdapat berbagai jenis ancaman yang perlu diketahui oleh pengguna internet. Beberapa di antaranya dapat ditemukan melalui tautan atau website yang tidak aman.'],
                        'points' => [
                            [
                                'title' => 'Phishing',
                                'description' => 'Teknik penipuan yang menggunakan website atau pesan palsu untuk memperoleh informasi sensitif seperti password dan kode OTP.',
                            ],
                            [
                                'title' => 'Malware',
                                'description' => 'Perangkat lunak berbahaya yang dirancang untuk merusak sistem, mencuri data, atau menjalankan aktivitas tanpa izin pengguna.',
                            ],
                            [
                                'title' => 'Scam dan Penipuan Online',
                                'description' => 'Berbagai bentuk penipuan digital yang bertujuan mendapatkan uang, informasi pribadi, atau keuntungan dari korban.',
                            ],
                            [
                                'title' => 'Suspicious Domain',
                                'description' => 'Domain yang memiliki karakteristik atau aktivitas mencurigakan sehingga perlu diperiksa lebih lanjut sebelum diakses.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Apa Itu Threat Intelligence?',
                        'paragraphs' => ['Threat Intelligence merupakan informasi yang dikumpulkan, dianalisis, dan digunakan untuk memahami berbagai ancaman siber.', 'Informasi tersebut dapat berasal dari database keamanan, laporan insiden, aktivitas malware, indikator kompromi, dan sumber informasi keamanan lainnya.', 'Threat intelligence membantu mengidentifikasi pola ancaman serta memberikan informasi yang dapat digunakan untuk meningkatkan perlindungan digital.'],
                    ],
                    [
                        'heading' => 'Bagaimana Threat Intelligence Membantu Pengguna?',
                        'paragraphs' => ['Informasi threat intelligence dapat dimanfaatkan untuk memberikan gambaran mengenai potensi risiko dari sebuah URL atau domain.'],
                        'points' => [
                            [
                                'title' => 'Identifikasi ancaman',
                                'description' => 'Membantu menemukan URL, domain, atau indikator lain yang berkaitan dengan aktivitas berbahaya.',
                            ],
                            [
                                'title' => 'Pengumpulan informasi',
                                'description' => 'Menggabungkan informasi dari berbagai sumber keamanan untuk memperoleh gambaran ancaman yang lebih luas.',
                            ],
                            [
                                'title' => 'Analisis risiko',
                                'description' => 'Membantu memahami jenis ancaman dan potensi dampaknya terhadap pengguna.',
                            ],
                            [
                                'title' => 'Peningkatan kewaspadaan',
                                'description' => 'Memberikan informasi yang dapat digunakan pengguna untuk mengambil keputusan lebih aman saat beraktivitas di internet.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Cara Melindungi Diri dari Ancaman Siber',
                        'paragraphs' => ['Setiap pengguna internet perlu menerapkan kebiasaan keamanan digital untuk mengurangi risiko menjadi korban serangan siber.'],
                        'points' => [
                            [
                                'title' => 'Periksa tautan sebelum dibuka',
                                'description' => 'Pastikan URL berasal dari sumber terpercaya dan tidak memiliki karakteristik mencurigakan.',
                            ],
                            [
                                'title' => 'Gunakan password yang kuat',
                                'description' => 'Buat password yang unik untuk setiap akun dan aktifkan autentikasi multifaktor jika tersedia.',
                            ],
                            [
                                'title' => 'Perbarui perangkat dan aplikasi',
                                'description' => 'Gunakan sistem operasi dan aplikasi versi terbaru untuk memperoleh perbaikan keamanan.',
                            ],
                            [
                                'title' => 'Jangan mudah percaya',
                                'description' => 'Waspadai pesan, penawaran, dan permintaan informasi yang tidak dapat diverifikasi.',
                            ],
                        ],
                    ],
                    [
                        'heading' => 'Kesimpulan',
                        'paragraphs' => ['Ancaman siber memiliki berbagai bentuk dan dapat menyerang pengguna melalui banyak saluran digital. Memahami jenis ancaman serta memanfaatkan informasi keamanan dapat membantu meningkatkan perlindungan saat menggunakan internet.'],
                    ],
                ],
            ],
        ];

        abort_unless(isset($articles[$slug]), 404);

        $this->slug = $slug;
        $this->article = $articles[$slug];
    }

    public function render()
    {
        $keywords = match ($this->slug) {
            'phishing-detection' => [
                'Phishing Detection',
                'Cara Mengenali Phishing',
                'Ciri-Ciri Link Phishing',
                'Deteksi Phishing',
                'Tautan Phishing',
                'Website Palsu',
                'Link Penipuan',
                'Keamanan Digital',
                'JagaKlik',
            ],

            'url-reputation' => [
                'URL Reputation',
                'Reputasi URL',
                'Reputasi Website',
                'Pemeriksaan Keamanan URL',
                'Analisis URL',
                'Keamanan Website',
                'Cek Keamanan Website',
                'Website Berbahaya',
                'JagaKlik',
            ],

            'threat-intelligence' => [
                'Threat Intelligence',
                'Ancaman Siber',
                'Jenis-Jenis Ancaman Siber',
                'Cyber Security',
                'Phishing',
                'Malware',
                'Scam Online',
                'Keamanan Siber',
                'Indikator Ancaman',
                'JagaKlik',
            ],

            default => [
                'Cyber Security',
                'Keamanan Digital',
                'JagaKlik',
            ],
        };

        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => $this->article['title'] ?? null,
                'image' => $this->article['image'] ? asset($this->article['image']) : null,
                'description' => $this->article['description'],
                'keywords' => implode(', ', $keywords),
                'robots' => 'index, follow',
                'url' => route('guest.insight.show', $this->slug),
            ],
        ]);
    }
};
?>

<div>
    <article class="px-5 py-16 lg:px-8">
        <div class="mx-auto max-w-4xl">

            {{-- Article Header --}}
            <header class="mb-8">
                <span
                    class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    {{ $article['category'] }}
                </span>

                <h1
                    class="mt-5 text-3xl font-extrabold leading-tight tracking-tight text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                    {{ $article['title'] }}
                </h1>

                <p class="mt-5 text-base leading-8 text-slate-500 dark:text-slate-400">
                    {{ $article['description'] }}
                </p>

                <div class="mt-6 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                    <i class="fa-regular fa-clock"></i>
                    <span>{{ $article['read_time'] }}</span>
                    <span class="mx-1">•</span>
                    <span>JagaKlik Cyber Security Insights</span>
                </div>
            </header>

            {{-- Featured Image --}}
            <div class="mb-10 overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10">
                <img src="{{ asset($article['image']) }}" alt="{{ $article['title'] }}"
                    class="aspect-video w-full object-cover">
            </div>

            {{-- Article Content --}}
            <div class="space-y-10">

                @foreach ($article['sections'] as $section)
                <section>
                    <h2
                        class="mb-4 text-xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                        {{ $section['heading'] }}
                    </h2>

                    @foreach ($section['paragraphs'] ?? [] as $paragraph)
                    <p class="mb-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                        {{ $paragraph }}
                    </p>
                    @endforeach

                    @if (!empty($section['points']))
                    <div class="mt-5 space-y-4">
                        @foreach ($section['points'] as $point)
                        <div
                            class="flex gap-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-white/10 dark:bg-ink-850">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $point['title'] }}
                                </h3>

                                <p class="mt-1 text-sm leading-7 text-slate-500 dark:text-slate-400">
                                    {{ $point['description'] }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </section>
                @endforeach

            </div>

            {{-- CTA --}}
            <div
                class="mt-14 rounded-2xl border border-blue-100 bg-blue-50 p-7 dark:border-blue-500/20 dark:bg-blue-500/5 sm:p-9">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>

                <h2 class="mt-5 text-xl font-extrabold text-slate-900 dark:text-white">
                    Periksa Keamanan URL Sebelum Mengaksesnya
                </h2>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-400">
                    Jangan mengambil risiko dengan tautan yang belum dikenal. Gunakan JagaKlik untuk membantu memeriksa
                    indikasi ancaman dan reputasi sebuah URL.
                </p>

                <a wire:navigate href="{{ route('guest.check-url.index') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                    Periksa URL Sekarang
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

        </div>
    </article>
</div>