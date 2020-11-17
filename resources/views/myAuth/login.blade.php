@extends('layouts.todo')
@section('content')
    <h3>Вход</h3>
    <form method="post" action="{{route('login')}}">
        @csrf
        @if(Session::has('message'))
            <p class="alert alert-danger">{{ Session::get('message') }}</p>
        @endif
        <label for="email"></label>
        <input id="email" type="email" name="email" placeholder="Введите e-mail..">
        <label for="password"></label>
        <input id="password" type="password" name="password" placeholder="Введите ваш пароль..">
        <input type="submit" name="login" value="Отправить">
    </form>
@endsection
