<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTask;
use App\Http\Requests\RequestTasks;
use App\Http\Requests\TaskRequest;
use App\Models\tasks;
use Faker\Guesser\Name;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class TasksController extends Controller
{
    public function index()
    {
        return view('tasks.index', ['user' => Auth::user()]);
    }


    public function renderTasks(Tasks $obTasks)
    {
        $obTasks = $obTasks::where(['user_id' => Auth::user()->id])->get();
        return View::make("tasks._tasks")
            ->with("tasks", $obTasks)
            ->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param tasks $obTasks
     * @param Request $obRequest
     * @return bool|JsonResponse
     */

    public function create(Tasks $obTasks, Request $obRequest)
    {
        if ($obRequest->method() === 'POST') {
            $obValidator = Validator::make(
                $obRequest->all(), [
                    'title' => ["required", "unique:tasks,title,NULL,id,user_id,".Auth::user()->id, "max:255"],

                ], $obTasks->messages, $obTasks->attributes);
            if ($obValidator->fails()) {
                return response()->json(["validationMessage" => $obValidator->errors()->first()]);
            }
            $obTasks->user_id = Auth::user()->id;
            $obTasks->title = $obRequest->title;
            $obTasks->save();
            return response()->json(['redirect' => route('home')]);
        }
    }


    public function update(Request $obRequest)
    {
        $obTask = Tasks::where(['title' => $obRequest->old, 'user_id' => Auth::user()->id])->get()->first();

        if ($obRequest->method() === 'POST') {
            $obValidator = Validator::make(
                $obRequest->all(),
                [
                    'title' => ["required", "unique:tasks,title,NULL,id,user_id,".Auth::user()->id, "max:255"],
                ], [
                    'required' => 'Поле `:attribute` должно быть заполнено.',
                    'max' => 'Максимальная длина поля `:attribute`, 128 символов.',
                    'unique' => 'Такая задача уже существует.',
                ],
                ['title' => 'Задача']
            );
            if ($obValidator->fails()) {
                return response()->json(['validationMessage' => $obValidator->errors()->first(), 'id' => $obTask->id]);
            }
            $obTask->fill(['title' => $obRequest->title])->save();
            return response()->json(['redirect' => route('home')]);
        }
        return response()->json(['redirect' => route('home')]);
    }

    public function delete(Tasks $obTasks, Request $obRequest)
    {
        DB::table('tasks')
            ->where(['title' => $obRequest->title, 'user_id' => Auth::user()->id])
            ->delete();
        return response()->json(['redirect' => route('home')]);
    }

}
