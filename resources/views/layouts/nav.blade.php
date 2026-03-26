@php
    $itemBase =
        'cursor-pointer h-12.5 flex items-center justify-center text-center hover:text-gray-300 text-sm transition-colors duration-200';
    $userItem = $itemBase . ' bg-blue-900 hover:bg-blue-800';
    $adminItem = $itemBase . ' bg-red-900 hover:bg-red-800';
    $defaultItem = $itemBase . ' hover:bg-gray-900';
    $listBase = 'divide-y divide-gray-700';

@endphp

<nav class="hidden peer-checked:block lg:block fixed inset-y-0 right-0 bg-black w-45 text-white z-40">
    @include('components.badge')
    <!-- メニュー -->
    <ul class="{{ $listBase }}">
        <li>
            <a href="{{ route('admin.register') }}" class="{{ $adminItem }}">
                アドミン登録
            </a>
        </li>
        <li>
            <a href="{{ route('admin.login') }}" class="{{ $adminItem }}">
                アドミンログイン
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ $adminItem }}">
                アドミン管理画面
            </a>
        </li>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="{{ $adminItem }} w-full">
                アドミンログアウト
            </button>
        </form>
        <li>
            <a href="{{ route('register') }}" class="{{ $userItem }}">
                ユーザーアカウント登録
            </a>
        </li>
        <li>
            <a href="{{ route('login') }}" class="{{ $userItem }}">
                ユーザーログイン
            </a>
        </li>
        <li>
            <a href="{{ route('user.dashboard') }}" class="{{ $userItem }}">
                ユーザー管理画面
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="{{ $userItem }} w-full">
                    ユーザーログアウト
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
