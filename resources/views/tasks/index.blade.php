@extends('layouts.todo')
@section('title') Главная @endsection
@section('content')


    <form class="align-self-center form-add-task">
        @csrf
        <div class="alert alert-danger d-none form-add-alert"></div>
        <div class="form-add-input">
            <input type="text" id="title" name="title" placeholder="Добавьте новую задачу">
            <input id="submit" type="button" value="" class="line-he">
        </div>
    </form>

    <script type="text/javascript">
        $('.form-add-task').on('keyup keypress', function(e) {
            let keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#submit").click(function(e){
            e.preventDefault();
            let title = $("input[name=title]").val();

            $.ajax({
                type:'POST',
                url:"{{ route('create') }}",
                data:{"_token": $('meta[name="csrf-token"]').attr('content'), title:title},
                success: function (response) {
                    if (response.redirect) {
                        renderTasks();
                    } else {
                        console.log(response.validationMessage)
                        let error = $(`.form-add-alert`).html(response.validationMessage)
                        error.removeClass('d-none')
                    }
                },
            });
        });
        function renderTasks() {
            $.get(
                '{{route("renderTasks")}}',
                function (data) {
                    $(".content_tasks").html(data);
                }
            );
        };
        renderTasks();
    </script>
    <div class="d-flex flex-column align-items-center content_tasks">

    </div>

@endsection
