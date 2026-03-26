{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'ホーム')

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    {{-- ここが実際にページごとに変わる部分 --}}
    <p>アドミンがログインしました。</p>
    <p>これはアドミンの管理画面です。</p>

    <table class="min-w-full border border-gray-300 mt-5">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">名前</th>
                <th class="border px-4 py-2">メール</th>
                <th class="border px-4 py-2">作成日</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="even:bg-gray-50">
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ $user->created_at->format('Y年m月d日 H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
