<?php
$dir = __DIR__;

// 1. Role Middleware
$roleMw = <<<PHP
<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware {
    public function handle(Request \$request, Closure \$next, ...\$roles): Response {
        if (!\$request->user() || !in_array(\$request->user()->role, \$roles)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return \$next(\$request);
    }
}
PHP;
file_put_contents("$dir/app/Http/Middleware/RoleMiddleware.php", $roleMw);

$appPhp = file_get_contents("$dir/bootstrap/app.php");
if (!str_contains($appPhp, "\$middleware->alias")) {
    $appPhp = str_replace(
        "->withMiddleware(function (Middleware \$middleware): void {",
        "->withMiddleware(function (Middleware \$middleware): void {\n        \$middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);",
        $appPhp
    );
    file_put_contents("$dir/bootstrap/app.php", $appPhp);
}

// 2. Auth Controller
$authCtrl = <<<PHP
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller {
    public function login(Request \$request) {
        \$request->validate(['email' => 'required|email', 'password' => 'required']);
        \$user = User::where('email', \$request->email)->first();
        if (!\$user || !Hash::check(\$request->password, \$user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return response()->json([
            'token' => \$user->createToken('auth_token')->plainTextToken,
            'user' => \$user
        ]);
    }
    public function register(Request \$request) {
        \$request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);
        \$company = \App\Models\Company::create(['name' => \$request->name . ' Company']);
        \$user = User::create([
            'company_id' => \$company->id,
            'name' => \$request->name,
            'email' => \$request->email,
            'password' => Hash::make(\$request->password),
            'role' => 'SUPER_ADMIN'
        ]);
        return response()->json([
            'token' => \$user->createToken('auth_token')->plainTextToken,
            'user' => \$user
        ]);
    }
    public function logout(Request \$request) {
        \$request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
    public function me(Request \$request) {
        return response()->json(\$request->user()->load('company'));
    }
}
PHP;
file_put_contents("$dir/app/Http/Controllers/AuthController.php", $authCtrl);

// Dashboard Controller
$dashCtrl = <<<PHP
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\IncomingCheque;
use App\Models\OutgoingCheque;
use App\Models\Invoice;

class DashboardController extends Controller {
    public function summary() {
        \$incoming = IncomingCheque::sum('amount');
        \$outgoing = OutgoingCheque::sum('amount');
        \$invoices = Invoice::sum('amount');
        return response()->json(compact('incoming', 'outgoing', 'invoices'));
    }
    public function alerts() {
        \$overdueInvoices = Invoice::where('status', 'overdue')->get();
        \$unpaidCheques = IncomingCheque::where('status', 'unpaid')->get();
        return response()->json([
            'overdue_invoices' => \$overdueInvoices,
            'unpaid_cheques' => \$unpaidCheques
        ]);
    }
}
PHP;
file_put_contents("$dir/app/Http/Controllers/DashboardController.php", $dashCtrl);

// Routing api.php
$routes = <<<PHP
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

Route::middleware('auth:sanctum')->group(function () {
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
PHP;
file_put_contents("$dir/routes/api.php", $routes);

echo "API base logic setup.\n";
