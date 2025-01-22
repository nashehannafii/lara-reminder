<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});
  
Route::get('/send-halo/{code}', [MessageController::class, 'sendHaloToAll']);
Route::get('/send-pagi/{code}', [MessageController::class, 'sendPagi']);
Route::get('/send-sore/{code}', [MessageController::class, 'sendSore']);
Route::post('/register', [AuthController::class, 'register']);  
Route::post('/verify', [AuthController::class, 'verify']);  