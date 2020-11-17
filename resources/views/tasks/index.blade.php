@extends('layouts.todo')
@include('tasks._tasks')
@section('title') Главная @endsection
@section('content')


    <form method="post" action="{{route('create')}}" class="align-self-center form-add-task">
        @csrf
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-add-input">
            <input type="text" id="title" name="title" placeholder="Добавьте новую задачу">
            <input type="submit" value="">
        </div>
    </form>
    <div class="d-flex flex-column align-items-center">
        @yield('_tasks')
    </div>
@endsection
