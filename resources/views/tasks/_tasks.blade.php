
@section('_tasks')
    <?php  $i = 1 ?>
    @foreach($tasks as $task)
        <div class="d-flex flex-row task-item">
            <div class="task-item-title-container"><h5><span>{{$i}})</span>{{$task->title}}</h5></div>
                <a id="update" href="{{route('update')}}?id={{$task->id}}"></a>
                <a id="delete" href="{{route('delete')}}?id={{$task->id}}"></a>
        </div>
        <?php $i++ ?>
    @endforeach

@endsection
