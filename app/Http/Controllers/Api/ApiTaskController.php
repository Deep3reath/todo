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
    public function get()
    {
        foreach ($obTask = Task::get() as $ind=>$val) {
            $obTask[$ind]->decodeSubtasks();
        }
        return response()->json(['message' => 'success', 'data' => $obTask], 200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function update(Task $obTasks, TaskRequest $obReq)
    {
        return (($res = $obTasks::where(['title' => $obReq->old, 'user_id' => Auth::user()->id])->get()->first()->fill([
          'title' => $obReq->title
        ]))->update()) ?
            response()->json(['message' => 'success', 'data' => $res]) :
            response()->json(['message' => 'error']);
    }

    public function createSubtask(Task $obTasks, Request $obReq)
    {
        $obTask = Task::where(['title' => $obReq->title, 'user_id' => Auth::user()->id])->first();
        $validated = Validator::make($obReq->only(['subtask']),
            ['subtask' => 'required|min:2|max:31'], (new TaskRequest)->messages(), ['subtask' => 'Подзадача']
        );
        if ($validated->fails())
            return response()->json(['id' => $obTask->id, 'validationMessage' => $validated->errors()->first()]);
        $arSubtasks = json_decode($obTask->subtasks);
        $arSubtasks[] = $obReq->subtask;
        $obTasks->where(['title' => $obReq->title, 'user_id' => Auth::user()->id])->update([
            'subtasks' => json_encode($arSubtasks),
        ]);
        return response()->json(['message' => 'success', 'data' => $arSubtasks]);
    }

    public function create(Task $obTasks, TaskRequest $obReq)
    {
        return $obTasks->fill(['title' => $obReq->title, 'subtasks'=> json_encode([]), 'user_id' => Auth::user()->id])->save() ?
            response()->json(['message' => 'success', 'data' => $obTasks]) :
            response()->json(['message' => 'error']);
    }

    public function delete(Task $obTasks, Request $obReq)
    {
        $obTasks::where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->delete();
    }

    public function deleteSubtask(Task $obTasks, Request $obReq)
    {
        $obTask = $obTasks::where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->first();
        $arSubtasks = json_decode($obTask->subtasks);
        array_splice($arSubtasks, $obReq->ind);
        return $obTask->update([
            'subtasks' => json_encode($arSubtasks)
        ]) ?
            response()->json(['message' => 'success', 'data' => $arSubtasks]) :
            response()->json(['message' => 'error']);
    }
}
