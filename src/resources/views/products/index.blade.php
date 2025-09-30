@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')
    <div class="tab-container">
        <div class="tab">
            <ul class="tab-inner">
                <li class="recommend selected" data-id="recommend">おすすめ</li>
                <li data-id="my-list">マイリスト</li>
            </ul>
        </div>
        {{-- おすすめ --}}
        <div class="product selected" id="recommend">
            @foreach ($products as $product)
                <div class="product__card">
                    <div class="product__box">
                        <a href="{{ route('products.item', $product->id) }}" class="product__link">
                            <img class="product__img" src="{{ asset('storage/' . $product->product_image) }}"
                                alt="商品画像">
                            <p class="product__name">{{ $product->name }}</p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- マイリスト --}}
        <div class="product" id="my-list">
            @if (Auth::check())
                @forelse ($myLists as $myList)
                    <div class="product__card">
                        <div class="product__box">
                            <a href="{{ route('products.item', $myList->id) }}" class="product__link">
                                <img class="product__img" src="{{ asset('storage/' . $myList->product_image) }}"
                                    alt="商品画像">
                                <p class="product__name">{{ $myList->name }}</p>
                            </a>
                        </div>
                    </div>
                @empty
                    <p>お気に入りに登録した商品はありません</p>
                @endforelse
            @else
                <div class="guest-box">
                    <p>お気に入りの商品を確認する場合はログインしてください</p>
                    <div class="login__box">
                        <a class="login__url" href="/login">ログインはこちら</a>
                    </div>
                    <div class="register__box">
                        <a class="register__url" href="/register">新規会員登録はこちら</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        const tabMenuItems = document.querySelectorAll('.tab-inner li');
        const tabContents = document.querySelectorAll('.product');

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

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const url = new URL(window.location.href);
                url.searchParams.set('tab', this.dataset.tab);
                window.history.pushState({}, '', url); // ページリロードせずURL更新
            });
        });
    </script>
@endsection
