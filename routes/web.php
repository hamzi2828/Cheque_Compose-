<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PayeeController;
use App\Http\Controllers\SiteSettingController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/cheques');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('banks', BankController::class)->except(['show']);
    Route::get('banks/{bank}/next-cheque-number', [BankController::class, 'nextChequeNumber'])
         ->name('banks.next-cheque-number');

    Route::resource('clients', ClientController::class)->except(['show']);

    Route::resource('payees', PayeeController::class)->except(['show']);

    Route::resource('cheques', ChequeController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('cheques/{cheque}/pdf', [ChequeController::class, 'pdf'])->name('cheques.pdf');

    Route::get('settings', [SiteSettingController::class, 'create'])->name('settings.create');
    Route::post('settings', [SiteSettingController::class, 'store'])->name('settings.store');
});
