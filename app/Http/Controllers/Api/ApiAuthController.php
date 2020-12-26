<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ApiAuthController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function login(Request $obReq)
    {
        if ($obReq->method() === 'POST') {
            $arCreds = $obReq->only(['email', 'password']);
            return Auth::attempt($arCreds) ?
                response()->json(['message' => 'success', 'name' => Auth::user()->username]) :
                response()->json(
                    ['message' => 'Неправильный логин или пароль'], 401,
                    ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                    JSON_UNESCAPED_UNICODE
                );
        }
        return response()->json(['message' => 'form', 'template' => view('login')->render()]);
    }

    public function register(Request $obReq, User $obUser)
    {
        if ($obReq->method() === 'POST') {
            $obValidated = Validator::make($obReq->only(['email', 'password']),
                [
                    'email' => 'min:2|max:15|required',
                    'password' => 'min:2|max:31|required',
                ]);
            if ($obValidated->errors()->count() !== 0) {
                return response()->json($obValidated->errors()->count(), 401);
            }
            $obUser->fill([
                'email' => $obReq->email,
                'password' => Hash::make($obReq->password)
            ])->save();
            $token = $obUser->createToken($obReq->api_token)->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
    }

    public function token(Request $obReq)
    {
        $obValidated = Validator::make($obReq->only(['email', 'username', 'password']),
            [
                'email' => 'min:2|max:15|required',
                'username' => 'min:2|max:15|required',
                'password' => 'min:2|max:31|required',
            ]);
        if ($obValidated->fails()) {
            return response()->json(['message' => $obValidated->errors()], 401);
        }
        $obUser = User::where('email', $obReq->email)->first();
        if (!$obUser || !Hash::check($obReq->password, $obUser->password)) {
        return response()->json(['error' => 'The provided credentials are incorrect . '], 401);
    }
        return response()->json(['token' => $obUser->createToken($obReq->username)->plainTextToken]);
    }
}
