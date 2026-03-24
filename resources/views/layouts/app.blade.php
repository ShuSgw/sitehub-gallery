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

<body class="bg-slate-50 flex flex-col min-h-screen">

    <header class="bg-black py-5">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <h1 class="text-lg font-semibold text-white">
                    <a href="{{ route('home') }}" class="hover:underline">
                        サイト置き場
                    </a>
                </h1>
                @include('layouts.nav')
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-4xl mx-auto px-4 py-12 w-full">
        {{-- 各ページのメインコンテンツがここに入る --}}
        @yield('content')
    </main>

    <footer class="bg-black text-center py-6 w-full">
        <p class="text-sm text-white">© 2026</p>
    </footer>

</body>

</html>
