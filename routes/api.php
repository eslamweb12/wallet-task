<?php

use App\Http\Resources\User\RegisterResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    Route::post('/webhook/send', [\App\Http\Controllers\Payment\WebhookController::class, 'send']);

Route::get('/webhook/recive', [\App\Http\Controllers\Payment\WebhookController::class, 'receive']);

Route::post('/register', [\App\Http\Controllers\User\UserController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\User\UserController::class, 'login']);
