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
    
    // About Us Route
    Route::get('/about_us', function () {
        return view('about_us');
    })->name('about_us');
    
    // Services Route
    Route::get('/services', function () {
        return view('services');
    })->name('services');
    
    // Contact Route
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

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