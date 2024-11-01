<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/tasks', [TaskController::class, "index"]);
    Route::post('/tasks/store', [TaskController::class, "store"]);
    Route::put('/tasks/update/{id}', [TaskController::class, "update"]);
    Route::delete('/tasks/delete/{id}', [TaskController::class, "destroy"]);
});
