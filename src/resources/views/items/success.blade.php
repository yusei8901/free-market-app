@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/success.css') }}">
@endsection

@section('content')
<div class="success">
    <h2>購入が完了しました！</h2>
    <p>商品の発送をお待ちください。</p>

    <div class="success-box">
        <p class="success-box__item-name">商品名：{{ $item->name }}</p>

        <div class="success-box__img-box">
            <img class="success-box__img" src="{{ asset('storage/' . $item->item_image) }}" alt="">
        </div>

        <table>
            <tbody>
                <tr>
                    <th rowspan="2">配送先</th>
                    <td>〒{{ $purchase->postal_code }}</td>
                </tr>
                <tr>
                    <td>
                        {{ $purchase->address }} {{ $purchase->building }}
                    </td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>
                        @if ($purchase->payment_method === 'card')
                            カード支払い
                        @else
                            コンビニ払い
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>支払い金額</th>
                    <td>￥{{ number_format($item->price) }}(税込)</td>
                </tr>
            </tbody>
        </table>

        <a class="success-box__form-btn" href="/">トップに戻る</a>
    </div>
</div>
@endsection
