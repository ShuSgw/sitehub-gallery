@php
    $styles = [
        'login' => 'bg-blue-100 text-blue-800',
        'logout' => 'bg-red-100 text-red-800',
    ];
    $style = $styles[$type] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="text-xs font-medium px-2 py-1 rounded-full {{ $style }}">
    {{ $slot }}
</span>
