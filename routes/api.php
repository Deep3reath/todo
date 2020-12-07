<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});
Route::get('data', [TaskController::class, 'getData']);
Route::post('login',[AuthController::class, 'login']);
Route::post('register',[AuthController::class, 'register']);
Route::post('create',[TaskController::class, 'create']);
Route::post('update',[TaskController::class, 'update']);
Route::post('delete',[TaskController::class, 'delete']);
