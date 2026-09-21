<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [TestController::class,'index']);

Route::apiResource('project', ProjectController::class)->middleware('auth:sanctum'); // Project Api
Route::apiResource('task', TaskController::class)->middleware('auth:sanctum'); // Task Api

Route::post('/register', [AuthController::class, 'register']); // Register User Api
Route::get('/login', [AuthController::class, 'login']); // Login User Api
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Login User Api