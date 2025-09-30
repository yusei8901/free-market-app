<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECHフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__left">
                <a href="/" class="header__link"><img src="{{ asset('img/logo.svg') }}" alt="ロゴ画像"></a>
            </h1>
            @if (!isset($hideSection) || !$hideSection)
                <div class="header__center">
                    <input class="header__search" type="text" placeholder="なにをお探しですか？">
                </div>
                <nav class="header__nav">
                    @guest
                        <a class="header__login" href="/login">ログイン</a>
                    @endguest
                    @auth
                        <form action="/logout" method="post">
                            @csrf
                            <button class="header__logout">ログアウト</button>
                        </form>
                        <a class="header__mypage" href="/mypage">マイページ</a>
                    @endauth
                    <a class="header__listing" href="/sell">出品</a>
                </nav>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
