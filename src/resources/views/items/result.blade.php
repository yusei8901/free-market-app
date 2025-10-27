@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/result.css') }}">
@endsection

@section('content')

    <div class="index">
        <div class="index__keyword">
            <h2>検索キーワード：「{{ $keyword }}」</h2>
        </div>
        <div class="index__tab">
            <ul class="index__tab-inner">
                <li class="index__recommend selected" data-id="index__recommend">おすすめ</li>
                <li data-id="index__my-list">マイリスト</li>
            </ul>
        </div>
        {{-- おすすめ --}}
        <div class="index__item selected" id="index__recommend">
            @forelse ($items as $item)
                <div class="index__item-card">
                    @if($item->sold)
                    <span class="sold-out">Sold</span>
                    <div class="index__item-box">
                        <a href="{{ route('items.item', $item->id) }}" class="index__item-link">
                            <img class="index__item-img" src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                            <p class="index__item-name">{{ $item->name }}</p>
                        </a>
                    </div>
                    @else
                    <div class="index__item-box">
                        <a href="{{ route('items.item', $item->id) }}" class="index__item-link">
                            <img class="index__item-img" src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                            <p class="index__item-name">{{ $item->name }}</p>
                        </a>
                    </div>
                    @endif
                </div>
            @empty
                <p class="index__result-none">該当する商品が見つかりませんでした。</p>
                <a class="index__return-url" href="/">商品一覧へ戻る</a>
            @endforelse
        </div>

        {{-- マイリスト --}}
        <div class="index__item" id="index__my-list">
            @if (Auth::check())
                @forelse ($likedItems as $likedItem)
                    <div class="index__item-card">
                        @if($likedItem->sold)
                        <span class="sold-out">Sold</span>
                        <div class="index__item-box">
                            <a href="{{ route('items.item', $likedItem->id) }}" class="index__item-link">
                                <img class="index__item-img" src="{{ asset('storage/' . $likedItem->item_image) }}"
                                    alt="商品画像">
                                <p class="index__item-name">{{ $likedItem->name }}</p>
                            </a>
                        </div>
                        @else
                        <div class="index__item-box">
                            <a href="{{ route('items.item', $likedItem->id) }}" class="index__item-link">
                                <img class="index__item-img" src="{{ asset('storage/' . $likedItem->item_image) }}"
                                    alt="商品画像">
                                <p class="index__item-name">{{ $likedItem->name }}</p>
                            </a>
                        </div>
                        @endif
                    </div>
                @empty
                    <p>検索した商品の中でお気に入りに登録した商品はありません</p>
                @endforelse
            @else
                <div class="index__item-guest-box">
                    <p>お気に入りの商品を確認する場合はログインしてください</p>
                    <div class="index__item-login-box">
                        <a class="index__item-login-url" href="/login">ログインはこちら</a>
                    </div>
                    <div class="index__item-register-box">
                        <a class="index__item-register-url" href="/register">新規会員登録はこちら</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        const tabMenuItems = document.querySelectorAll('.index__tab-inner li');
        const tabContents = document.querySelectorAll('.index__item');

        tabMenuItems.forEach(tabMenuItem => {
            tabMenuItem.addEventListener('click', () => {

                // 全てのタブからselectedクラスを外す。
                tabMenuItems.forEach(tabMenuItem => {
                    tabMenuItem.classList.remove('selected');
                });

                // クリックされたタブのみselectedクラスを付ける。
                tabMenuItem.classList.add('selected');

                // 全てのタブのコンテンツからselectedクラスを外す。
                tabContents.forEach(tabContent => {
                    tabContent.classList.remove('selected');
                });

                // クリックされたタブのカスタムデータ属性と同じIDを持つコンテンツに、selectedクラスを付ける。
                // カスタムデータ属性については別記事で紹介しています。
                document.getElementById(tabMenuItem.dataset.id).classList.add('selected');
            });
        });
    </script>




@endsection
