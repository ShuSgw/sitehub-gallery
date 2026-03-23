<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ Vite::asset('resources/images/favicon.ico') }}">
    {{-- 各ページごとにタイトルを差し込むもし指定されなければ「sgwのアプリ」がデフォルトになる --}}
    <title>@yield('title', 'sgwのアプリ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 flex flex-col min-h-screen">

    <header class="bg-black py-5">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-lg font-semibold text-white">
                SGWのサイト置き場
            </h1>
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
