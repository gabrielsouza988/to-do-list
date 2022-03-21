<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{TaskController, ItensTaskController, AuthController};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
});

Route::controller(TaskController::class)->middleware('auth')->group(function () {
    Route::get('list-tasks', 'index');
    Route::post('taskCreate', 'store');
    Route::delete('removeTask/{id}', 'delete');
});

Route::controller(ItensTaskController::class)->middleware('auth')->group(function () {
    Route::get('task/{id}', 'index');
    Route::post('itemTaskCreate/{id}', 'store');
    Route::put('itemTaskUpdate/{id}', 'update');
    Route::delete('removeItemTask/{id}', 'delete');
});
