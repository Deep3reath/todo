<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTask;
use App\Http\Requests\RequestTasks;
use App\Http\Requests\TaskRequest;
use App\Models\tasks;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function index()
    {

        return view('tasks.index', ['tasks' => Tasks::where(['user_id' => Auth::user()->id])->get(), 'user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param tasks $obTasks
     * @param RequestTasks $obRequestTask
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Tasks $obTasks, RequestTasks $obRequestTask)
    {
        $obTasks->title = $obRequestTask->title;
        $obTasks->user_id = Auth::user()->id;
        $obTasks->save();
        return redirect(route('home'));
    }


    public function update(Tasks $obTasks, Request $obRequest)
    {
        $obTask = $obTasks::where(['id' => $obRequest->id])->get()->first();

        if ($obRequest->method() === 'POST') {
            $obValidator = Validator::make($obRequest->all(), [
                'title' => 'required|unique:tasks|max:255',
            ], [
                'required' => 'Поле `:attribute` должно быть заполнено.',
                'max' => 'Максимальная длина поля `:attribute`, 128 символов.',
                'unique' => 'Такая задача уже существует.',
            ], [
                'title' => 'Задача',
            ]);
            if ($obValidator->fails()) {
                return view('tasks._update', ['task' => $obTask])
                    ->withErrors($obValidator);
            }
            Tasks::where(['id' => $obRequest->id])
                ->update(['title' => $obRequest->title]);
            return redirect(route('home'));
        }
        return view('tasks._update', ['task' => $obTask]);
    }

    public function delete(Request $request)
    {
        DB::table('tasks')
            ->where('id', $request->id)
            ->delete();
        return redirect(route('home'));

    }
}
