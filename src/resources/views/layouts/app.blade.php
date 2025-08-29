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
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>