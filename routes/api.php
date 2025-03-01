<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup', [UserController::class, 'signUp']);
Route::post('/login', [UserController::class, 'login']);


//Route::post('/send-reset-code', [UserController::class, 'sendResetCode']);
//Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
//Route::post('/reset-password', [UserController::class, 'resetPassword']);
