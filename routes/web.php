<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', [App\Http\Controllers\TasksController::class, 'index'])->name('home');

Route::post('/task/create', [App\Http\Controllers\TasksController::class, 'create'])->name('create');
Route::post('/task/postUpdate', [App\Http\Controllers\TasksController::class, 'postUpdate'])->name('postUpdate');
Route::get('/task/postUpdate', [App\Http\Controllers\TasksController::class, 'postUpdate'])->name('postUpdate');
Route::get('/task/delete', [App\Http\Controllers\TasksController::class, 'delete'])->name('delete');
