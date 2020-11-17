<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') </title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<header>
    <div class="container d-flex flex-row justify-content-between">
        <h1><a href="{{route('home')}}">Todo</a></h1>
        <div class="align-self-center">
            @if(!Auth::check())
                <a href="{{route('login')}}">Войти</a>
                <a class="ml-1" href="{{route('register')}}">Регистрация</a>
            @else
                <a href="{{route('logout')}}">Выйти</a>
            @endif
        </div>
    </div>
</header>
<main class="container d-flex flex-column">
    @yield('content')
</main>
<footer>
    <div class="container">
        <p class="text-right">lehapro</p>
    </div>
</footer>
</body>
</html>
