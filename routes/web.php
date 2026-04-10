<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\TreasuryController;
use App\Http\Controllers\Web\ChequeController;
use App\Http\Controllers\Web\CompanyAdminController;

use App\Http\Controllers\Web\AuthController;

Route::get('/', function () { 
    return redirect()->route('login'); 
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\Web\UserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('contacts', ContactController::class);
    Route::resource('invoices', \App\Http\Controllers\Web\InvoiceController::class);
    Route::post('/invoices/{invoice}/payments', [\App\Http\Controllers\Web\InvoicePaymentController::class, 'store'])->name('invoices.payments.store');
    Route::delete('/payments/{payment}', [\App\Http\Controllers\Web\InvoicePaymentController::class, 'destroy'])->name('invoices.payments.destroy');
    
    // Treasury (Bank Accounts & ChequeBooks) & Team Management - Restricted to ADMIN
    Route::middleware(['role:ADMIN,SUPER_ADMIN'])->group(function () {
        Route::get('/treasury', [\App\Http\Controllers\Web\TreasuryController::class, 'index'])->name('bank-accounts.index');
        Route::post('/bank-accounts', [\App\Http\Controllers\Web\TreasuryController::class, 'storeAccount'])->name('bank-accounts.store');
        Route::delete('/bank-accounts/{bankAccount}', [\App\Http\Controllers\Web\TreasuryController::class, 'destroyAccount'])->name('bank-accounts.destroy');
        Route::post('/cheque-books', [\App\Http\Controllers\Web\TreasuryController::class, 'storeChequeBook'])->name('cheque-books.store');
        Route::delete('/cheque-books/{chequeBook}', [\App\Http\Controllers\Web\TreasuryController::class, 'destroyChequeBook'])->name('cheque-books.destroy');
        Route::resource('users', UserController::class);
        
        // Audit Logs
        Route::get('/audit-logs', [\App\Http\Controllers\Web\ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

    // Incoming Cheques
    Route::resource('cheques', ChequeController::class);
    Route::patch('/cheques/{id}/status', [ChequeController::class, 'updateStatus'])->name('cheques.status');
    Route::patch('/cheques/{id}/endorse', [ChequeController::class, 'endorse'])->name('cheques.endorse');

    // Outgoing Cheques (Carnet logic)
    Route::resource('outgoing-cheques', \App\Http\Controllers\Web\OutgoingChequeController::class);
    Route::patch('/outgoing-cheques/{id}/status', [\App\Http\Controllers\Web\OutgoingChequeController::class, 'updateStatus'])->name('outgoing-cheques.status');

    // Remittances (Bordereaux)
    Route::resource('remittances', \App\Http\Controllers\Web\RemittanceController::class);
    Route::get('/remittances/{remittance}/bank-export', [\App\Http\Controllers\Web\RemittanceController::class, 'bankExport'])->name('remittances.bank-export');
    Route::post('/remittances/generate', [\App\Http\Controllers\Web\RemittanceController::class, 'generate'])->name('remittances.generate');

    // Rejections (Litigation)
    Route::get('/rejections', [\App\Http\Controllers\Web\RejectionController::class, 'index'])->name('rejections.index');
    Route::post('/rejections/create/{chequeId}', [\App\Http\Controllers\Web\RejectionController::class, 'createFromCheque'])->name('rejections.create');
    Route::patch('/rejections/{rejection}/litigation', [\App\Http\Controllers\Web\RejectionController::class, 'toggleLitigation'])->name('rejections.litigation');
    Route::patch('/rejections/{rejection}/resolve', [\App\Http\Controllers\Web\RejectionController::class, 'resolve'])->name('rejections.resolve');

    // Exports
    Route::get('/exports/print', [\App\Http\Controllers\Web\ExportController::class, 'printReport'])->name('exports.print');
    Route::get('/exports/json', [\App\Http\Controllers\Web\ExportController::class, 'exportJson'])->name('exports.json');
    Route::get('/exports/csv', [\App\Http\Controllers\Web\ExportController::class, 'exportCsv'])->name('exports.csv');

    // Super Admin Activation
    Route::middleware('role:SUPER_ADMIN')->group(function () {
        Route::get('/companies', [CompanyAdminController::class, 'index'])->name('companies.index');
        Route::patch('/companies/{company}/activate', [CompanyAdminController::class, 'activate'])->name('companies.activate');
        Route::patch('/companies/{company}/suspend', [CompanyAdminController::class, 'suspend'])->name('companies.suspend');
    });
});
