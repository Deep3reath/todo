@extends('layout')
@section('title') Вход @endsection
@section('content')

    <p class="alert alert-danger d-none mt-5"></p>
    <h3 class="mt-5">Вход</h3>
    <form action="#" class="register-form d-flex flex-column mt-5">
        @csrf
        <input type="email" name="email" placeholder="Введите свою почту">
        <input type="password" name="password" placeholder="Введите пароль" class="mt-4">
        <input class="submit-button-form mt-5" type="button" value="Отправить">
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
