<?php

use Illuminate\Support\Facades\Route;


//Route::get('/', [ \App\Http\Controllers\UserController::class, 'loginPage']);
//Route::post('/admin-login', [ \App\Http\Controllers\UserController::class, 'adminLogin'])->name('admin.login');

//Route::get('/', function () {
//    return view('auth.login');
//});

Route::get('/', [\App\Http\Controllers\UserController::class, 'showLoginForm']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'adminLogin'])->name('login');
Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');
Route::get('/signup',[\App\Http\Controllers\UserController::class,'showRegistration'])->name('signup');
Route::post('/signup', [\App\Http\Controllers\UserController::class, 'signup']);
//Route::get('/policy', [DashboardController::class, 'policy'])->name('policy');
//Route::get('/terms', [DashboardController::class, 'terms'])->name('terms');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [ \App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

    Route::get('/user-list', [ \App\Http\Controllers\UserController::class, 'userList'])->name('user.list');
});
