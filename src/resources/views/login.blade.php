@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__box">
    <h2 class="login__title">ログイン</h2>
    <form class="login__form" action="" method="post">
        @csrf
        <label for="email">メールアドレス</label>
        <input type="email" name="email">
        <label for="password">パスワード</label>
        <input type="password" name="password">
        <button class="login__btn" type="submit">ログインする</button>
    </form>
    <div class="register__box">
        <a class="register__url" href="#">会員登録はこちら</a>
    </div>
</div>


@endsection