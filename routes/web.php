<?php

use App\Http\Controllers\AuthControler;
use Illuminate\Support\Facades\Route;

// dashboard
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Transaksi
Route::get('/transaction', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
Route::delete('/transaction/{transaction}',[App\Http\Controllers\TransactionController::class,'delete'])->name('transaction.delete');

// Kategory
Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');

// Auth routes
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthControler::class, 'login']);

Route::get('/register', [AuthControler::class, 'register'])->name('register');
Route::post('/register', [AuthControler::class, 'register']);

Route::post('/logout', [AuthControler::class, 'logout'])->name('logout');

// Analisa
Route::get('/analisa', [\App\Http\Controllers\AnalisaController::class, 'index'])->name('analisa.index');