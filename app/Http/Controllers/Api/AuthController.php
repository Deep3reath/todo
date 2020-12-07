<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $obReq)
    {
        $arCreds = $obReq->only('email', 'password');
        if (auth()->attempt($arCreds)) {
            return response()->json(['api_token' => TokenController::refresh()]);
        }
        return response()->json(['error' => true, 'message' => 'Invalid email/password']);
    }

    public function register(User $obUser, Request $obReq)
    {
        $arCredentials = $obReq->only('email', 'password', 'remember');

        $obValidator = Validator::make($obReq->all(), [
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
            return response()->json(['error'=>'true', 'message' => $obValidator->errors()->first()]);
        }
        $obUser->fill([
            'name' => $obReq->name,
            'password' => Hash::make($obReq->password),
            'email' => $obReq->email,
            'api_token' => Str::random(60),
        ])->save();
        return response()->json(['message' => 'success']);
    }
}
