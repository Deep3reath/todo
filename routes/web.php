<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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
Route::get('/home', function () {
    return view('home');
});
Route::get('/', function () {
    return view('home');
})->name('home');
Route::group(['middleware' => 'guest'], function () {
    Route::any('register', [AuthController::class, 'register'])->name('register');
    Route::any('login', [AuthController::class, 'login'])->name('login');
});
Route::group(['middleware' => 'auth'], function () {
    Route::any('logout', function () {
        Auth::logout();
        return redirect(route('home'));
    })->name('logout');
    Route::post('create', [TaskController::class, 'create'])->name('create');
    Route::post('update', [TaskController::class, 'update'])->name('update');
    Route::post('delete', [TaskController::class, 'delete'])->name('delete');
    Route::post('renderTasks', [TaskController::class, 'renderTasks'])->name('renderTasks');
    Route::post('renderModal', [TaskController::class, 'renderModal'])->name('renderModal');
});

