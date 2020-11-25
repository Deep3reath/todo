<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Работа с задачами

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\TasksController::class, 'index'])->name('home');
    Route::get('/render', [App\Http\Controllers\TasksController::class, 'renderTasks'])->name('renderTasks');
    Route::prefix('tasks')->middleware('auth')->group(function () {
        Route::post('create', [App\Http\Controllers\TasksController::class, 'create'])->name('create');
        Route::any('update', [App\Http\Controllers\TasksController::class, 'update'])->name('update');
        Route::get('delete', [App\Http\Controllers\TasksController::class, 'delete'])->name('delete');
    });
    Route::any('/logout',
        function () {
            Auth::logout();
            return redirect(\route('home'));
        })->name('logout');
});
// Авторизация и Регистрация
#Route::any();
Route::middleware('guest')->group(function () {
    Route::any('/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login');
    Route::any('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
});

