@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/mypage.css') }}">
@endsection

@section('content')
    <div class="user-box">
        <div class="user-name__box">
            <div class="user-name__profile-image">
                <img class="profile-image"
                    src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}" alt="プロフィール画像"
                    style="{{ $user->profile_image ? '' : 'display:none;' }}">
            </div>
            <p class="user-name">{{ $user->name }}</p>
        </div>
        <a class="edit-link" href="/profile/edit">プロフィールを編集</a>
    </div>

    {{-- タブメニュー --}}
    <div class="tab-container">
        <div class="tab">
            <ul class="tab-inner">
                <li class="recommend selected" data-id="recommend">出品した商品</li>
                <li data-id="my-list">購入した商品</li>
            </ul>
        </div>
        {{-- 出品した商品 --}}
        <div class="product selected" id="recommend">
            @forelse($items as $item)
            <div class="product__card">
                <div class="product__box">
                    <a href="{{ route('products.item', $item->id) }}" class="product__link">
                        <img class="product__img" src="{{ asset('storage/' . $item->product_image) }}" alt="商品画像">
                        <p class="product__name">{{ $item->name }}</p>
                    </a>
                </div>
            </div>
            @empty
            <p>出品履歴はありません</p>
            @endforelse
        </div>
        {{-- 購入した商品 --}}
        <div class="product" id="my-list">
            @forelse($purchases as $purchase)
            <div class="product__card">
                <div class="product__box">
                    <a href="{{ route('products.item', $purchase->id) }}" class="product__link">
                        <img class="product__img" src="{{ asset('storage/' . $purchase->product_image) }}" alt="商品画像">
                        <p class="product__name">{{ $purchase->name }}</p>
                    </a>
                </div>
            </div>
            @empty
            <p>購入履歴はありません</p>
            @endforelse
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
    </script>
@endsection
