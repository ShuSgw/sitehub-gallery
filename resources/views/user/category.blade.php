{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'カテゴリ一覧')

@php
    $tableTh = 'border border-gray-300 px-4 py-2 text-left';
    $tableTd = 'border border-gray-300 px-4 py-2';
    $formClass = 'max-w-sm mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    <div class="flex items-center justify-between mb-15">
        <h2 class="text-3xl font-bold">カテゴリ一覧</h2>
        <a href="{{ route('sites.edit', $siteId) }}"
            class="group inline-flex items-center gap-1 py-1 px-5 bg-gray-100/50 border border-gray-200 rounded-2xl transition hover:bg-white hover:shadow-md active:scale-95">
            <x-heroicon-o-arrow-left class="size-4 transition group-hover:-translate-x-1" />サイト詳細に戻る</a>
    </div>
@endsection
