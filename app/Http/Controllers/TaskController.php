<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Comments;
use App\Models\Like;
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

    public function renderModalComments(Comments $obComments, Request $obReq)
    {
        return response()->json(['template' => view('modal-comments')->with(
            ['obComments' => $obComments::where(['task_id' => $obReq->task])->orderBy('id', 'DESC')->get()])
            ->render()]);
    }

    public function sortSubtasks(Task $obTasks, Request $obReq)
    {
        $obTasks = Task::where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->first();
        $arSubtasks = json_decode($obTasks->subtasks, true);
        $arNewSubtasksList = [];
        foreach ($obReq->sequence as $ind=>$val) {
            $arNewSubtasksList[] = $arSubtasks[$val];
        }
        $obTasks->update([
            'subtasks' => json_encode($arNewSubtasksList)
        ]);
        return response()->json(['message' => 'success']);
    }

    public function renderSubtasks(Task $obTask, Request $obReq)
    {
        $obTask = Task::where(['title' => $obReq->title, 'user_id' => Auth::user()->id]
        )->first();
        return empty(json_decode($obTask->subtasks)) ? response()->json(['template' => 'Подзадач нету']) :
            response()->json(['template' => view('subtasks')->with(
                ['arSubtasks' => json_decode($obTask->subtasks), 'title' => $obTask->title]
            )->render(), 'items' => json_decode($obTask->subtasks, true)]);
    }

    public function renderModal(Like $obLike, Task $obTask, Request $obReq)
    {
        $arSubtasks = $obTask::where(['title' => $obReq->title, 'user_id' => Auth::user()->id]
        )->first();
        return is_null($arSubtasks) ? response()->json([$obReq->title]) : response()->json(
            ['template' => view('modal')->with(
                [
                    'obTask' => $obTask = $obTask = $obTask::where(['user_id' => Auth::user()->id, 'title' => $obReq->title])
                        ->get()->first(),
                    'like' => $obLike::where(['user_id' => Auth::user()->id, 'task_id' => $obTask->id])->count(),
                    'subtasks' => $obTask->subtasks
                ])->render()]);
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

    public function updateSubtask(Task $obTask, Request $obReq)
    {
        $obTask = Task::where(['title' => $obReq->title, 'user_id' => Auth::user()->id])->first();
        $arSubtasks = json_decode($obTask->subtasks);
        $validated = Validator::make($obReq->only(['subtask']),
            ['subtask' => 'required|min:2|max:31'], (new TaskRequest)->messages(), ['subtask' => 'Подзадача']
        );
        $arSubtasks[$obReq->ind] = $obReq->subtask;
        if ($validated->fails())
            return response()->json(['id' => $obTask->id, 'validationMessage' => $validated->errors()->first()]);

        $obTask::where(['title' => $obReq->title, 'user_id' => Auth::user()->id])->update([
            'subtasks' => json_encode($arSubtasks)
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
        $obTask->fill(['title' => $obReq->title, 'user_id' => Auth::user()->id, 'subtasks' => json_encode([])])->save();
        return response()->json(['validationMessage' => 'success']);
    }

    public function createSubtask(Task $obTask, Request $obReq)
    {
        $validated = Validator::make($obReq->only(['subtask']),
            ['subtask' => 'required|min:2|max:31'], (new TaskRequest)->messages(), ['subtask' => 'Подзадача']
        );
        if ($validated->fails())
            return response()->json(['validationMessage' => $validated->errors()->first()]);
        $obTask = Task::where(['title' => $obReq->title, 'user_id' => Auth::user()->id])->first();
        $arSubtasks = json_decode($obTask->subtasks, true);
        array_push($arSubtasks, $obReq->subtask);
        $obTask->where(['title' => $obReq->title, 'user_id' => Auth::user()->id])
            ->update([
                'title' => $obReq->title,
                'subtasks' => $arSubtasks,
            ]);
        return response()->json(['validationMessage' => 'success']);
    }

    public function delete(Task $obTask, Request $obReq)
    {
        $result = $obTask->where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->delete();
        return response()->json(['validationMessage' => 'success', 'result' => $result]);
    }

    public function deleteSubtask(Task $obTask, Request $obReq)
    {
        $obTask = Task::where(['user_id' => Auth::user()->id, 'title' => $obReq->title])->first();
        $arSubtasks = json_decode($obTask->subtasks, true);
        array_splice($arSubtasks, $obReq->ind, 1);
        $obTask->update(
            ['subtasks' => json_encode($arSubtasks)]
        );
        return response()->json(['validationMessage' => 'success']);
    }
}
