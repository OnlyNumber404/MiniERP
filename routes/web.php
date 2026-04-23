<?php

use App\Http\Controllers\AuthControler;
use Illuminate\Support\Facades\Route;

// dashboard
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Transaksi
Route::get('/transaction', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');

// Kategory
Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');

// Auth routes
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthControler::class, 'login']);

Route::get('/register', [AuthControler::class, 'register'])->name('register');
Route::post('/register', [AuthControler::class, 'register']);
