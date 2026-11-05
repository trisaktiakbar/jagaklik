<?php

use Livewire\Attributes\Modelable;
use Livewire\Component;

new class extends Component {

    #[Modelable]
    public $url = '';
};
?>

<div x-show="mode === 'qr'" x-cloak>

    <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">
        Unggah Gambar QR Code
    </label>

    <input id="qr-image" type="file" accept="image/png,image/jpeg,image/webp" class="hidden"
        @change="decodeFile($event)" />

    <label for="qr-image"
        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center transition hover:border-blue-400 hover:bg-blue-50/50 dark:border-slate-600 dark:bg-[#0b1220] dark:hover:border-blue-400 dark:hover:bg-blue-400/5">

        <div
            class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">

            <i class="fa-solid fa-qrcode text-2xl"></i>

        </div>

        <p class="text-sm font-semibold text-slate-800 dark:text-white">
            Klik untuk memilih gambar QR Code
        </p>

        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
            atau pilih gambar dari perangkat kamu
        </p>

        <span
            class="mt-4 rounded-full bg-white px-3 py-1.5 text-xs font-medium text-slate-500 shadow-sm dark:bg-[#101a2b] dark:text-slate-400">
            PNG, JPG, JPEG, WEBP · Maksimal 5 MB
        </span>

    </label>

    <div x-show="previewUrl" x-cloak
        class="mt-5 overflow-hidden rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-[#0b1220]">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

            <div
                class="flex h-32 w-full shrink-0 items-center justify-center overflow-hidden rounded-lg bg-slate-100 sm:w-32 dark:bg-[#101a2b]">

                <img :src="previewUrl" alt="Preview QR Code" class="h-full w-full object-contain" />

            </div>

            <div class="min-w-0 flex-1">

                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Gambar yang dipilih
                </p>

                <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-white" x-text="fileName"></p>

                <div class="mt-3 flex flex-wrap items-center gap-2">

                    <span x-show="decoding"
                        class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 dark:bg-blue-400/10 dark:text-blue-400">

                        <i class="fa-solid fa-spinner fa-spin"></i>
                        Membaca QR Code...

                    </span>

                    <span x-show="decodedUrl && !decoding"
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-400">

                        <i class="fa-solid fa-circle-check"></i>
                        QR Code Berhasil Dibaca

                    </span>

                    <button type="button" @click="clearFile()"
                        class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-400/10">

                        <i class="fa-solid fa-trash-can"></i>
                        Hapus Gambar

                    </button>

                </div>

            </div>

        </div>

        <div x-show="decodedUrl && !decoding" x-cloak class="mt-4 rounded-lg bg-emerald-50 p-3 dark:bg-emerald-400/10">

            <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                URL Berhasil Diekstrak
            </p>

            <p class="mt-1 break-all text-sm text-emerald-800 dark:text-emerald-300" x-text="decodedUrl"></p>

        </div>

    </div>

    <div x-show="errorMessage" x-cloak
        class="mt-4 flex gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 dark:border-rose-400/20 dark:bg-rose-400/10">

        <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500"></i>

        <p class="text-sm leading-6 text-rose-700 dark:text-rose-300" x-text="errorMessage"></p>

    </div>

    <p class="mt-3 text-xs leading-5 text-slate-500 dark:text-slate-400">
        <i class="fa-solid fa-shield-halved mr-1 text-emerald-500"></i>
        QR Code hanya dibaca untuk mengambil URL. JagaKlik tidak akan membuka tautan secara
        otomatis.
    </p>

</div>