<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/show-user', [UserController::class,'show'])->name('show');
Route::post('/store', [UserController::class, 'store'])->name('store');
Route::get('/export-csv', [UserController::class, 'exportCSV'])->name('export.csv');
Route::post('/import-csv', [UserController::class, 'importCSV'])->name('import.csv');
Route::get('/edit/{id}', [UserController::class,'edit'])->name('edit');
Route::post('/update/{id}', [UserController::class,'update'])->name('update');
Route::get('/delete/{id}', [UserController::class,'delete'])->name('delete');
