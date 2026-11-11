<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component {
    #[Reactive]
    public $statusConfig;

    #[Reactive]
    public $scannedUrl;

    #[Reactive]
    public $successfulSources;

    #[Reactive]
    public $analyzedSources;
};
?>

<div class="rounded-2xl border p-5 sm:p-6 {{ $statusConfig['classes'] }}">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl {{ $statusConfig['iconClasses'] }}">
            <i class="fa-solid {{ $statusConfig['icon'] }} text-2xl"></i>
        </div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <h3 class="text-lg font-bold {{ $statusConfig['titleClasses'] }}">
                    {{ $statusConfig['title'] }}
                </h3>
                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusConfig['badgeClasses'] }}">
                    {{ $statusConfig['badge'] }}
                </span>
            </div>

            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                {{ $statusConfig['description'] }}
            </p>

            <div
                class="mt-4 break-all rounded-lg bg-white/70 px-4 py-3 text-sm text-slate-700 dark:bg-black/10 dark:text-slate-300">
                <i class="fa-solid fa-link mr-2 text-slate-400"></i>
                {{ $scannedUrl }}
            </div>

            <div class="mt-3 space-y-1 text-xs text-slate-500 dark:text-slate-400">
                <p>
                    <i class="fa-solid fa-database mr-1"></i>
                    {{ $this->successfulSources }} dari 6 API berhasil merespons.
                </p>

                <p>
                    <i class="fa-solid fa-chart-simple mr-1"></i>
                    {{ $this->analyzedSources }} dari 6 sumber memberikan hasil analisis.
                </p>
            </div>

        </div>

    </div>

</div>
