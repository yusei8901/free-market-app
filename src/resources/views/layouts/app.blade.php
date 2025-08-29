<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECHフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__left">
                <a href="/" class="header__link"><img src="{{ asset('img/logo.svg') }}" alt="ロゴ画像"></a>
            </h1>
            @yield('header-content')
            <div class="header__center">
                <input class="header__search" type="text" placeholder="なにをお探しですか？">
            </div>

            <nav class="header__nav">
                <a class="header__login" href="#">ログイン</a>
                <a class="header__logout" href="#">ログアウト</a>
                <a class="header__mypage" href="マイページリンク">マイページ</a>
                <a class="header__listing" href="出品ページリンク">出品</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>