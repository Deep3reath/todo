<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function authenticate(Request $obRequest)
    {
        $arCredentials = $obRequest->only('email', 'password');
        if ($obRequest->method() === 'POST') {
            if (Auth::attempt($arCredentials, $obRequest->remember))
                return response()->json(['redirect' => route('home')]);
            return response()->json(['validationMessage' => 'Неправильный логин или пароль']);
        } else {
            return view('auth.login');
        }
    }

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
                return response()->json(['validationMessage' => $obValidator->errors()->first()]);
            }
            $obUser->fill([
                'name' => $obRequest->name,
                'password' => Hash::make($obRequest->password),
                'email' => $obRequest->email,
                'api_token' => Str::random(60),
            ])->save();
            return response()->json(['redirect' => route('login')]);
        } else {
            return view('auth.register');
        }
    }
}
