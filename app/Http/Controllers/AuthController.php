<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(Request $obReq)
    {
        if ($obReq->method() === 'POST') {
            $arCreds = $obReq->only(['email', 'password']);
            if (Auth::attempt($arCreds)) {
              return response()->json(['message' => 'success', 'redirect' => '/']);
            }
            return response()->json(
                ['validationMessage' => 'Неправильный логин или пароль'], 200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
        }
        return view('login');
    }

    public function register(Request $obReq, User $obUser)
    {
        if ($obReq->method() === 'POST') {
            $obValidated = Validator::make($obReq->only(['email', 'firstname', 'password']),
                [
                    'email' => 'email:rfc,dns|min:2|max:63|required|unique:user',
                    'firstname' => 'min:2|max:63|required',
                    'password' => 'min:2|max:31|required',
                ]);
            if ($obValidated->fails()) {
                return response()->json(['validationMessage' => $obValidated->errors()->first()]);
            }
            $obUser->fill([
                'email' => $obReq->email,
                'firstname' => $obReq->firstname,
                'password' => Hash::make($obReq->password)
            ])->save();
            return response()->json(['message' => 'success', 'redirect' => 'login']);
        }
        return view('register');
    }
}
