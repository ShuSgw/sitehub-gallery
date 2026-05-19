<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ Vite::asset('resources/images/favicon.ico') }}">
    {{-- 各ページごとにタイトルを差し込むもし指定されなければ「sgwのアプリ」がデフォルトになる --}}
    <title>@yield('title', 'sgwのアプリ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 flex flex-col min-h-screen" x-data="{ open: false }">
    <header class="bg-black py-5">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-lg font-semibold text-white">
                <a href="{{ route('home') }}" class="hover:underline whitespace-nowrap mr-">
                    サイト置き場
                </a>
            </h1>
            <div class="relative">
                @php
                    $iconPosition = 'fixed top-4.5 right-4 md:right-10 lg:right-69';
                    $iconStyle =
                        'size-8 z-10 text-white cursor-pointer hover:text-gray-300 hover:scale-110 transition-all duration-200';
                @endphp
                <x-heroicon-o-bars-3 class="{{ $iconPosition }} {{ $iconStyle }}" @click="open = true"
                    click="open = true" />

                @include('layouts.nav')
            </div>
        </div>
    </header>
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/40 z-40" @click="open = false"></div>

    <main class="flex-1 max-w-4xl mx-auto px-4 py-12 w-full text-black">
        {{-- 各ページのメインコンテンツがここに入る --}}
        @yield('content')
    </main>

    <footer class="bg-black text-center py-6 w-full">
        <p class="text-sm text-white">© 2026</p>
    </footer>

</body>

</html>
