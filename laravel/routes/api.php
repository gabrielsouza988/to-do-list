<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{TaskController, TodoListController, AuthController};
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
//Route::post('login', [AuthController::class, 'login']);

//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'auth'
//], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
//});

Route::controller(TaskController::class)->middleware('auth')->group(function () {
    Route::get('list-tasks', 'index');
    Route::get('task/{id}', 'secondaryTasks');
    Route::post('taskCreate', 'store');
    Route::post('secondaryTaskCreate', 'storeSecondaryTask');
    Route::put('secondaryTaskUpdate', 'update');
});
