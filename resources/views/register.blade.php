@extends('layout')
@section('title') Регистрация @endsection
@section('content')

    <p class="alert alert-danger d-none mt-5"></p>
    <h3 class="mt-5">Регистрация</h3>
    <form class="register-form d-flex flex-column mt-5" method="post">
        @csrf
        <input type="email" placeholder="Введите свою почту" name="email">
        <input type="text" placeholder="Введите свое имя" name="username" class="mt-4">
        <input type="password" placeholder="Введите пароль" name="password" class="mt-4">
        <input class="submit-button-form mt-5" id="submit" type="button" value="Отправить">
    </form>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".submit-button-form").click(function(e){
            e.preventDefault();
            let password = $("input[name=password]").val();
            let username = $("input[name=username]").val();
            let email = $("input[name=email]").val();
            $.ajax({
                type:'POST',
                url:"{{ route('register') }}",
                data:{"_token": $('meta[name="csrf-token"]').attr('content'), password:password, username:username, email:email},
                success: function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        console.log(response)
                        let error = $(`.alert-danger`).html(response.validationMessage)
                        error.removeClass('d-none')
                    }
                },

            });
        });
    </script>
@endsection

