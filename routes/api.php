<?php

use App\Http\Controllers\Transaction\FetchController;
use Illuminate\Support\Facades\Route;

Route::get('/transactions', FetchController::class)->name('transactions.fetch');
