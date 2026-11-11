<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div class="flex gap-3 rounded-xl bg-blue-50 p-4 dark:bg-blue-400/10">
    <i class="fa-solid fa-circle-info mt-0.5 text-blue-500"></i>
    <p class="text-xs leading-6 text-blue-800 dark:text-blue-300">
        Hasil pemeriksaan berdasarkan database WebTrustScore, Google Safe Browsing, URLhaus, OpenPhish,
        ThreatFox, VirusTotal, AlienVault OTX, dan Phishunt. Setiap sumber memiliki cakupan dan metode
        deteksi yang berbeda. URL yang tidak ditemukan dalam database ancaman belum tentu
        sepenuhnya aman. Selalu berhati-hati sebelum mengunjungi tautan yang tidak dikenal.
    </p>
</div>
