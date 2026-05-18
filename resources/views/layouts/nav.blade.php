@php
    $itemBase =
        'cursor-pointer h-12.5 flex items-center justify-center text-center hover:text-gray-300 text-sm transition-colors duration-200';
    $userItem = $itemBase . ' bg-blue-900 hover:bg-blue-800';
    $adminItem = $itemBase . ' bg-red-900 hover:bg-red-800';
    $defaultItem = $itemBase . ' hover:bg-gray-900';
    $listBase = 'divide-y divide-gray-700';

@endphp
<nav class="hidden peer-checked:block lg:block lg:my-1 fixed inset-y-1 right-0 bg-black w-45 text-white z-40">
    @include('components.badge')
    <!-- メニュー -->
    <ul class="{{ $listBase }}">
        {{-- <li>
            <a href="{{ route('admin.register') }}" class="{{ $adminItem }}">
                アドミン登録
            </a>
        </li> --}}
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
            <a href="{{ route('register.form') }}" class="{{ $userItem }}">
                ユーザーアカウント登録
            </a>
        </li>
        <li>
            <a href="{{ route('user.login') }}" class="{{ $userItem }}">
                ユーザーログイン
            </a>
        </li>
        <li>
            <a href="{{ route('user.dashboard') }}" class="{{ $userItem }}">
                ユーザー管理画面
            </a>
        </li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="{{ $userItem }} w-full">
                ユーザーログアウト
            </button>
        </form>
    </ul>
</nav>
