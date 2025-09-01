@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="lists">
    <a href="#" class="recommend">おすすめ</a>
    <a href="#" class="my-list">マイリスト</a>
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