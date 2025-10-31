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

        const params = new URLSearchParams(window.location.search);
        const activeTab = params.get('tab') || 'recommend';

        // タブの表示切り替え関数
        function showTab(tabId) {
            tabMenuItems.forEach(tabMenuItem => {
                tabMenuItem.classList.toggle('selected', tabMenuItem.dataset.id === 'index__' + tabId);
            });

            tabContents.forEach(tabContent => {
                tabContent.classList.toggle('selected', tabContent.id === 'index__' + tabId);
            });
        }
        showTab(activeTab);
        tabMenuItems.forEach(tabMenuItem => {
            tabMenuItem.addEventListener('click', () => {
                const tabId = tabMenuItem.dataset.id.replace('index__', '');
                const newUrl = new URL(window.location.href);
                if (tabId === 'recommend') {
                    // おすすめタブならURLを / に戻す
                    newUrl.searchParams.delete('tab');
                    window.history.pushState({}, '', newUrl.origin + newUrl.pathname);
                } else {
                    // それ以外のタブならパラメータを付与
                    newUrl.searchParams.set('tab', tabId);
                    window.history.pushState({}, '', newUrl);
                }
                showTab(tabId);
            });
        });
        // ブラウザの戻る/進む対応
        window.addEventListener('popstate', () => {
            const params = new URLSearchParams(window.location.search);
            const tabId = params.get('tab') || 'recommend';
            showTab(tabId);
        });
    </script>
@endsection
