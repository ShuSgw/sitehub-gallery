{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'サイト編集')

@php
    $formClass = 'max-w-sm mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp


@section('content')
    <div class="flex items-center justify-between mb-15">
        <h2 class="text-3xl font-bold">サイト詳細 編集</h2>
        <a href="{{ route('user.dashboard') }}"
            class="group inline-flex items-center gap-1 py-1 px-5 bg-gray-100/50 border border-gray-200 rounded-2xl transition hover:bg-white hover:shadow-md active:scale-95">
            <x-heroicon-o-arrow-left class="size-4 transition group-hover:-translate-x-1" />ダッシュボードに戻る</a>
    </div>
    <form action="{{ route('sites.update', $site->id) }}" method="POST" class="{{ $formClass }}">
        @csrf
        @method('PATCH')
        <div class="flex items-center gap-3">
            <label class="w-20 shrink-0 whitespace-nowrap" for="name">名前</label>
            <input type="text" name="name" class="{{ $inputClass }} flex-8" value="{{ old('name', $site->name) }}">
        </div>
        @error('name')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <div class="flex items-center gap-3">
            <label class="w-20 shrink-0 whitespace-nowrap" for="url">URL</label>
            <input type="url" name="url" class="{{ $inputClass }} flex-8" value="{{ old('url', $site->url) }}">
        </div>
        @error('url')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <div class="flex items-center gap-3">
            <label class="w-20 shrink-0 whitespace-nowrap" for="memo">メモ</label>
            <input type="text" name="memo" class="{{ $inputClass }} flex-8" value="{{ old('memo', $site->memo) }}">
        </div>
        @error('memo')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <div class="flex items-center gap-3">
            <label class="w-20 shrink-0 whitespace-nowrap" for="category_id">カテゴリ</label>
            @php
                // old(): バリデーションエラーで戻ってきたとき、直前に選んだ値（なければ第2引数を使う）
                // $site->category_id: 初めて開いたときの、DBに保存されている値
                $selectedId = old('category_id', $site->category_id);
            @endphp
            <select name="category_id" id="category_id" class="{{ $inputClass }} flex-1">
                <option value="" disabled @selected(!$selectedId)>未選択</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedId == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="text-right w-full">
            <a href="{{ route('categories.index', ['site' => $site->id]) }}"
                class="text-blue-500 underline hover:no-underline">カテゴリ追加</a>
        </div>
        <button class="w-full bg-cyan-500 text-white py-2 rounded">更新</button>
    </form>
@endsection
