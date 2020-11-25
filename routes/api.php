<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function() {
    Route::prefix('/api/tasks')->middleware('auth')->group(function () {
        Route::post('create', [App\Http\Controllers\TasksController::class, 'create'])->name('create');
        Route::any('update', [App\Http\Controllers\TasksController::class, 'update'])->name('update');
        Route::get('delete', [App\Http\Controllers\TasksController::class, 'delete'])->name('delete');
    });
});

Route::middleware('guest')->group(function () {
    Route::any('/api/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login');
    Route::any('/api/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
});
