<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTask;
use App\Http\Requests\TaskRequest;
use App\Models\tasks;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = DB::table('tasks')->get();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param RequestTask $requestTask
     * @param Tasks $tasks
     * @param Request $request
     */
    public function create(Tasks $tasks, Request $request, RequestTask $requestTask)
    {
        $tasks->title = $request->title;
        $tasks->save();
        return redirect(route('home'));
    }

    public function update(Request $request)
    {

        $task = DB::table('tasks')->where(['id' => $request->id])->first();
        return view('tasks/_update', ['task' => $task]);
    }


    public function updatePost(Request $request, RequestTask $requestTask)
    {
        DB::table('tasks')
            ->where('id', $request->id)
            ->update(['title' => $request->title]);
        return redirect(route('home'));
    }

    public function delete(Request $request)
    {
        DB::table('tasks')
            ->where('id', $request->id)
            ->delete();
        return redirect(route('home'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tasks $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tasks $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tasks $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $tasks)
    {
        //
    }
}
