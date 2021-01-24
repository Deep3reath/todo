<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [OverviewController::class, 'tasks'])->name('home');
Route::get('/overview', [OverviewController::class, 'tasks']);

Route::prefix('overview')->group(function () {

    Route::get('task/view', [OverviewController::class, 'task'])->name('overview-task-view');
    Route::post('task/view/comments', [OverviewController::class, 'renderOverviewComments'])
        ->name('renderOverviewComments');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('task/like', [LikeController::class, 'like'])->name('like');
        Route::get('task/unlike', [LikeController::class, 'unlike'])->name('unlike');

        Route::post('task/create-comment', [CommentsController::class, 'create'])->name('create-comment');
    });
});

Route::group(['middleware' => 'guest'], function () {
    Route::any('register', [AuthController::class, 'register'])->name('register');
    Route::any('login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::any('logout', function () {
        Auth::logout();
        return redirect(route('home'));
    })->name('logout');

    Route::get('/profile', function () {
        return view('home');
    })->name('profile');

    Route::prefix('profile')->group(function () {

        Route::post('create', [TaskController::class, 'create'])->name('create');
        Route::post('create-subtask', [TaskController::class, 'createSubtask'])->name('create-subtask');

        Route::post('update-title', [TaskController::class, 'update'])->name('update-title');
        Route::post('update-subtask', [TaskController::class, 'updateSubtask'])->name('update-subtask');

        Route::post('delete', [TaskController::class, 'delete'])->name('delete');
        Route::post('deleteSubtask', [TaskController::class, 'deleteSubtask'])->name('delete-subtask');

        Route::post('sort-subtasks', [TaskController::class, 'sortSubtasks'])->name('sort-subtasks');

        Route::post('render-tasks', [TaskController::class, 'renderTasks'])->name('renderTasks');
        Route::post('render-subtasks', [TaskController::class, 'renderSubtasks'])->name('renderSubtasks');
        Route::post('render-modal', [TaskController::class, 'renderModal'])->name('renderModal');
        Route::post('render-comments', [TaskController::class, 'renderModalComments'])->name('renderModalComments');

    });
});

