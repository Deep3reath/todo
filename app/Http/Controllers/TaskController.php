<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function renderTasks(Task $obTask)
    {
        return response()->json(view('task')->with(
            ['obTasks' => $obTask::where(['user_id' => Auth::user()->id]
            )->get()])->render());
    }

    public function get(Task $obTask)
    {
        return response()->json(['message' => 'success', 'data' => $obTask::get('title')], 200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function update(Task $obTask, Request $obReq)
    {
        $obTask = $obTask->where(['title' => $obReq->old, 'user_id' => Auth::user()->id])->first();
        $validated = Validator::make($obReq->only(['title']),
            (new TaskRequest)->rules(), (new TaskRequest)->messages(), (new TaskRequest)->attributes()
        );
        if ($validated->fails())
            return response()->json(['id' => $obTask->id, 'validationMessage' => $validated->errors()->first()]);
        $obTask->update([
          'title' => $obReq->title
        ]);
        return response()->json(['validationMessage' => 'success']);
    }

    public function create(Task $obTask, Request $obReq)
    {
        $validated = Validator::make($obReq->only(['title', 'user_id']),
            (new TaskRequest)->rules(), (new TaskRequest)->messages(), (new TaskRequest)->attributes()
        );
        if ($validated->fails())
            return response()->json(['validationMessage' => $validated->errors()->first()]);
        $obTask->fill(['title' => $obReq->title, 'user_id' => Auth::user()->id])->save();
        return response()->json(['validationMessage' => 'success']);
    }

    public function delete(Task $obTask, Request $obReq)
    {
        $result = $obTask->where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->delete();
        return response()->json(['validationMessage' => 'success', 'result' => $result]);
    }
}
