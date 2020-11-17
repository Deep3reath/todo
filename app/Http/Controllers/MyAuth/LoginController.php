<?php

namespace App\Http\Controllers\MyAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function authenticate(Request $obRequest)
    {
        $arCredentials = $obRequest->only('email', 'password');

        if ($obRequest->method() === 'POST') {
            if (Auth::attempt($arCredentials, $obRequest->remember)) return redirect(route('home'));
            return redirect(route('login'))->with('message', 'Неправильный логин или пароль');
        } else {
            return view('myAuth.login');
        }
    }
}
