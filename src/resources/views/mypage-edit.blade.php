@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage-edit.css') }}">
@endsection

@section('content')
<div class="profile__box">
    <h2 class="profile__title">プロフィール設定</h2>
    <form class="profile__form" action="" method="post">
        @csrf
        <div class="image__box">
            <div class="image">
                <!-- <img src="" alt="プロフィール画像"> -->
            </div>
            <label class="profile__image" for="image">画像を選択する</label>
            <input type="file" class="hidden" name="image" id="image">
        </div>

        <label for="name">ユーザー名</label>
        <input type="text" name="name" id="name">

        <label for="post_code">郵便番号</label>
        <input type="number" name="post_code" id="post_code">

        <label for="address">住所</label>
        <input type="text" name="address" id="address">

        <label for="building_name">建物名</label>
        <input type="text" name="building_name" id="building_name">

        <button class="profile__btn" type="submit">更新する</button>
    </form>
</div>

@endsection