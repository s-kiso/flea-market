<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+JP:wght@100..900&family=Noto+Serif+JP:wght@900&display=swap" rel="stylesheet">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">
                <img src=" {{ asset('storage/'.'header-logo.png') }}" alt="">
            </a>
        </div>
        @if(Auth::check())
        <form action="/logout" method="post" class="logout-form">
            @csrf
            <button class="header-button">ログアウト</button>
        </form>
        @endif
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>