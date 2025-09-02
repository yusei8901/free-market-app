@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="user-box">
    <div class="user-name__box">
        <div class="user-name__profile-image"></div>
        <p class="user-name">ユーザー名</p>
    </div>
    <a class="edit-link" href="/mypage-edit">プロフィールを編集</a>
</div>
<div class="lists">
    <a href="#" class="recommend">出品した商品</a>
    <a href="#" class="my-list">購入した商品</a>
</div>
<div class="product">
    <div class="product__card">
        <div class="product__box">
            <a href="" class="product__link">
                <img class="product__img" src="{{ asset('img/Leather+Shoes+Product+Photo.jpg') }}" alt="商品画像">
                <p class="product__name">商品名</p>
            </a>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <a href="" class="product__link">
                <img class="product__img" src="{{ asset('img/Living+Room+Laptop.jpg') }}" alt="商品画像">
                <p class="product__name">商品名</p>
            </a>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <a href="" class="product__link">
                <img class="product__img" src="{{ asset('img/Living+Room+Laptop.jpg') }}" alt="商品画像">
                <p class="product__name">商品名</p>
            </a>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <a href="" class="product__link">
                <img class="product__img" src="{{ asset('img/Living+Room+Laptop.jpg') }}" alt="商品画像">
                <p class="product__name">商品名</p>
            </a>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <a href="" class="product__link">
                <img class="product__img" src="{{ asset('img/Living+Room+Laptop.jpg') }}" alt="商品画像">
                <p class="product__name">商品名</p>
            </a>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <a href="" class="product__link">
                <img class="product__img" src="{{ asset('img/Living+Room+Laptop.jpg') }}" alt="商品画像">
                <p class="product__name">商品名</p>
            </a>
        </div>
    </div>
</div>
@endsection