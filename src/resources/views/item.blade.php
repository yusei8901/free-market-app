@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="item-wrapper">
    <div class="item-left">
        <div class="item-left__img-box">
            <img src="{{ asset('img/Leather+Shoes+Product+Photo.jpg') }}" alt="商品画像">
        </div>
    </div>

    <div class="item-right">
        <div class="item-right__product">
            <h2 class="product-title">商品名がここに入る</h2>
            <p class="brand-name">ブランド名</p>
            <p class="price">￥47,000(税込)</p>
            <div class="actions">
                <div class="favorite">
                    <i class="fa-regular fa-star fa-2x"></i>
                    <p class="action-number">3</p>
                </div>
                <div class="comment">
                    <i class="fa-regular fa-comment fa-2x"></i>
                    <p class="action-number">1</p>
                </div>
            </div>
            <a class="purchase-link" href="#">購入手続きへ</a>
        </div>

        <div class="item-right__explanation">
            <h3 class="section-title">商品説明</h3>
            <p>カラー：グレー</p>
            <div class="condition">
                <p class="no-margin-bottom">新品</p>
                <p class="no-margin-top">商品の状態は良好です。傷もありません。</p>
            </div>
            <p>購入後、即発送いたします。</p>
        </div>
        <div class="item-right__information">
            <h3 class="section-title">商品の情報</h3>
            <table>
                <tr>
                    <th>カテゴリー</th>
                    <td><span class="category">洋服</span></td>
                    <td><span class="category">メンズ</span></td>
                </tr>
                <tr>
                    <th>商品の状態</th>
                    <td>良好</td>
                </tr>
            </table>
        </div>
        <div class="item-right__comments">
            <h3 class="comment-title">コメント（１）</h3>
            <div class="comment-view">
                <div class="user">
                    <img class="icon" src="{{ asset('img/Leather+Shoes+Product+Photo.jpg') }}" alt="アイコン画像">
                    <p class="user-name">admin</p>
                </div>
                <div class="comment-content">
                    <p>こちらにコメントが入ります。</p>
                </div>
            </div>
            <form action="" method="post">
                @csrf
                <label for="comment">商品へのコメント</label>
                <textarea name="comment" id="comment"></textarea>
                <button class="submit-btn" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>

@endsection