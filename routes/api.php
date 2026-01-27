<?php

use App\Http\Resources\User\RegisterResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/webhook/send', [\App\Http\Controllers\Payment\WebhookController::class, 'send']);
});
Route::get('/register', [\App\Http\Controllers\User\UserController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\User\UserController::class, 'login']);
