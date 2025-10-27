@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/mypage.css') }}">
@endsection

@section('content')
    @if (session('profile_update'))
        <div class="success-alert">
            {{ session('profile_update') }}
        </div>
    @endif
    <div class="mypage-user">
        <div class="mypage-user__box">
            <div class="mypage-user__profile">
                <img class="mypage-user__profile-image"
                    src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}" alt="プロフィール画像"
                    style="{{ $user->profile_image ? '' : 'display:none;' }}">
            </div>
            <p class="mypage-user__profile-name">{{ $user->name }}</p>
        </div>
        <a class="mypage-user__edit-link" href="/mypage/profile">プロフィールを編集</a>
    </div>

    {{-- タブメニュー --}}
    <div class="mypage-tab">
        <div class="mypage-tab__box">
            <ul class="mypage-tab__box-inner">
                <li class="recommend selected" data-id="recommend">出品した商品</li>
                <li data-id="my-list">購入した商品</li>
            </ul>
        </div>
        {{-- 出品した商品 --}}
        <div class="mypage-tab__item selected" id="recommend">
            @forelse($items as $item)
                <div class="mypage-tab__item-card">
                    @if ($item->sold)
                        <span class="sold-out">Sold</span>
                        <div class="mypage-tab__item-box">
                            <a href="{{ route('items.item', $item->id) }}" class="mypage-tab__item-link">
                                <img class="mypage-tab__item-img" src="{{ asset('storage/' . $item->item_image) }}"
                                    alt="商品画像">
                                <p class="mypage-tab__item-name">{{ $item->name }}</p>
                            </a>
                        </div>
                    @else
                        <div class="mypage-tab__item-box">
                            <a href="{{ route('items.item', $item->id) }}" class="mypage-tab__item-link">
                                <img class="mypage-tab__item-img" src="{{ asset('storage/' . $item->item_image) }}"
                                    alt="商品画像">
                                <p class="mypage-tab__item-name">{{ $item->name }}</p>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <p>出品履歴はありません</p>
            @endforelse
        </div>
        {{-- 購入した商品 --}}
        <div class="mypage-tab__item" id="my-list">
            @forelse($purchases as $purchase)
                <div class="mypage-tab__item-card">
                    <span class="sold-out">Sold</span>
                    <div class="mypage-tab__item-box">
                        <a href="{{ route('items.item', $purchase->item->id) }}" class="mypage-tab__item-link">
                            <img class="mypage-tab__item-img" src="{{ asset('storage/' . $purchase->item->item_image) }}"
                                alt="商品画像">
                            <p class="mypage-tab__item-name">{{ $purchase->item->name }}</p>
                        </a>
                    </div>
                </div>
            @empty
                <p>購入履歴はありません</p>
            @endforelse
        </div>
    </div>
    <script>
        const tabMenuItems = document.querySelectorAll('.mypage-tab__box-inner li');
        const tabContents = document.querySelectorAll('.mypage-tab__item');

        // URLパラメータから現在のタブを取得
        const params = new URLSearchParams(window.location.search);
        const activePage = params.get('page') || 'sell'; // デフォルトはsell

        // タブの表示切り替え
        function showTab(tabId) {
            tabMenuItems.forEach(tabMenuItem => {
                tabMenuItem.classList.toggle('selected', tabMenuItem.dataset.id === tabId);
            });
            tabContents.forEach(tabContent => {
                tabContent.classList.toggle('selected', tabContent.id === tabId);
            });
        }

        // 初期表示（pageが指定されていなければrecommendを表示）
        showTab(activePage === 'buy' ? 'my-list' : 'recommend');

        // タブクリック時
        tabMenuItems.forEach(tabMenuItem => {
            tabMenuItem.addEventListener('click', () => {
                const tabId = tabMenuItem.dataset.id;
                const newUrl = new URL(window.location.href);

                if (tabId === 'recommend') {
                    // 出品した商品一覧
                    newUrl.searchParams.set('page', 'sell');
                } else if (tabId === 'my-list') {
                    // 購入した商品一覧
                    newUrl.searchParams.set('page', 'buy');
                }

                // /mypage のままの場合のみ、初回に履歴を追加する
                if (!window.location.search) {
                    window.history.pushState({}, '', newUrl);
                } else {
                    window.history.replaceState({}, '', newUrl);
                }

                showTab(tabId);
            });
        });

        // 戻る・進む対応
        window.addEventListener('popstate', () => {
            const params = new URLSearchParams(window.location.search);
            const page = params.get('page') || 'sell';
            showTab(page === 'buy' ? 'my-list' : 'recommend');
        });
    </script>
@endsection
