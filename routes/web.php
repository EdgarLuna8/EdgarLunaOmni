<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');



Route::middleware('auth')->group(function () {
    Route::post('/home/create', [HomeController::class, 'create'])->name('save');
    Route::post('/home/update', [HomeController::class, 'update'])->name('update');
    Route::post('/employees/{id}/activate', [HomeController::class, 'activate'])->name('employees.activate');
    Route::post('/employees/{id}/deactivate', [HomeController::class, 'deactivate'])->name('employees.deactivate');
    Route::delete('/employees/{id}/delete', [HomeController::class, 'delete'])->name('employees.delete');
});

require __DIR__ . '/auth.php';
