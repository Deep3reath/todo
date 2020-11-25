@extends('layouts.todo')
@section('content')
    <h3>Вход</h3>
    <form method="post" action="{{route('login')}}">
        @csrf
        <p class="alert alert-danger d-none"></p>
        <label for="email"></label>
        <input id="email" type="email" name="email" placeholder="Введите e-mail..">
        <label for="password"></label>
        <input id="password" type="password" name="password" placeholder="Введите ваш пароль..">
        <input id="submit" type="button" name="login" value="Отправить">
    </form>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#submit").click(function(e){
            e.preventDefault();
            let password = $("input[name=password]").val();

            let email = $("input[name=email]").val();

            $.ajax({
                type:'POST',
                url:"{{ route('login') }}",
                data:{"_token": $('meta[name="csrf-token"]').attr('content'), password:password, email:email},
                success: function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        let error = $(`.alert-danger`).html(response.validationMessage)
                        error.removeClass('d-none')
                    }
                },
            });
        });
    </script>
@endsection
