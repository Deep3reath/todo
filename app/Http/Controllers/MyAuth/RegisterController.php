<?php

namespace App\Http\Controllers\MyAuth;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

class RegisterController extends Controller
{
    public function register(User $obUser, Request $obRequest)
    {
        $arCredentials = $obRequest->only('email', 'password', 'remember');

        if ($obRequest->method() === 'POST') {
            $obValidator = Validator::make($obRequest->all(), [
                'email' => 'required|unique:user|max:255',
                'name' => 'required|max:255',
                'password' => 'required|max:255',
            ], [
                'required' => 'Поле `:attribute` должно быть заполнено.',
                'max' => 'Максимальная длина поля `:attribute`, :max символа',
                'unique' => 'Пользователь с таким e-mail уже существует.',
            ], [
                'email' => 'Почта',
                'name' => 'Имя',
                'password' => 'Пароль',
            ]);
            if ($obValidator->fails()) {
                return view('myAuth.register')
                    ->withErrors($obValidator);
            }
            $obUser->fill([
                'name' => $obRequest->name,
                'password' => Hash::make($obRequest->password),
                'email' => $obRequest->email,
            ])->save();
            return redirect(route('login'));
        } else {
            return view('myAuth.register');
        }
    }
}
