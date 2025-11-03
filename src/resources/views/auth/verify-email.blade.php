@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
    @php
        $hideSection = true;
    @endphp
    @if(session('message'))
        <div class="verify__success">
            {{ session('message') }}
        </div>
    @endif

    <div class="verify">
        <p class="verify__text">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>
        <a href="{{ route('verification.confirm') }}" class="verify__button">認証はこちらから</a>
        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button class="verify__mail-again" type="submit">認証メールを再送する</button>
        </form>

    </div>
@endsection
