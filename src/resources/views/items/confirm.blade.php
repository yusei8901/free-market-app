@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/confirm.css') }}">
@endsection

@section('content')
    <div class="confirm">
        <div class="confirm-box">
            <p class="confirm-box__item-name">商品名：{{ $item->name }}</p>
            <div class="confirm-box__img-box">
                <img class="confirm-box__img" src="{{ asset('storage/' . $item->item_image) }}" alt="">
            </div>
            <form class="confirm-box__form" action="{{ route('purchase.store', $item->id) }}" method="POST">
            @csrf
                <table>
                    <tbody>
                        <tr>
                            <th rowspan="2">配送先</th>
                            <td>〒<input type="text" value="{{ $requests['postal_code'] }}" name="postal_code" readonly></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="{{ $requests['address'] }}" name="address" readonly> 
                                <input type="text" value="{{ $requests['building'] }}" name="building" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>支払い方法</th>
                            <td><input type="text" value="{{ $requests['payment'] }}" name="payment" readonly></td>
                        </tr>
                        <tr>
                            <th>支払い金額</th>
                            <td>￥<input id="price" type="text" value="{{ number_format($requests['price']) }}" name="price" readonly>(税込)</td>
                        </tr>
                    </tbody>
                </table>
                <p>上記の内容で購入を確定させますか？</p>
                <button class="confirm-box__form-btn" type="submit">購入を確定する</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const priceInput = document.getElementById('price');
            priceInput.form.addEventListener('submit', function() {
                const rawValue = priceInput.value.replace(/,/g, '');
                priceInput.value = rawValue;
            });
        });
    </script>
@endsection
