<?php

use App\Http\Controllers\AuthControler;
use Illuminate\Support\Facades\Route;

//dashboard
Route::get('/', function () {
    return view('dashboard');
});

//Transaksi
Route::get('/transaction',fn()=> view('transaksi'));

//Kategory
Route::get('/category',fn()=> view('kategori'));

// Auth routes
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthControler::class, 'login']);

Route::get('/register', [AuthControler::class, 'register'])->name('register');
Route::post('/register', [AuthControler::class, 'register']);