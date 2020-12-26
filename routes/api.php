<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiTaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::post('login', [AuthController::class, 'login']);
//Route::get('data', [TaskController::class, 'get']);
//Route::post('create', [TaskController::class, 'create']);
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('create', [ApiTaskController::class, 'create']);
    Route::post('update', [ApiTaskController::class, 'update']);
    Route::post('delete', [ApiTaskController::class, 'delete']);
});
Route::post("login",[\App\Http\Controllers\Api\ApiAuthController::class,'index'])->name('login');
