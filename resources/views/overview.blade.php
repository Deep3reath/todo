@extends('layout')
@section('title') Пользователи @endsection
@section('content')
<section class="overview-container mt-5">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Задачи</th>
            <th scope="col">Пользователи</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        @foreach($obTasks as $obTask)
        <tr>
            <td>{{$obTask->title}}</td>
            <td>{{$obTask->user->firstname}}</td>
            <td><a href="{{route('overview-task-view')}}?id={{$obTask->id}}">Посмотреть</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="overview-pagination">
    {{$obTasks->links()}}
    </div>
</section>

@endsection
