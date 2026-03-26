@php
    $itemBase = 'h-12.5 flex items-center justify-center text-center hover:bg-gray-900 hover:text-gray-300 text-sm';
    $listBase = 'divide-y divide-gray-700';

@endphp

<nav class="hidden peer-checked:block lg:block fixed inset-y-0 right-0 bg-black w-45 text-white z-40">

    <!-- バッジ行 -->
    <li class="h-16 flex items-center justify-center  border-gray-700">
        @if (auth()->guard('admin')->check())
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                Adminログイン中
            </span>
        @elseif (auth()->check())
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                Userログイン中
            </span>
        @else
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                ログアウト中
            </span>
        @endif
    </li>

    <!-- メニュー -->
    <ul class="{{ $listBase }}">
        <li>
            <a href="{{ route('user.dashboard') }}" class="{{ $itemBase }}">
                User管理画面
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ $itemBase }}">
                Admin管理画面
            </a>
        </li>
        <li>
            <a href="{{ route('register') }}" class="{{ $itemBase }}">
                アカウント登録
            </a>
        </li>
        <li>
            <a href="{{ route('admin.register') }}" class="{{ $itemBase }}">
                アドミン登録
            </a>
        </li>
        <li>
            <a href="{{ route('login') }}" class="{{ $itemBase }}">
                ユーザーログイン
            </a>
        </li>
        <li>
            <a href="{{ route('admin.login') }}" class="{{ $itemBase }}">
                アドミンログイン
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="{{ $itemBase }} w-full">
                    ログアウト
                </button>
            </form>
        </li>
    </ul>
</nav>

{{-- <nav class="flex gap-6 text-sm items-center overflow-x-auto">
    @if (auth()->guard('admin')->check())
        <span class="{{ $badgeBase }} bg-purple-100 text-purple-800">Adminログイン中</span>
    @elseif (auth()->check())
        <span class="{{ $badgeBase }} bg-blue-100 text-blue-800">Userログイン中</span>
    @else
        <span class="{{ $badgeBase }} bg-red-100 text-red-800">ログアウト中</span>
    @endif
    <a href="{{ route('user.dashboard') }}" class="{{ $navItemStyle }}">
        <span>User管理画面</span>
    </a>
    <a href="{{ route('admin.dashboard') }}" class="{{ $navItemStyle }}">
        <span>Admin管理画面</span>
    </a>
    <a href="{{ route('register') }}" class="{{ $navItemStyle }}">
        <span>アカウント登録</span>
    </a>
    <a href="{{ route('admin.register') }}" class="{{ $navItemStyle }}">
        <span>アドミン登録</span>
    </a>
    <a href="{{ route('login') }}" class="{{ $navItemStyle }}">
        <span>ユーザーログイン</span>
    </a>
    <a href="{{ route('admin.login') }}" class="{{ $navItemStyle }}">
        <span>アドミンログイン</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="{{ $navItemStyle }}">ログアウト</button>
    </form>

</nav> --}}
