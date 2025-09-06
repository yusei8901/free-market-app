@extends('layouts.header-part')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase-address.css') }}">
@endsection

@section('content')
<div class="purchase-address__box">
    <h2 class="purchase-address__title">住所の変更</h2>
    <form class="purchase-address__form" action="" method="post">
        @csrf
        <label for="post_code">郵便番号</label>
        <input type="number" name="post_code" id="post_code">
        <label for="address">住所</label>
        <input type="text" name="address" id="address">
        <label for="building_name">建物名</label>
        <input type="text" name="building_name" id="building_name">
        <button class="purchase-address__btn" type="submit">更新する</button>
    </form>
</div>
@endsection