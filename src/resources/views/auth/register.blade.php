@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    @php
        $hideSection = true;
    @endphp
    <div class="register__box">
        <h2 class="register__title">会員登録</h2>
        <form class="register__form" action="/register" method="post">
            @csrf
            <div class="input-box">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
                <div class="register__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="input-box">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="name" value="{{ old('email') }}">
                <div class="register__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="input-box">
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password">
                <div class="register__error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="input-box">
                <label for="password_confirmation">確認用パスワード</label>
                <input type="password" name="password_confirmation" id="password_confirmation">
                <div class="register__error">
                    @error('password_confirmation')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <button class="register__btn" type="submit">登録する</button>
        </form>
        <div class="login__box">
            <a class="login__url" href="/login">ログインはこちら</a>
        </div>
    </div>
@endsection
