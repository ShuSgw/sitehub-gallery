{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'ホーム')

@php
    $tableTh = 'border border-gray-300 px-4 py-2 text-left';
    $tableTd = 'border border-gray-300 px-4 py-2';
    $formClass = 'max-w-sm mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
    $chip = 'px-3 py-1 rounded-full border transition';
    $chipOn = 'bg-cyan-500 border-cyan-500 text-white';
    $chipOff = 'border-gray-300 hover:bg-gray-100';

    $baseStyle = 'px-3 py-1 rounded-full border';
    $activeStyle = 'bg-black border-black text-white';
    $normalStyle = 'bg-white border-gray-300 text-gray-700 hover:bg-gray-100';
    $currentCategoryId = request('category');
@endphp

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    <h2 class="text-3xl font-bold mb-8">{{ $greeting }}、{{ $user->name }}さん</h2>
    <h3 class="text-lg font-bold mb-6">登録済みサイト</h3>

    <div class="flex flex-wrap gap-2 mb-4">
        @if ($currentCategoryId)
            <a href="{{ route('user.dashboard') }}" class="{{ $baseStyle }} {{ $normalStyle }}">すべて</a>
        @else
            <a href="{{ route('user.dashboard') }}" class="{{ $baseStyle }} {{ $activeStyle }}">すべて</a>
        @endif

        @foreach ($categories as $category)
            @if ($currentCategoryId == $category->id)
                <a href="{{ route('user.dashboard', ['category' => $category->id]) }}"
                    class="{{ $baseStyle }} {{ $activeStyle }}">{{ $category->name }}</a>
            @else
                <a href="{{ route('user.dashboard', ['category' => $category->id]) }}"
                    class="{{ $baseStyle }} {{ $normalStyle }}">{{ $category->name }}</a>
            @endif
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($sites as $site)
            <div class="flex flex-col rounded overflow-hidden shadow-lg bg-white">
                {{-- サムネイル（仮のプレースホルダー）クリックでサイトを開く --}}
                <div class="relative">
                    <a href="{{ $site->url }}" target="_blank" rel="noopener noreferrer" class="block">
                        <div
                            class="aspect-video bg-gray-200 flex items-center justify-center text-gray-400 overflow-hidden">
                            {{-- OGP画像があれば表示、なければプレースホルダー --}}
                            @if ($site->og_image_url)
                                <img src="{{ $site->og_image_url }}" alt="{{ $site->name }}" loading="lazy"
                                    class="w-full h-full object-cover">
                            @else
                                <x-heroicon-o-photo class="size-10" />
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-gray-900 opacity-25 transition duration-300 hover:opacity-10">
                        </div>
                    </a>
                    @if ($site->category)
                        <a href="{{ route('user.dashboard', ['category' => $site->category->id]) }}"
                            class="absolute bottom-0 left-0 bg-black px-3 py-1 text-white text-xs transition duration-500 ease-in-out hover:bg-white hover:text-black">
                            {{ $site->category->name }}
                        </a>
                    @endif
                </div>

                <div class="flex flex-col flex-1 px-6 py-4">
                    <a href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                        class="font-semibold text-lg truncate transition duration-500 ease-in-out hover:underline">{{ $site->name }}</a>
                    <p class="text-gray-500 text-sm mt-1 line-clamp-3 flex-1">{{ $site->memo }}</p>
                </div>
                <div class="px-6 py-4 flex justify-end gap-2">
                    <form action="{{ route('sites.destroy', $site->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button
                            class="cursor-pointer text-sm px-3 py-1 rounded border border-red-500 text-red-500 whitespace-nowrap transition hover:bg-red-500 hover:text-white active:scale-95">消去</button>
                    </form>
                    <a href="{{ route('sites.edit', $site->id) }}"
                        class="text-sm px-3 py-1 rounded border border-blue-500 text-blue-500 whitespace-nowrap transition hover:bg-blue-500 hover:text-white active:scale-95">編集</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 sm:col-span-2 md:col-span-3">登録されたサイトがありません</p>
        @endforelse
    </div>
    <form action="{{ route('sites.store') }}" method="POST" class="{{ $formClass }}">
        @csrf
        <input type="text" name="name" class="{{ $inputClass }}" placeholder="name">
        @error('name')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <input type="url" name="url" class="{{ $inputClass }}" placeholder="url">
        @error('url')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <button class="cursor-pointer w-full bg-red-500 text-white py-2 rounded">保存</button>
    </form>
@endsection
