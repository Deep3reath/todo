<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Like;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    public function tasks(Task $obTasks)
    {
        return view('overview', ['obTasks' => $obTasks->orderBy('id', 'DESC')->paginate(10)]);
    }

    public function renderOverviewComments(Request $obReq, Comments $obComments)
    {
        $obComments = Comments::where(['task_id' => $obReq->task])->get();
        return response()->json(
            ['template' => view('overview-comments')->with(['obComments' => $obComments])->render()]);
    }

    public function task(Task $obTask, Like $obLike, Comments $obComments, Request $obReq)
    {
        $obTask = Task::where(['id' => $obReq->id])->first();
        $obComments = Comments::where(['task_id' => $obReq->id])->get();
        $likes = Like::where(['task_id' => $obReq->id])->count();
        if (!Auth::guest()) {
            $mylike = Like::where(['task_id' => $obReq->id, 'user_id' => Auth::user()->id])->count() ? true : false;
        } else {$mylike = false;}
        return view('overview-task', compact(['obTask', 'likes', 'mylike', 'obComments']));
    }
}
