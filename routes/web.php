<?php

use App\Http\Controllers\AuthControler;
use Illuminate\Support\Facades\Route;

// dashboard
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Transaksi
Route::get('/transaction', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
Route::get('/transaction/{transaction}', [\App\Http\Controllers\TransactionController::class, 'show'])->name('transaction.show');
Route::get('/transaction/{transaction}/file', [\App\Http\Controllers\TransactionController::class, 'file'])->name('transaction.file');
Route::post('/transaction', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
Route::delete('/transaction/{transaction}', [App\Http\Controllers\TransactionController::class, 'delete'])->name('transaction.delete');

// Kategory
Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
Route::post('/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');

// Report
Route::get('/report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
Route::get('/report/pdf', [\App\Http\Controllers\ReportController::class, 'pdf'])->name('report.pdf');

// Auth routes
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthControler::class, 'login']);

Route::get('/register', [AuthControler::class, 'register'])->name('register');
Route::post('/register', [AuthControler::class, 'register']);

Route::post('/logout', [AuthControler::class, 'logout'])->name('logout');

// Analisa
Route::get('/analisa', [\App\Http\Controllers\AnalisaController::class, 'index'])->name('analisa.index');
Route::post('/analisa', [\App\Http\Controllers\AnalisaController::class, 'updateAmount'])->name('analisa.update');
Route::post('/analisa/favorite', [\App\Http\Controllers\AnalisaController::class, 'addFavorite'])->name('analisa.favorite.add');
Route::delete('/analisa/favorite/{id}', [\App\Http\Controllers\AnalisaController::class, 'removeFavorite'])->name('analisa.favorite.remove');
