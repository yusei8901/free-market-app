@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="profile__box">
    <h2 class="profile__title">商品の出品</h2>
    <form class="profile__form" action="" method="post">
        @csrf
        <label for="img">商品画像</label>
        <input type="image" name="img">
        <div><a href="#">画像を選択する</a></div>

        <h3 class="sell__title">商品の詳細</h3>
        <div>カテゴリー</div>
        <label class="category-btn">
            <input class="hidden" type="checkbox" name="name">
            <span>ファッション</span>
        </label>
        <label class="category-btn">
            <input class="hidden" type="checkbox" name="name">
            <span>家電</span>
        </label>
        <label class="category-btn">
            <input class="hidden" type="checkbox" name="name">
            <span>インテリア</span>
        </label>
        <label class="category-btn">
            <input class="hidden" type="checkbox" name="name">
            <span>レディース</span>
        </label>
        <div></div>


        <label for="name">商品の状態</label>
        <select name="condition">
            <option value="">選択してください</option>
            <option value="">良好</option>
            <option value="">目立った傷や汚れなし</option>
            <option value="">やや傷や汚れあり</option>
            <option value="">状態が悪い</option>
        </select>

        <h3 class="sell__title">商品名と説明</h3>
        <label for="name">商品名</label>
        <input type="text" name="name">
        <label for="post_code">ブランド名</label>
        <input type="number" name="post_code">
        <label for="explanation">商品の説明</label>
        <textarea name="explanation" id="explanation"></textarea>
        <label for="building_name">販売価格</label>
        <input type="text" name="building_name">
        <button class="profile__btn" type="submit">出品する</button>
    </form>
</div>

@endsection