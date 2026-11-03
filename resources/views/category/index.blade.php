{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'カテゴリ一覧')

@php
    $tableTh = 'border border-gray-300 px-4 py-2 text-left';
    $tableTd = 'border border-gray-300 px-4 py-2';
    $formClass = 'mt-5 space-y-4 w-full';
    $inputClass = 'w-full border rounded px-3 py-2';
@endphp

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    <div class="flex items-center justify-between mb-15">
        <h2 class="text-3xl font-bold">カテゴリ一覧</h2>
        <div>
            <a href="{{ route('user.dashboard') }}"
                class="group inline-flex items-center gap-1 py-1 px-5 bg-gray-100/50 border border-gray-200 rounded-2xl transition hover:bg-white hover:shadow-md active:scale-95">
                <x-heroicon-o-arrow-left class="size-4 transition group-hover:-translate-x-1" />ダッシュボードに戻る</a>
        </div>
    </div>
    <div>
        <table class="border-collapse w-full border border-gray-300">
            <thead>
                <tr>
                    <th colspan="3" class="{{ $tableTh }}">カテゴリ名</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="{{ $tableTd }}">{{ $category->name }}</td>
                        <td class="{{ $tableTd }}">
                            <a href="{{ route('categories.edit', $category->id) }}"
                                class="text-blue-500 hover:text-blue-700">編集</a>

                        </td>
                        <td class="{{ $tableTd }}">
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="{{ $tableTd }} text-gray-500">カテゴリがありません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <form action="{{ route('categories.store') }}" method="POST" class="{{ $formClass }}">
            @csrf
            <div>
                <input type="text" name="name" id="name" class="{{ $inputClass }}" placeholder="カテゴリ名"
                    required>
                @error('name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror


                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition mt-5">追加</button>
            </div>
        </form>
    @endsection
