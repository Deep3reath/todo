@extends('layout')
@section('title') Вход @endsection
@section('content')
    <p class="alert alert-danger d-none mt-5"></p>
    <h3 class="mt-5">Вход</h3>
    <form action="#" class="register-form d-flex flex-column mt-5">
        @csrf
        <input type="email" name="email" placeholder="Введите свою почту">
        <input type="password" name="password" placeholder="Введите пароль" class="mt-4">
        <input class="submit-button-login-form mt-5" type="button" value="Отправить">
    </form>
@endsection
