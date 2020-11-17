@extends('layouts.todo')
@section('content')
    <h3>Регистрация</h3>
    <form method="post" action="{{route('register')}}">
        @csrf
        @foreach(['email', 'name', 'password'] as $error)
            @error($error)
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @endforeach
        <label for="email"></label>
        <input id="email" type="email" name="email" placeholder="Введите e-mail..">
        <label for="name"></label>
        <input id="name" type="text" name="name" placeholder="Введите ваше имя..">
        <label for="password"></label>
        <input id="password" type="password" name="password" placeholder="Введите ваш пароль..">
        <input type="submit" name="register" value="Отправить">

    </form>
@endsection
