<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiCommentsController extends Controller
{
    public function get()
    {
        return response()->json(['data' => Comments::all()]);
    }

    public function create(Comments $obComments, Request $obReq)
    {
        $validated = Validator::make($obReq->only(['text']),
            ['text' => 'required|min:2|max:256', 'task_id' => 'required'],
            (new TaskRequest)->messages(), ['content' => 'Текст']
        );
        if ($validated->fails())
            return response()->json(['validationMessage' => $validated->errors()->first()]);
        $obComments->fill([
            'content' => $obReq->text,
            'user_id' => Auth::user()->id,
            'task_id' => $obReq->task
        ])->save();
        return response()->json(['data' => $obComments]);
    }
}
