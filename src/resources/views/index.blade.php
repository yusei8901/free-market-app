@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="lists">
    <a href="#">おすすめ</a>
    <a href="#">マイリスト</a>
</div>
<div class="product">
    <div class="product__card">
        <div class="product__box">
            <div class="product__img">
                <p class="product__img-name">商品画像</p>
            </div>
            <p class="product__name">商品名</p>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <div class="product__img">
                <p class="product__img-name">商品画像</p>
            </div>
            <p class="product__name">商品名</p>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <div class="product__img">
                <p class="product__img-name">商品画像</p>
            </div>
            <p class="product__name">商品名</p>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <div class="product__img">
                <p class="product__img-name">商品画像</p>
            </div>
            <p class="product__name">商品名</p>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <div class="product__img">
                <p class="product__img-name">商品画像</p>
            </div>
            <p class="product__name">商品名</p>
        </div>
    </div>
    <div class="product__card">
        <div class="product__box">
            <div class="product__img">
                <p class="product__img-name">商品画像</p>
            </div>
            <p class="product__name">商品名</p>
        </div>
    </div>
</div>
@endsection