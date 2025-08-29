@extends('layouts.app')

@section('header-content')
<div class="header__center">
    <input class="header__search" type="text" placeholder="なにをお探しですか？">
</div>
<nav class="header__nav">
    <a class="header__login" href="#">ログイン</a>
    <a class="header__logout" href="#">ログアウト</a>
    <a class="header__mypage" href="マイページリンク">マイページ</a>
    <a class="header__listing" href="出品ページリンク">出品</a>
</nav>
@endsection