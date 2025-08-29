@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login__box">
        <h2>ログイン</h2>
        <form action="" method="post">
            @csrf
            <label for="mail">メールアドレス</label>
            <input type="mail" name="mail">
            <label for="password">パスワード</label>
            <input type="password" name="password">
            <button class="login__btn" type="submit">ログインする</button>
            <a href="#">会員登録はこちら</a>
        </form>
    </div>
@endsection