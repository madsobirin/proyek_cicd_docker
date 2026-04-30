<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthApiController::class, 'login']);
Route::post('/auth/register', [AuthApiController::class, 'register']);
// Route::get('/menu', [MenuApiController::class, 'index']);
Route::post('/auth/google', [GoogleController::class, 'loginWithGoogle']);
