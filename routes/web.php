<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/cheques');

Route::resource('banks', BankController::class)->except(['show']);
Route::get('banks/{bank}/next-cheque-number', [BankController::class, 'nextChequeNumber'])
     ->name('banks.next-cheque-number');

Route::resource('clients', ClientController::class)->except(['show']);

Route::resource('cheques', ChequeController::class)->only(['index', 'create', 'store', 'destroy']);
Route::get('cheques/{cheque}/pdf', [ChequeController::class, 'pdf'])->name('cheques.pdf');
