@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="profile__box">
    <h2 class="profile__title">商品の出品</h2>
    <form class="profile__form" action="" method="post">
        @csrf
        <!-- 商品画像設定 -->
        <p>商品画像</p>
        <div class="image__box">
            <label class="product-img" for="img">画像を選択する</label>
            <input type="file" class="hidden" name="img" id="img">
        </div>

        <h3 class="sell__title">商品の詳細</h3>
        <!-- カテゴリー設定 -->
        <p>カテゴリー</p>
        <div class="category__box">
            <input type="checkbox" class="checkbox hidden" name="name" id="fashion">
            <label class="category-btn" for="fashion">ファッション</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="appliance">
            <label class="category-btn" for="appliance">家電</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="interior">
            <label class="category-btn" for="interior">インテリア</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="ladies">
            <label class="category-btn" for="ladies">レディース</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="men">
            <label class="category-btn" for="men">メンズ</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="cos">
            <label class="category-btn" for="cos">コスメ</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="book">
            <label class="category-btn" for="book">本</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="game">
            <label class="category-btn" for="game">ゲーム</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="sports">
            <label class="category-btn" for="sports">スポーツ</label>
            <input type="checkbox" class="checkbox hidden" name="name" id="kitchen">
            <label class="category-btn" for="kitchen">キッチン</label>

        </div>



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
        <div class="price__box">
            <i class="fa-sharp fa-solid fa-yen-sign price-icon" style="color: #000000;"></i>
            <input class="input-price" type="text" name="building_name">
        </div>

        <button class="profile__btn" type="submit">出品する</button>
    </form>
</div>

@endsection