@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
    @php
        $hideSection = true;
    @endphp
    <div class="verify">
        <p class="verify__text">
            「認証を完了する」ボタンを押して<br>
            メール認証を完了してください。
        </p>
        <a href="{{ $verificationUrl }}" class="verify__button">認証を完了する</a>
    </div>
@endsection
