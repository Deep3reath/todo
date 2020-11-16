
@section('_tasks')
    <?php  $i = 1 ?>
    @foreach($tasks as $task)
        <div class="d-flex flex-row task-item">
            <div class="task-item-title-container"><h5><span>{{$i}})</span>{{$task->title}}</h5></div>
                <form action="{{route('postUpdate')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$task->id}}">
                    <input type="hidden" name="title" value="{{$task->title}}">
                    <input type="submit">
                </form>
                <a id="delete" href="{{route('delete')}}?id={{$task->id}}"></a>
        </div>
        <?php $i++ ?>
    @endforeach

@endsection
