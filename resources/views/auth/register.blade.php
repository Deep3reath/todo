@extends('layouts.todo')
@section('content')
    <h3>Регистрация</h3>
    <form>
        <div class="alert alert-danger d-none"></div>
        <label for="email"></label>
        <input id="email" type="email" name="email" placeholder="Введите e-mail..">
        <label for="name"></label>
        <input id="name" type="text" name="name" placeholder="Введите ваше имя..">
        <label for="password"></label>
        <input id="password" type="password" name="password" placeholder="Введите ваш пароль..">
        <input id="submit" type="button" name="register" value="Отправить">
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
            let name = $("input[name=name]").val();

            $.ajax({
                type:'POST',
                url:"{{ route('register') }}",
                data:{"_token": $('meta[name="csrf-token"]').attr('content'), password:password, name:name, email:email},
                success: function (response) {
                    console.log(response)
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
