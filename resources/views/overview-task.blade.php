@extends('layout')
@section('title') {{$obTask->title}} @endsection
@section('content')
    <script type="text/javascript">
        function renderOverviewComments(task) {
            $.ajaxSetup();
            $.ajax({
                type: 'POST',
                url: "{{route('renderOverviewComments')}}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), task: task},
                success: function (response) {
                    if (response.template) {
                        $(`.overview-comments-list-container`).html(response.template);
                    }
                },
            });
        }

        $(document).on('click', '#form-add-comment-submit', function () {
            let content = $("#form-add-comment-input").val();
            let task = $("#form-add-comment").children("input[name=task]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('create-comment') }}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), task: task, text: content},
                success: function (response) {
                    if (response.validationMessage === 'success') {
                        renderOverviewComments(task)
                    } else {
                        let error = $(`#form-add-comment`).children('.alert').html(response.validationMessage)
                        error.removeClass('d-none')
                    }
                },
                statusCode: {
                    401: function () {
                        alert('Вы не авторизованны');
                        window.location.href = 'login';
                    }
                },
            });
        });
        renderOverviewComments("{{$obTask->id}}")
    </script>
    <section class="overview-container d-flex flex-row mt-5">
        <div class="ml-0 overview-view-task-text">
            <h4 class="mb-3"><b>Название: </b>{{$obTask->title}}</h4>
            <p><b>Подзадачи:</b></p>
            <div class="overview-subtasks-container">
                <div class="overview-subtasks-list">
                    @foreach(json_decode($obTask->subtasks, true) as $subtask)
                        <p>{{$subtask}}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="overview-view-task-info d-flex flex-column mr-0">
            <p class="mr-0">Автор: {{$obTask->user->firstname}} < {{$obTask->user->email}} ></p>
            <p class="mr-0">Дата создания: {{$obTask->created_at}}</p>
            <p class="mr-0">Последнее изменение: {{$obTask->updated_at}}</p>
            <p class="mr-0">Количество оценок: {{$likes}}</p>
            @if(!$mylike && !\Illuminate\Support\Facades\Auth::guest())
                <a href="{{route('like')}}?id={{$obTask->id}}" class="mr-0">
                    <img src="{{asset('images/like.svg')}}" alt="like" class="mr-2">Нравится
                </a>
            @elseif(!\Illuminate\Support\Facades\Auth::guest())
                <a href="{{route('unlike')}}?id={{$obTask->id}}" class="mr-0">
                    <img src="{{asset('images/like_after.svg')}}" alt="like-after" class="mr-2">Убрать лайк
                </a>
            @endif
        </div>
    </section>
    <section class="overview-comments d-flex flex-column pb-5 mb-5">
        <h5 class="ml-0"><b>Комментарии</b></h5>
        <div class="overview-comments-list-container p-5 ml-0"></div>
        @if(!\Illuminate\Support\Facades\Auth::guest())
        <form id="form-add-comment">
            @csrf
            <p class="alert alert-danger d-none mt-5" onclick="$(this).addClass('d-none')"></p>
            <input type="hidden" name="task" value="{{$obTask->id}}">
            <div class="d-flex flex-column">
                <label for="form-add-comment-input" class="ml-0">Оставьте комментарий</label>
                <div class="form-add-comment-input-wrapper ml-0">
                    <textarea id="form-add-comment-input"></textarea>
                </div>
            </div>
            <button class="btn btn-dark w-25 mt-3 float-right" type="button" id="form-add-comment-submit">Отправить</button>
        </form>
        @endif
    </section>
@endsection
