@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-left">
        <div class="product">
            <img class="product-img" src="{{ asset('img/Leather+Shoes+Product+Photo.jpg') }}" alt="商品画像">
            <div class="product-detail">
                <h2 class="product-name">商品名</h2>
                <p class="product-price">￥47,000</p>
            </div>
        </div>
        <div class="payment">
            <h3 class="section-title">支払い方法</h3>
            <div class="select-box">
                <select name="payment_method">
                    <option value="">選択してください</option>
                    <option value="convenience_store">コンビニ払い</option>
                    <option value="card">カード支払い</option>
                </select>
            </div>
        </div>
        <div class="shipping-address">
            <div class="shipping-address__top">
                <h3 class="section-title">配送先</h3>
                <a class="address-change" href="">変更する</a>
            </div>
            <div class="address-information">
                <p class="address-text">〒XXX-XXXX</p>
                <p class="address-text">ここには住所と建物が入ります</p>
            </div>
        </div>
    </div>
    <div class="content-right">
        <table>
            <tr>
                <th>商品代金</th>
                <td>￥47,000</td>
            </tr>
            <tr>
                <th>支払い方法</th>
                <td>コンビニ払い</td>
            </tr>
        </table>
        <button class="submit-btn" type="submit">購入する</button>
    </div>
</div>

@endsection