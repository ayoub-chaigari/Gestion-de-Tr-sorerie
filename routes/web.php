<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\TreasuryController;
use App\Http\Controllers\Web\ChequeController;
use App\Http\Controllers\Web\CompanyAdminController;

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\EmailVerificationController;
use App\Http\Controllers\Web\PasswordResetController;
use App\Http\Controllers\Web\PublicContactController;

use App\Http\Controllers\LocaleController;

Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

Route::get('/', function () { 
    return view('pages.welcome'); 
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Public Landing Pages
Route::view('/contact', 'pages.contact')->name('contact');
Route::post('/contact', [PublicContactController::class, 'submit'])->name('contact.submit');
Route::view('/pricing', 'pages.pricing')->name('pricing');
Route::view('/features', 'pages.features')->name('features');
Route::view('/solutions', 'pages.solutions')->name('solutions');

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\Web\UserController;

Route::middleware(['auth'])->group(function () {
    Route::middleware('permission:dashboard,view')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Contacts - permission enforced per action type
    Route::middleware('permission:contacts,create')->group(function () {
        Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
        Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    });

    Route::middleware('permission:contacts,view')->group(function () {
        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    });

    Route::middleware('permission:contacts,edit')->group(function () {
        Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::patch('/contacts/{contact}', [ContactController::class, 'update']);
    });
    Route::middleware('permission:contacts,delete')->group(function () {
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    });

    // Invoices - permission enforced per action type
    Route::middleware('permission:invoices,create')->group(function () {
        Route::get('/invoices/create', [\App\Http\Controllers\Web\InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/invoices', [\App\Http\Controllers\Web\InvoiceController::class, 'store'])->name('invoices.store');
        Route::post('/invoices/{invoice}/payments', [\App\Http\Controllers\Web\InvoicePaymentController::class, 'store'])->name('invoices.payments.store');
    });

    Route::middleware('permission:invoices,view')->group(function () {
        Route::get('/invoices', [\App\Http\Controllers\Web\InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{invoice}', [\App\Http\Controllers\Web\InvoiceController::class, 'show'])->name('invoices.show');
    });
    Route::middleware('permission:invoices,delete')->group(function () {
        Route::delete('/payments/{payment}', [\App\Http\Controllers\Web\InvoicePaymentController::class, 'destroy'])->name('invoices.payments.destroy');
        Route::delete('/invoices/{invoice}', [\App\Http\Controllers\Web\InvoiceController::class, 'destroy'])->name('invoices.destroy');
    });

    // Cheques Recette - permission enforced per action type
    Route::middleware('permission:cheques,view')->group(function () {
        Route::get('/cheques', [ChequeController::class, 'index'])->name('cheques.index');
    });
    Route::middleware('permission:cheques,create')->group(function () {
        Route::get('/cheques/create', [ChequeController::class, 'create'])->name('cheques.create');
        Route::post('/cheques', [ChequeController::class, 'store'])->name('cheques.store');
        Route::patch('/cheques/{id}/status', [ChequeController::class, 'updateStatus'])->name('cheques.status');
        Route::patch('/cheques/{id}/endorse', [ChequeController::class, 'endorse'])->name('cheques.endorse');
    });

    // Outgoing Cheques - permission enforced per action type
    Route::middleware('permission:cheques,view')->group(function () {
        Route::get('/outgoing-cheques', [\App\Http\Controllers\Web\OutgoingChequeController::class, 'index'])->name('outgoing-cheques.index');
    });
    Route::middleware('permission:cheques,create')->group(function () {
        Route::get('/outgoing-cheques/create', [\App\Http\Controllers\Web\OutgoingChequeController::class, 'create'])->name('outgoing-cheques.create');
        Route::post('/outgoing-cheques', [\App\Http\Controllers\Web\OutgoingChequeController::class, 'store'])->name('outgoing-cheques.store');
        Route::patch('/outgoing-cheques/{id}/status', [\App\Http\Controllers\Web\OutgoingChequeController::class, 'updateStatus'])->name('outgoing-cheques.status');
    });

    // Remittances - permission enforced per action type
    Route::middleware('permission:remittances,create')->group(function () {
        Route::get('/remittances/create', [\App\Http\Controllers\Web\RemittanceController::class, 'create'])->name('remittances.create');
        Route::post('/remittances/generate', [\App\Http\Controllers\Web\RemittanceController::class, 'generate'])->name('remittances.generate');
    });

    Route::middleware('permission:remittances,view')->group(function () {
        Route::get('/remittances', [\App\Http\Controllers\Web\RemittanceController::class, 'index'])->name('remittances.index');
        Route::get('/remittances/{remittance}', [\App\Http\Controllers\Web\RemittanceController::class, 'show'])->name('remittances.show');
        Route::get('/remittances/{remittance}/bank-export', [\App\Http\Controllers\Web\RemittanceController::class, 'bankExport'])->name('remittances.bank-export');
    });

    // Rejections (Litigation) - visible to all logged-in users with VIEW permission
    Route::middleware('permission:rejections,view')->group(function () {
        Route::get('/rejections', [\App\Http\Controllers\Web\RejectionController::class, 'index'])->name('rejections.index');
        Route::post('/rejections/create/{chequeId}', [\App\Http\Controllers\Web\RejectionController::class, 'createFromCheque'])->name('rejections.create');
        Route::patch('/rejections/{rejection}/litigation', [\App\Http\Controllers\Web\RejectionController::class, 'toggleLitigation'])->name('rejections.litigation');
        Route::patch('/rejections/{rejection}/resolve', [\App\Http\Controllers\Web\RejectionController::class, 'resolve'])->name('rejections.resolve');
    });

    // Exports
    Route::get('/exports/print', [\App\Http\Controllers\Web\ExportController::class, 'printReport'])->name('exports.print');
    Route::get('/exports/json', [\App\Http\Controllers\Web\ExportController::class, 'exportJson'])->name('exports.json');
    Route::get('/exports/csv', [\App\Http\Controllers\Web\ExportController::class, 'exportCsv'])->name('exports.csv');

    // Treasury, Team Management, Audit Log — Restricted to ADMIN only
    Route::middleware(['role:ADMIN,SUPER_ADMIN'])->group(function () {
        Route::get('/treasury', [\App\Http\Controllers\Web\TreasuryController::class, 'index'])->name('bank-accounts.index');
        Route::post('/bank-accounts', [\App\Http\Controllers\Web\TreasuryController::class, 'storeAccount'])->name('bank-accounts.store');
        Route::delete('/bank-accounts/{bankAccount}', [\App\Http\Controllers\Web\TreasuryController::class, 'destroyAccount'])->name('bank-accounts.destroy');
        Route::post('/cheque-books', [\App\Http\Controllers\Web\TreasuryController::class, 'storeChequeBook'])->name('cheque-books.store');
        Route::delete('/cheque-books/{chequeBook}', [\App\Http\Controllers\Web\TreasuryController::class, 'destroyChequeBook'])->name('cheque-books.destroy');
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status-local', [\App\Http\Controllers\Web\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/audit-logs', [\App\Http\Controllers\Web\ActivityLogController::class, 'index'])->name('activity-logs.index');
        
        // Profile
        Route::get('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile.update');
    });

        // Support Center
        Route::get('/support', [\App\Http\Controllers\Web\SupportController::class, 'index'])->name('support.index');
        Route::get('/support/create', [\App\Http\Controllers\Web\SupportController::class, 'create'])->name('support.create');
        Route::post('/support', [\App\Http\Controllers\Web\SupportController::class, 'store'])->name('support.store');
        Route::get('/support/{id}', [\App\Http\Controllers\Web\SupportController::class, 'show'])->name('support.show');
        Route::get('/support/{id}/poll', [\App\Http\Controllers\Web\SupportController::class, 'getMessages'])->name('support.poll');
        Route::get('/support-unread-count', [\App\Http\Controllers\Web\SupportController::class, 'unreadCount'])->name('support.unread');
        Route::get('/notifications/latest', [\App\Http\Controllers\Web\SupportController::class, 'getLatestNotifications'])->name('notifications.latest');
        Route::patch('/notifications/{id}/read', [\App\Http\Controllers\Web\SupportController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/support/{id}/reply', [\App\Http\Controllers\Web\SupportController::class, 'reply'])->name('support.reply');


    // Super Admin Infrastructure & Governance
    Route::middleware('role:SUPER_ADMIN')->prefix('superadmin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Web\SuperAdmin\PlatformDashboardController::class, 'index'])->name('superadmin.dashboard');
        
        // Support Hub (Global)
        Route::get('/support-hub', [\App\Http\Controllers\Web\SuperAdmin\SupportHubController::class, 'index'])->name('superadmin.support.index');
        Route::get('/support-hub/{id}', [\App\Http\Controllers\Web\SuperAdmin\SupportHubController::class, 'show'])->name('superadmin.support.show');
        Route::get('/support-hub/{id}/poll', [\App\Http\Controllers\Web\SuperAdmin\SupportHubController::class, 'apiMessages'])->name('superadmin.support.poll');
        Route::post('/support-hub/{id}/reply', [\App\Http\Controllers\Web\SuperAdmin\SupportHubController::class, 'reply'])->name('superadmin.support.reply');
        Route::patch('/support-hub/{id}/close', [\App\Http\Controllers\Web\SuperAdmin\SupportHubController::class, 'close'])->name('superadmin.support.close');
        
        // Global Oversight (Bypass Tenant Scope)
        Route::get('/oversight/cheques', [\App\Http\Controllers\Web\SuperAdmin\GlobalOversightController::class, 'cheques'])->name('superadmin.oversight.cheques');
        Route::get('/oversight/invoices', [\App\Http\Controllers\Web\SuperAdmin\GlobalOversightController::class, 'invoices'])->name('superadmin.oversight.invoices');
        Route::get('/oversight/contacts', [\App\Http\Controllers\Web\SuperAdmin\GlobalOversightController::class, 'contacts'])->name('superadmin.oversight.contacts');
        
        // Company Management (Existing logic moved/referenced here)
        Route::get('/companies', [CompanyAdminController::class, 'index'])->name('companies.index');
        Route::patch('/companies/{company}/activate', [CompanyAdminController::class, 'activate'])->name('companies.activate');
        Route::patch('/companies/{company}/suspend', [CompanyAdminController::class, 'suspend'])->name('companies.suspend');
        Route::get('/companies/{company}/oversight', [CompanyAdminController::class, 'oversight'])->name('companies.oversight');
        Route::get('/companies/{company}/users', [CompanyAdminController::class, 'manageUsers'])->name('companies.users');
        Route::patch('/users/{user}/toggle-status', [CompanyAdminController::class, 'toggleUserStatus'])->name('companies.users.toggle');
    });

    // Email Verification (Authenticated but not necessarily verified)
    Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');
});

