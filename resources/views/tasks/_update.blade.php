@extends('layouts.todo')
@section('title') Изменить задачу: {{$task->title}} @endsection
@section('content')
    <div class="align-self-center d-flex flex-column align-content-center">
        <h3>Изменить задачу: {{$task->title}}</h3>
        <form method="post" action="{{route('update')}}" class="form-update-task d-flex flex-column">
            @csrf
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="hidden" name="id" value="{{$task->id}}">
            <div class="form-update-input">
                <input type="text" name="title" value="{{$task->title}}">
                <input type="submit" name="update" value="">
            </div>
        </form>
    </div>
@endsection
