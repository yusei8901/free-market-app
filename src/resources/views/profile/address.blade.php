@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/address.css') }}">
@endsection

@section('content')
<div class="purchase-address">
    <h2 class="purchase-address__title">住所の変更</h2>
    <form class="purchase-address__form" action="{{ route('address.update', ['item_id' => $item_id]) }}" method="post">
        @csrf
        <input type="number" name="item_id" value="{{ $item_id }}" style="display: none;">
        <div class="purchase-address__input-box">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
        </div>
        <div class="purchase-address__register-error">
            @error('postal_code')
                {{$errors->first('postal_code')}}
            @enderror
        </div>
        <div class="purchase-address__input-box">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
        </div>
        <div class="purchase-address__register-error">
            @error('address')
                {{$errors->first('address')}}
            @enderror
        </div>
        <div class="purchase-address__input-box">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
        </div>
        <button class="purchase-address__btn" type="submit">更新する</button>
    </form>
</div>
@endsection