<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiCommentsController;
use App\Http\Controllers\Api\ApiTaskController;
use Illuminate\Support\Facades\Route;


Route::get('data-tasks', [ApiTaskController::class, 'get']);
Route::get('data-comments', [ApiCommentsController::class, 'get']);
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('create', [ApiTaskController::class, 'create']);
    Route::post('create-subtask', [ApiTaskController::class, 'createSubtask']);
    Route::post('create-comment', [ApiCommentsController::class, 'create']);
    Route::post('update', [ApiTaskController::class, 'update']);
    Route::post('update-subtask', [ApiTaskController::class, 'updateSubtask']);
    Route::post('delete', [ApiTaskController::class, 'delete']);
    Route::post('delete-subtask', [ApiTaskController::class, 'deleteSubtask']);
});
Route::post("login",[ApiAuthController::class, 'index']);
