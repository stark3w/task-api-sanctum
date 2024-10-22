<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);

Route::post('/admin/token', [\App\Http\Controllers\Auth\AuthController::class, 'adminToken'])
    ->middleware(['auth:sanctum', 'abilities:task:manage', \App\Http\Middleware\EnsureUserIsAdmin::class]);

Route::middleware('auth:sanctum')
    ->prefix('Tasks')
    ->group(function () {
    Route::get('/', [\App\Http\Controllers\Task\TaskController::class, 'index']);
    Route::get('/{task}', [\App\Http\Controllers\Task\TaskController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'abilities:task:manage', \App\Http\Middleware\EnsureUserIsAdmin::class])
    ->prefix('Tasks')
    ->group(function () {
   Route::post('/', [\App\Http\Controllers\Task\TaskController::class, 'store']);
   Route::put('/{task}', [\App\Http\Controllers\Task\TaskController::class, 'update']);
   Route::delete('/{task}', [\App\Http\Controllers\Task\TaskController::class, 'destroy']);
});


