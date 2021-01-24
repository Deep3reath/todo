<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $obReq, Like $obLike)
    {
        $obLike->fill(['user_id' => Auth::user()->id, 'task_id' => $obReq->id])->save();
        return redirect()->back();
    }

    public function unlike(Request $obReq, Like $obLike)
    {
        $obLike::where(['user_id' => Auth::user()->id, 'task_id' => $obReq->id])->delete();
        return redirect()->back();
    }
}
