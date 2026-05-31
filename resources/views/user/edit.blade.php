{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'サイト編集')

@php
    $formClass = 'max-w-sm mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    <form action="{{ route('sites.update', $site->id) }}" method="POST" class="{{ $formClass }}">
        @csrf
        @method('PATCH')
        <div class="flex items-center gap-3">
            <label class="flex-1" for="name">名前</label>
            <input type="text" name="name" class="{{ $inputClass }} flex-8" value="{{ old('name', $site->name) }}">
        </div>
        @error('name')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <div class="flex items-center gap-3">
            <label class="flex-1" for="url">URL</label>
            <input type="url" name="url" class="{{ $inputClass }} flex-8" value="{{ old('url', $site->url) }}">
        </div>
        @error('url')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <button class="w-full bg-cyan-500 text-white py-2 rounded">更新</button>
    </form>
@endsection
