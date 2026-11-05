<?php

use Livewire\Attributes\Modelable;
use Livewire\Component;

new class extends Component {
    #[Modelable]
    public $url = '';
};
?>

<div x-show="mode === 'url'" x-cloak>

    <label for="scanner-url" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">
        URL Website
    </label>

    <div class="relative">

        <i class="fa-solid fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

        <input id="scanner-url" type="url" wire:model.trim="url" wire:loading.attr="readonly" wire:target="scan"
            placeholder="https://example.com" autocomplete="url"
            class="w-full rounded-xl border border-slate-300 bg-white py-4 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-[#0b1220] dark:text-white dark:placeholder:text-slate-500" />

    </div>

    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
        <i class="fa-solid fa-circle-info mr-1"></i>
        Masukkan URL lengkap dengan http:// atau https://
    </p>

</div>