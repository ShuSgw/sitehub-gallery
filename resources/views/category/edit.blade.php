{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'サイト編集')

@php
    $formClass = 'mt-5 space-y-4';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp


@section('content')
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold mb-8">カテゴリ編集</h2>
        <a href="{{ route('categories.index') }}"
            class="group inline-flex items-center gap-1 py-1 px-5 bg-gray-100/50 border border-gray-200 rounded-2xl transition hover:bg-white hover:shadow-md active:scale-95">
            <x-heroicon-o-arrow-left class="size-4 transition group-hover:-translate-x-1" />カテゴリリストに戻る</a>
    </div>
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="{{ $formClass }}">
        @csrf
        <table class="w-full border-collapse border border-gray-300 mt-5">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">カテゴリ名</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">
                        @method('PATCH')
                        <input type="text" name="name" class="{{ $inputClass }}" placeholder="カテゴリ名"
                            value="{{ $category->name }}">
                        @error('name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror

                    </td>
                </tr>
            </tbody>
        </table>
        <button class="w-full bg-blue-500 text-white py-2 rounded">更新</button>
    </form>

@endsection
