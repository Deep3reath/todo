<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController
{
    public static function check($sReqToken)
    {
        // По сути, при каждом действии мы смотрим, есть ли такой токен в бд,
        // и возвращает ответ при ошибке, если же у нас все верно, то оно возвращает модель, дабы
        // в контроллерах у Task мы могли обратиться к user_id
        $obUser = User::where(['api_token' => $sReqToken])->get()->first();
        switch ($sReqToken) {
            case null : return response()->json(['error' => true, 'message' => 'Unauthorized'], 401);
            case $obUser === null || $sReqToken !== $obUser->api_token : return response()->json(['error' => true, 'message' => 'Invalid token'], 401);
            default : return $obUser;
        }
    }

    public static function refresh()
    {
        User::where(['id' => \auth()->user()->id])->update(['api_token' => $token = Str::random(80)]);
        return $token;
    }
}
