{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'ホーム')

@php
    $formClass = 'max-w-sm mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    <div class="mt-8">
        <h2 class="text-3xl font-bold mb-8">{{ $greeting }}、{{ $user->name }}さん</h2>
        <h3 class="text-lg font-bold mb-6">登録済みサイト</h3>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">URL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sites as $site)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $site->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                                class="text-blue-500 underline hover:no-underline">{{ $site->url }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border border-gray-300 px-4 py-2 text-gray-500">登録されたサイトがありません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <form action="{{ route('sites.store') }}" method="POST" class="{{ $formClass }}">
        @csrf
        <input type="text" name="name" class="{{ $inputClass }}" placeholder="name">
        @error('name')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <input type="url" name="url" class="{{ $inputClass }}" placeholder="url">
        @error('url')
        @enderror
        <button class="w-full bg-red-500 text-white py-2 rounded">
            保存
        </button>
    </form>
@endsection
