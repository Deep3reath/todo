<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
          rel="stylesheet"
    >
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/media.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"
            type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous"
    >
    <script defer src="{{asset('js/todo-app.js')}}"></script>
</head>
<body>
<script type="text/javascript">
    const config = {
        csrf: $('meta[name="csrf-token"]').attr('content'),
        routes: {
            renderTasks: '{{route("renderTasks")}}',
            renderModal: '{{ route('renderModal') }}',
            login: '{{ route('login') }}',
            register: '{{ route('register') }}',
            create: '{{ route('create') }}',
            delete: '{{ route('delete') }}',
            sortSubtasks: '{{ route('sort-subtasks') }}',
            deleteSubtask: '{{ route('delete-subtask') }}',
            updateSubtask: '{{ route('update-subtask') }}',
            updateTitle: '{{ route('update-title') }}',
        }
    };
</script>
<header>
    <div class="container d-flex align-items-center">
        <h1 class="ml-1 align-self-center"><a href="{{route('home')}}">Todo</a></h1>
        <div class="mr-1 ">
            @if(Auth::user())
                <a href="{{route('profile')}}">Профиль</a>
                <a href="{{route('logout')}}">Выйти</a>
            @else
                <a href="{{route('login')}}">Войти</a>
                <a href="{{route('register')}}">Присоединиться</a>
            @endif
        </div>
    </div>
</header>
<section class="content d-flex flex-column">
    @yield('content')
</section>
<footer>
    <p class="ml-5">lehapro</p>
</footer>
</body>
</html>
