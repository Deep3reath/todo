@extends('layout')
@section('title') Регистрация @endsection
@section('content')
    <p class="alert alert-danger d-none mt-5"></p>
    <h3 class="mt-5">Регистрация</h3>
    <form class="register-form d-flex flex-column mt-5" method="post">
        @csrf
        <input type="email" placeholder="Введите свою почту" name="email">
        <input type="text" placeholder="Введите свое имя" name="firstname" class="mt-4">
        <input type="password" placeholder="Введите пароль" name="password" class="mt-4">
        <input class="submit-button-register-form mt-5" id="submit" type="button" value="Отправить">
    </form>
@endsection

