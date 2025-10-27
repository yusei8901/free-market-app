@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    @php
        $hideSection = true;
    @endphp
    <div class="login">
        <h2 class="login__title">ログイン</h2>
        <form class="login__form" action="/login" method="post">
            @csrf
            <div class="login__input-box">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                <div class="login__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="login__input-box">
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password">
                <div class="login__error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <button class="login__btn" type="submit">ログインする</button>
        </form>
        <div class="login__register-box">
            <a class="login__register-url" href="/register">会員登録はこちら</a>
        </div>
    </div>
@endsection
