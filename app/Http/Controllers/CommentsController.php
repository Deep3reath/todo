<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function create(Comments $obComments, Request $obReq)
    {
        $validated = Validator::make($obReq->only(['text']),
            ['text' => 'required|min:2|max:256'], (new TaskRequest)->messages(), ['content' => 'Текст']
        );
        if ($validated->fails())
            return response()->json(['validationMessage' => $validated->errors()->first()]);
        $obComments->fill(['user_id' => Auth::user()->id, 'task_id' => $obReq->task, 'content' => $obReq->text])->save();
        return response()->json(['validationMessage' => 'success']);
    }
}
