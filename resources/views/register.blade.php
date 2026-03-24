{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'ホーム')


@php
    $formClass = 'max-w-sm mx-auto mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    {{-- ここが実際にページごとに変わる部分 --}}
    <p class="text-center">登録ページです</p>
    <form method="POST" action="{{ route('register') }}" class="{{ $formClass }}">
        @csrf
        <input type="text" name="name" class="{{ $inputClass }}" placeholder="name">
        <input type="email" name="email" class="{{ $inputClass }}" placeholder="email">
        <input type="password" name="password" class="{{ $inputClass }}" placeholder="password">
        <button class="w-full bg-green-500 text-white py-2 rounded">登録</button>
    </form>
@endsection
