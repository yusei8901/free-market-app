@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/products/item.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="item-wrapper">
        <div class="item-left">
            <div class="item-left__img-box">
                <img src="{{ asset('storage/' . $product->product_image) }}" alt="商品画像">
            </div>
        </div>

        <div class="item-right">
            <div class="item-right__product">
                <h2 class="product-title">{{ $product->name }}</h2>
                <p class="brand-name">ブランド名：{{ $product->brand ? $product->brand : 'なし' }} </p>
                <p class="price">￥{{ number_format($product->price) }}(税込)</p>
                <div class="actions">
                    <div class="favorite">
                        @php
                            $isLiked = auth()->check() && $product->likedUsers->contains(auth()->id());
                        @endphp
                        <form action="{{ route('products.like', ['item_id' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer;">
                                @if ($isLiked)
                                    <i class="fa-regular fa-star fa-2x" style="color: gold;"></i>
                                @else
                                    <i class="fa-regular fa-star fa-2x" style="color: black;"></i>
                                @endif
                            </button>
                            <p class="action-number">{{ $product->likedUsers->count() }}</p>
                        </form>
                    </div>
                    <div class="comment">
                        <i class="fa-regular fa-comment fa-2x"></i>
                        <p class="action-number">{{ $product->comments->count() }}</p>
                    </div>
                </div>
                <a class="purchase-link" href="{{ route('products.purchase', ['item_id' => $product->id]) }}">購入手続きへ</a>
            </div>

            <div class="item-right__explanation">
                <h3 class="section-title">商品説明</h3>
                <p>{{ $product->description }}</p>
            </div>
            <div class="item-right__information">
                <h3 class="section-title">商品の情報</h3>
                <table>
                    <tr>
                        <th>カテゴリー</th>
                        @foreach ($product->categories as $category)
                            <td><span class="category">{{ $category->name }}</span></td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>商品の状態</th>
                        <td>{{ $product->condition }}</td>
                    </tr>
                </table>
            </div>
            <div class="item-right__comments">
                <h3 class="comment-title">コメント（{{ $product->comments->count() }}）</h3>
                @forelse ($product->comments as $comment)
                    <div class="comment-view">
                        <div class="user">
                            <img class="icon" src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                alt="アイコン画像">
                            <p class="user-name">{{ $comment->user->name }}</p>
                        </div>
                        <div class="comment-content">
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </div>
                @empty
                    <p>まだコメントはありません。</p>
                @endforelse

                <form action="{{ route('comments.store', ['item_id' => $product->id]) }}" method="post">
                    @csrf
                    <label for="comment">商品へのコメント</label>
                    <textarea name="comment" id="comment"></textarea>
                    <button class="submit-btn" type="submit">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
@endsection
