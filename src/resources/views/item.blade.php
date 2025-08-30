@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="item-wrapper">
    <div class="item__left">
        <div class="product__img">
            <p>商品画像</p>
        </div>
    </div>
    <div class="item__right">
        <h2>商品名がここに入る</h2>
    </div>
</div>

@endsection