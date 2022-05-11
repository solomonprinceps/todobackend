<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
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

Route::post('todo/create', [TodoController::class, 'createtodo']);
Route::post('todo/list', [TodoController::class, 'listodo']);
Route::get('todo/{id}', [TodoController::class, 'singletodo']);
Route::get('complete/todo/{id}', [TodoController::class, 'complete_todo']);
Route::get('move/todo/active/{id}', [TodoController::class, 'movetodo_toactive']);
Route::delete('todo/delete/{id}', [TodoController::class, 'deletetodo']);
Route::delete('complete/todo/clear', [TodoController::class, 'clear_completed']);
