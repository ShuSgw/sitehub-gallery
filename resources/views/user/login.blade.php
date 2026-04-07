{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'ホーム')

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    {{-- ここが実際にページごとに変わる部分 --}}
    <p class="text-center">ログイン</p>
    @php
        $inputClass = 'w-full border rounded px-3 py-2';
    @endphp

    <form method="POST" action="{{ route('login.store') }}" class="max-w-sm mx-auto mt-10 space-y-4">
        @csrf

        <input type="email" name="email" class="{{ $inputClass }}" placeholder="email">
        <input type="password" name="password" class="{{ $inputClass }}" placeholder="password">

        <button class="w-full bg-blue-500 text-white py-2 rounded">ログイン</button>
    </form>
@endsection
