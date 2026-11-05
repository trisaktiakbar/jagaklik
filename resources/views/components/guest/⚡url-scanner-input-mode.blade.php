<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div class="mb-6 flex rounded-xl bg-slate-100 p-1 dark:bg-[#0b1220]">

    <button type="button" @click="switchMode('url')"
        :class="mode === 'url'
            ?
            'bg-white text-blue-600 shadow-sm dark:bg-[#1c2a40] dark:text-blue-400' :
            'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white'"
        class="flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-semibold transition">

        <i class="fa-solid fa-link"></i>
        URL Website

    </button>

    <button type="button" @click="switchMode('qr')"
        :class="mode === 'qr'
            ?
            'bg-white text-blue-600 shadow-sm dark:bg-[#1c2a40] dark:text-blue-400' :
            'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white'"
        class="flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-semibold transition">

        <i class="fa-solid fa-qrcode"></i>
        QR Code

    </button>

</div>
