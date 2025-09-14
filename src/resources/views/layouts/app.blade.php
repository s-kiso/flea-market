<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+JP:wght@100..900&family=Noto+Serif+JP:wght@900&display=swap" rel="stylesheet">
    @yield('css')
</head>
<body>

    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <a href="/">
                <img src=" {{ asset('storage/'.'header-logo.png') }}" alt="">
                </a>
            </div>
            
            <div class="header-search-form">
                <form action="{{ route('home') }}" method="get">
                    <input type="hidden" name="url" value="{{ str_replace(url('/'),"",request()->fullUrl()) }}">
                    <input type="text" name="search" value="{{$search ?? '' }}" placeholder="なにをお探しですか？" class="header-search-input">
                </form>
            </div>
            <div class="header-nav">
                @if(Auth::check())
                <form action="/logout" method="post">
                    @csrf
                    <button class="header-button">ログアウト</button>
                </form>
                @else
                <a href="/login" class="header-button-a">ログイン</a>
                @endif
                <a href="/mypage" class="header-button-a">マイページ</a>
                <a href="/sell" class="header-button-sell">出品</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>