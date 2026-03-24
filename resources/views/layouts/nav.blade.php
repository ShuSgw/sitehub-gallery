@php
    $navItemStyle = 'text-gray-300 hover:text-white transition cursor-pointer whitespace-nowrap py-4';
    $badgeBase = 'text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap my-4';
@endphp

<nav class="flex gap-6 text-sm items-center overflow-x-auto">
    @if (auth()->check())
        <span class="{{ $badgeBase }} bg-blue-100 text-blue-800">ログイン中</span>
    @else
        <span class="{{ $badgeBase }} bg-red-100 text-red-800">ログアウト中</span>
    @endif
    <a href="{{ route('dashboard') }}" class="{{ $navItemStyle }}">
        <span>管理画面</span>
    </a>
    <a href="{{ route('register') }}" class="{{ $navItemStyle }}">
        <span>アカウント登録</span>
    </a>
    <a href="{{ route('login') }}" class="{{ $navItemStyle }}">
        <span>ログイン</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="{{ $navItemStyle }}">ログアウト</button>
    </form>
</nav>
