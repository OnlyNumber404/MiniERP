<?php

use App\Http\Controllers\AuthControler;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',fn() => view('dashboard'));
Route::get('/login',fn() => view('auth/login'))->name('login');
Route::post('/login', [AuthControler::class,'login']);