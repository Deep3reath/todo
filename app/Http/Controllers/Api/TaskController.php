<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function getData(Tasks $obTasks, Request $obReq)
    {
        $check = TokenController::check($obReq->query('api_token'));
        return (isset($check->api_token)) ?
            \response()->json(['data' => $obTasks->select('title')->get()]) : $check;
    }

    public function create(Tasks $obTasks,Request $obReq)
    {
        $check = TokenController::check($obReq->query('api_token'));
        if (isset($check->api_token)) {
                $obValidator = Validator::make(
                    $obReq->all(), [
                    'title' => ["required", "unique:tasks,title,NULL,id,user_id,".$check->id, "max:255"],

                ], $obTasks->messages, $obTasks->attributes);
                if ($obValidator->fails()) {
                    return response()->json(['error'=> true, "message" => $obValidator->errors()->first()]);
                }
                $obTasks->user_id = $check->id;
                $obTasks->title = $obReq->title;
                $obTasks->save();
                return response()->json(['message'=> 'success', 'data' => $obTasks->getAttribute('title')]);
        }
        return $check;
    }

    public function update(Tasks $obTasks,Request $obReq)
    {
        $check = TokenController::check($obReq->query('api_token'));
        if (isset($check->api_token)) {
            $obValidator = Validator::make(
                    $obReq->all(), [
                    'title' => ["required", "unique:tasks,title,NULL,id,user_id,".$check->id, "max:255"],

                ], $obTasks->messages, $obTasks->attributes);
                if ($obValidator->fails()) {
                    return response()->json(['error'=> true, "message" => $obValidator->errors()->first()]);
                }
                $obTasks->where(['title' => $obReq->old, 'user_id' => $check->id])->update(['title' => $obReq->title]);
                return response()->json(['message'=> 'success', 'data' => $obReq->title]);
        }
        return $check;
    }
    public function delete(Tasks $obTasks, Request $obReq)
    {
        $check = TokenController::check($obReq->query('api_token'));
        if (isset($check->api_token)) {
           return Tasks::where(['title' => $obReq->title, 'user_id' => $check->id])
                ->delete() ? response()->json(['message' => 'success']) :
               response()->json(['error' => true], 404);
        }
    }

}
