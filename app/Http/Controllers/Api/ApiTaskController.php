<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiTaskController extends Controller
{
    public function get(Task $obTask)
    {
        return response()->json(['message' => 'success', 'data' => $obTask::get('title')], 200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function update(Task $obTask, TaskRequest $obReq)
    {
        return (($res = $obTask::where(['title' => $obReq->old, 'user_id' => Auth::user()->id])->get()->first()->fill([
          'title' => $obReq->title
        ]))->update()) ?
            response()->json(['message' => 'success', 'data' => $res]) :
            response()->json(['message' => 'error']);
    }

    public function create(Task $obTask, TaskRequest $obReq)
    {
        return $obTask->fill(['title' => $obReq->title, 'user_id' => Auth::user()->id])->save() ?
            response()->json(['message' => 'success', 'data' => $obTask]) :
            response()->json(['message' => 'error']);
    }

    public function delete(Task $obTask, Request $obReq)
    {
        $obTask::where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->delete();
    }
}
