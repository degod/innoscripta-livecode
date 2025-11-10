<?php

use App\Http\Controllers\Transaction\CreateController;
use App\Http\Controllers\Transaction\DeleteController;
use App\Http\Controllers\Transaction\FetchController;
use App\Http\Controllers\Transaction\UpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/transactions', FetchController::class)->name('transactions.fetch');
Route::post('/transaction/create', CreateController::class)->name('transactions.create');
Route::put('/transaction/update', UpdateController::class)->name('transactions.update');
Route::delete('/transaction/delete', DeleteController::class)->name('transactions.delete');
