<?php

use Livewire\Component;

new class extends Component {
    public function render()
    {
        return $this->view()->layout('layouts::guest.app', [
            'meta' => [
                'description' => 'JagaKlik membantu Anda memeriksa keamanan URL dan mengidentifikasi potensi phishing, penipuan online, malware, serta ancaman digital melalui analisis dari berbagai sumber intelijen keamanan.',
                'keywords' => implode(', ', [
                    'Cek Keamanan URL',
                    'Periksa URL',
                    'Deteksi Phishing',
                    'Cek Link Penipuan',
                    'Deteksi Malware',
                    'URL Scanner',
                    'Website Security Checker',
                    'Analisis Keamanan Website',
                    'Cyber Security',
                    'Threat Intelligence',
                    'Keamanan Digital',
                ]),
                'robots' => 'index, follow',
                'url' => route('guest.home.index'),
            ],
        ]);
    }
};

?>


<div>
    <livewire:guest.hero-section />
    <livewire:guest.url-scanner-section />
    <livewire:guest.threat-statistic-section />

    <livewire:guest.threat-category-section />

    <livewire:guest.how-it-work-section />
    <livewire:guest.cyber-security-insight-section />

    <livewire:guest.report-suspicious-url-section />
</div>