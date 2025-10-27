@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/item.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="item">
        <div class="item-left">
            <div class="item-left__image">
                <img src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
            </div>
        </div>

        <div class="item-right">
            <div class="item-right__content">
                <h2 class="item-right__name">{{ $item->name }}</h2>
                <p class="item-right__brand">ブランド名：{{ $item->brand ? $item->brand : 'なし' }} </p>
                <p class="item-right__price">￥{{ number_format($item->price) }}(税込)</p>
                <div class="item-right__actions">
                    <div class="item-right__favorite">
                        @php
                            $isLiked = auth()->check() && $item->likedUsers->contains(auth()->id());
                        @endphp
                        <form action="{{ route('items.like', ['item_id' => $item->id]) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer;">
                                @if ($isLiked)
                                    <i class="fa-regular fa-star fa-2x" style="color: gold;"></i>
                                @else
                                    <i class="fa-regular fa-star fa-2x" style="color: black;"></i>
                                @endif
                            </button>
                            <p class="item-right__action-number">{{ $item->likedUsers->count() }}</p>
                        </form>
                    </div>
                    <div class="item-right__comment">
                        <i class="fa-regular fa-comment fa-2x"></i>
                        <p class="item-right__action-number">{{ $item->comments->count() }}</p>
                    </div>
                </div>
                @if ($item->sold)
                    <button class="item-right__sold">Sold Out</button>
                @else
                    <a class="item-right__purchase" href="{{ route('items.index', ['item_id' => $item->id]) }}">購入手続きへ</a>
                @endif
            </div>

            <div class="item-right__explanation">
                <h3 class="item-right__section-title">商品説明</h3>
                <p>{{ $item->description }}</p>
            </div>
            <div class="item-right__information">
                <h3 class="item-right__section-title">商品の情報</h3>
                <table>
                    <tr>
                        <th>カテゴリー</th>
                        @foreach ($item->categories as $category)
                            <td><span class="item-right__category">{{ $category->name }}</span></td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>商品の状態</th>
                        <td>{{ $item->condition }}</td>
                    </tr>
                </table>
            </div>
            <div class="item-right__comments">
                <h3 class="item-right__comment-title">コメント（{{ $item->comments->count() }}）</h3>
                @forelse ($item->comments as $comment)
                    <div class="item-right__comment-view">
                        <div class="item-right__user">
                            <img class="item-right__icon" src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                alt="アイコン画像">
                            <p class="item-right__user-name">{{ $comment->user->name }}</p>
                        </div>
                        <div class="item-right__comment-content">
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="item-right__no-comments">
                        <p>まだコメントはありません。</p>
                    </div>
                @endforelse
                <form action="{{ route('comments.store', ['item_id' => $item->id]) }}" method="post">
                    @csrf
                    <label for="comment">商品へのコメント</label>
                    <textarea name="comment" id="comment">{{ old('comment') }}</textarea>
                    <div class="item-right__error">
                        @error('comment')
                            {{ $message }}
                        @enderror
                    </div>
                    <button class="item-right__submit-btn" type="submit">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const soldButton = document.querySelector('.sold-out');
        soldButton.addEventListener('click', function() {
            alert('すでに購入された商品です');
        });
    </script>
@endsection
