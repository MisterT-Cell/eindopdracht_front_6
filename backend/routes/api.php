<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AfspraakController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/afspraken', [AfspraakController::class, 'store']);


Route::middleware(\App\Http\Middleware\TokenAuth::class)->group(function () {
    Route::get('/afspraken', [AfspraakController::class, 'index']);
    Route::get('/afspraken/{id}', [AfspraakController::class, 'show']);
    Route::put('/afspraken/{id}', [AfspraakController::class, 'update']);
    Route::delete('/afspraken/{id}', [AfspraakController::class, 'destroy']);
});