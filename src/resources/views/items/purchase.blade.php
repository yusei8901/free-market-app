@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase">
        <div class="purchase-left">
            <div class="purchase-left__item">
                <img class="purchase-left__item-img" src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                <div class="purchase-left__item-detail">
                    <h2 class="purchase-left__item-name">{{ $item->name }}</h2>
                    <p class="purchase-left__item-price">￥{{ number_format($item->price) }}(税込)</p>
                </div>
            </div>
            <div class="purchase-left__payment">
                <h3 class="purchase-left__payment-section-title">支払い方法</h3>
                <div class="purchase-left__payment-select-box">
                    <select id="payment_method" class="purchase-left__payment-method" name="payment_method">
                        <option value="" selected disabled>選択してください</option>
                        <option value="konbini">コンビニ払い</option>
                        <option value="card">カード支払い</option>
                    </select>
                    <div class="purchase-left__register-error">
                        @error('payment_method')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="purchase-left__address">
                <div class="purchase-left__address-top">
                    <h3 class="section-title">配送先</h3>
                    <a class="purchase-left__address-change"
                        href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
                </div>
                <div class="purchase-left__address-information">
                    <p class="purchase-left__address-text">〒{{ $user->postal_code }}</p>
                    <div class="purchase-left__register-error">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </div>
                    <p class="purchase-left__address-text">{{ $user->address . ' ' . $user->building }}</p>
                    <div class="purchase-left__register-error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="purchase-right">
            <form class="purchase-right__form" action="{{ route('purchase.store', ['item_id' => $item->id]) }}"
                method="POST">
                @csrf
                <table>
                    <tr>
                        <th>商品代金</th>
                        <td>￥<input id="price" class="purchase-right__form-price" type="text"
                                value="{{ number_format($item->price) }}" name="price" readonly>(税込)</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td id="payment_display">未選択</td>
                    </tr>
                </table>
                <input id="payment_hidden" type="hidden" name="payment_method" value="">
                <input type="hidden" value="{{ $item->item_image }}" name="item_image">
                <input type="hidden" value="{{ $user->postal_code }}" name="postal_code">
                <input type="hidden" value="{{ $user->address }}" name="address">
                <input type="hidden" value="{{ $user->building }}" name="building">
                <button class="purchase-right__form-submit" type="submit">購入する</button>
            </form>
        </div>
    </div>
    <script>
        const paymentSelect = document.getElementById('payment_method');
        const paymentDisplay = document.getElementById('payment_display');
        const paymentHidden = document.getElementById('payment_hidden');

        paymentSelect.addEventListener('change', function() {
            const value = this.value;
            let displayText = '';

            if (value === 'card') {
                displayText = 'カード支払い';
            } else if (value === 'konbini') {
                displayText = 'コンビニ払い';
            }
            // 表示を更新
            paymentDisplay.textContent = displayText;
            // hidden inputの値を更新（DB保存用）
            paymentHidden.value = value;
        });

        // 金額のカンマ除去（送信時）
        document.addEventListener('DOMContentLoaded', () => {
            const priceInput = document.getElementById('price');
            priceInput.form.addEventListener('submit', function() {
                const rawValue = priceInput.value.replace(/,/g, '');
                priceInput.value = rawValue;
            });
        });
    </script>
@endsection
