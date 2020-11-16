<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTasks;
use App\Models\tasks;
use Faker\Guesser\Name;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function index()
    {
        $tasks =Tasks::get();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param tasks $obTasks
     * @param RequestTasks $obRequestTask
     * @return Application|RedirectResponse|Redirector
     */
    public function create(Tasks $obTasks, RequestTasks $obRequestTask)
    {
        $obTasks->title = $obRequestTask->title;
        $obTasks->save();
        return redirect(route('home'));
    }

    public function postUpdate(Tasks $obTasks, Request $obRequest)
    {
        $obTask = $obTasks::where(['id' => $obRequest->id])->get()->first();
        if ($obRequest->updToken) {
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
                return view('tasks/_update', ['task' => $obTask])
                    ->withErrors($obValidator);
            }
            Tasks::where(['id' => $obRequest->id])
                ->update(['title' => $obRequest->title]);
            return redirect(route('home'));
        }
        return view('tasks/_update', ['task' => $obTask]);
    }

}
