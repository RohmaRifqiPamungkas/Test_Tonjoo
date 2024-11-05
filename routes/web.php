<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumbersController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('/auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // News Route
    Route::get('/news', function () {
        return view('news');
    })->name('news');
    
    // Pesanan Route
    Route::get('/pesanan', function () {
        return view('pesanan');
    })->name('pesanan');
    
    // Kontak Route
    Route::get('/kontak', function () {
        return view('kontak');
    })->name('kontak');

    // Transactions Routes - Using Route Resource
    Route::resource('transactions', TransactionController::class)->except(['show']);

    // Additional Route for Recap
    Route::get('/transactions/recap', [TransactionController::class, 'recap'])->name('transactions.recap');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

    Route::get('/transactions/fibonacci/{n1}/{n2}', [NumbersController::class, 'fibonacciSum'])->name('transactions.fibonacci');

    Route::get('/transactions/fibonacci', function () {
        return view('transactions.fibonacci');
    })->name('transactions.fibonacci.form');

    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});