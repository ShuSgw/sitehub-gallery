{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

{{-- titleセクションに値を渡す（1行書き） --}}
@section('title', 'ホーム')

{{-- contentセクション（複数行なので endsection を使う） --}}
@section('content')
    {{-- ここが実際にページごとに変わる部分 --}}
    <p>ログインしました</p>
@endsection
