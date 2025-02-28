<?php

use Illuminate\Support\Facades\Route;



Route::get('/', [ \App\Http\Controllers\UserController::class, 'loginPage']);
Route::get('/dashboard', [ \App\Http\Controllers\DashboardController::class,'dashboardPage']);


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

//    Route::get('/dashboard', [ \App\Http\Controllers\DashboardController::class,'dashboardPage']);









});
