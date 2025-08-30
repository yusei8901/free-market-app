@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__box">
    <h2 class="register__title">会員登録</h2>
    <form class="register__form" action="" method="post">
        @csrf
        <label for="name">ユーザー名</label>
        <input type="text" name="name">
        <label for="email">メールアドレス</label>
        <input type="email" name="email">
        <label for="password">パスワード</label>
        <input type="password" name="password">
        <label for="password_confirmation">確認用パスワード</label>
        <input type="password" name="password_confirmation">
        <button class="register__btn" type="submit">登録する</button>
    </form>
    <div class="login__box">
        <a class="login__url" href="#">ログインはこちら</a>
    </div>
</div>


@endsection