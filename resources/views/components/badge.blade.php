<!-- バッジ行 -->
<li class="h-16 flex items-center justify-center border-gray-700">
    @if (auth()->guard('admin')->check() && auth()->check())
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
            両方ログイン中
        </span>
    @elseif (auth()->guard('admin')->check())
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
            アドミンログイン中
        </span>
    @elseif (auth()->check())
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
            ユーザーログイン中
        </span>
    @else
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
            ログアウト中
        </span>
    @endif
</li>
