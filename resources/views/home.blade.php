@extends('layout')
@section('title') Главная @endsection
@section('content')
    <p class="alert alert-danger d-none mt-5" style="width: 515px"></p>
    <form method="post" class="form-add mt-5">
        @csrf
        <input type="text" name="title" placeholder="Введите Задачу">
        <input class="form-add-button" type="button" value="Добавить">
    </form>
    <div class="todo-container d-flex flex-column"></div>
@endsection
