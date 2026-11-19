{{-- layouts/app.blade.php を継承する --}}
@extends('layouts.app')

@section('title', 'メール認証')

@section('content')
    <h2 class="text-3xl font-bold mb-8">メールアドレスの確認</h2>

    <p>
        登録したメールアドレスに、確認用のリンクを送りました。<br>
        メール内のリンクをクリックして、登録を完了してください。
    </p>
@endsection
