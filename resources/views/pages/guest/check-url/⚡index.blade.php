<?php

use Livewire\Component;

new class extends Component {
    public function render()
    {
        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'title' => 'Periksa URL',
                'description' => 'Periksa keamanan URL menggunakan JagaKlik dan identifikasi potensi phishing, penipuan online, malware, dan ancaman digital melalui analisis dari berbagai sumber intelijen keamanan.',
                'keywords' => implode(', ', [
                    'Periksa URL',
                    'Cek Keamanan URL',
                    'Pemeriksaan URL',
                    'Cek Link Phishing',
                    'Deteksi Phishing',
                    'Deteksi Malware',
                    'Cek Link Penipuan',
                    'Analisis URL',
                    'Keamanan Website',
                    'URL Scanner',
                    'Website Security Checker',
                    'Threat Intelligence',
                ]),
                'robots' => 'index, follow',
                'url' => route('guest.check-url.index'),
            ],
        ]);
    }
};
?>

<div>
    <livewire:guest.url-scanner-section />
</div>