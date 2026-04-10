<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ChequeBookController;
use App\Http\Controllers\IncomingChequeController;
use App\Http\Controllers\OutgoingChequeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RejectionController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::name('api.')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::middleware('role:SUPER_ADMIN')->group(function () {
        Route::apiResource('companies', CompanyController::class);
        Route::patch('/companies/{company}/activate', [CompanyController::class, 'activate']);
        Route::patch('/companies/{company}/suspend', [CompanyController::class, 'suspend']);
    });

    Route::middleware('role:SUPER_ADMIN,ADMIN')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('bank-accounts', BankAccountController::class);
    Route::apiResource('cheque-books', ChequeBookController::class);
    
    Route::apiResource('incoming-cheques', IncomingChequeController::class);
    Route::patch('/incoming-cheques/{incoming_cheque}/status', [IncomingChequeController::class, 'updateStatus']);
    Route::post('/incoming-cheques/{incoming_cheque}/endorse', [IncomingChequeController::class, 'endorse']);

    Route::apiResource('outgoing-cheques', OutgoingChequeController::class);
    
    Route::apiResource('invoices', InvoiceController::class);
    
    Route::apiResource('rejections', RejectionController::class);
    Route::patch('/rejections/{rejection}/resolve', [RejectionController::class, 'resolve']);
    Route::patch('/rejections/{rejection}/to-litigation', [RejectionController::class, 'toLitigation']);

    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('/dashboard/alerts', [DashboardController::class, 'alerts']);
});