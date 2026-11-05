<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b1220">

    <x-guest.seo-meta-component :title="$meta['title'] ?? null" :description="$meta['description'] ?? null" :author="$meta['author'] ?? null" :keywords="$meta['keywords'] ?? null"
        :image="$meta['image'] ?? null" :url="$meta['url'] ?? null" :robots="$meta['robots'] ?? null" />

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/guest/img/favicon.png') }}">

    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#2563eb">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="JagaKlik">
    <link rel="apple-touch-icon" href="{{ asset('assets/guest/img/pwa-192x192.png') }}">


    <script>
        document.addEventListener('livewire:navigated', function() {
            const saved = localStorage.getItem('jagaklik-theme');

            if (saved === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body
    class="bg-slate-50 text-slate-900 antialiased selection:bg-blue-200 selection:text-blue-950 dark:bg-ink-900 dark:text-slate-100 dark:selection:bg-blue-500/30 dark:selection:text-white">


    <!-- Background decoration -->



    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">

        <div class="absolute -top-72 left-1/2 h-[620px] w-[900px] -translate-x-1/2 rounded-full hero-orb blur-3xl">

        </div>

        <div class="absolute inset-0 grid-pattern"></div>

    </div>

    <livewire:guest.navbar />


    <main>


        {{ $slot }}


    </main>

    <!-- Footer -->
    <livewire:guest.footer />


    @livewireScripts
</body>

</html>
