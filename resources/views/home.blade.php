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

    <script defer type="text/javascript">
        function requestRenderTasks() {
            $.post(
                '{{route("renderTasks")}}',
                function (data) {
                    $(".todo-container").html(data);
                }
            );
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".form-add-button").click(function (e) {
            e.preventDefault();
            let title = $("input[name=title]").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('create') }}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), title: title},
                success: function (response) {
                    if (response.validationMessage === 'success') {
                        requestRenderTasks();
                    } else {
                        let error = $(`.alert-danger`).html(response.validationMessage)
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
        requestRenderTasks();
    </script>
@endsection
