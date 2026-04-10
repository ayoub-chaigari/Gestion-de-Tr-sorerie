<?php

$dir = __DIR__;

function writeController($name, $modelName, $modelVar, $listCode, $storeCode, $updateCode, $deleteCode, $extraMethods = '') {
    global $dir;
    $resourceName = $modelName . 'Resource';
    $code = <<<PHP
<?php
namespace App\Http\Controllers;
use App\Models\\$modelName;
use App\Http\Requests\Store{$modelName}Request;
use App\Http\Requests\Update{$modelName}Request;
use App\Http\Resources\\$resourceName;
use Illuminate\Http\Request;

class {$name} extends Controller {
    public function index() {
        $listCode
    }
    public function store(Store{$modelName}Request \$request) {
        $storeCode
    }
    public function show($modelName \$$modelVar) {
        return new $resourceName(\$$modelVar);
    }
    public function update(Update{$modelName}Request \$request, $modelName \$$modelVar) {
        $updateCode
    }
    public function destroy($modelName \$$modelVar) {
        $deleteCode
    }
    $extraMethods
}
PHP;
    file_put_contents("$dir/app/Http/Controllers/$name.php", $code);
}

function writeRequest($name, $rulesCode) {
    global $dir;
    $code = <<<PHP
<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class {$name} extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
$rulesCode
        ];
    }
}
PHP;
    file_put_contents("$dir/app/Http/Requests/$name.php", $code);
}

function writeResource($name) {
    global $dir;
    $code = <<<PHP
<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class {$name} extends JsonResource {
    public function toArray(Request \$request): array {
        return parent::toArray(\$request);
    }
}
PHP;
    file_put_contents("$dir/app/Http/Resources/$name.php", $code);
}

$resources = ['Company', 'User', 'Contact', 'BankAccount', 'ChequeBook', 'IncomingCheque', 'OutgoingCheque', 'Invoice', 'Rejection', 'Transaction'];
foreach ($resources as $res) { writeResource("{$res}Resource"); }

// Company
writeRequest('StoreCompanyRequest', "            'name' => 'required|string|max:255',\n            'status' => 'nullable|in:active,suspended',");
writeRequest('UpdateCompanyRequest', "            'name' => 'sometimes|string|max:255',\n            'status' => 'sometimes|in:active,suspended',");
writeController('CompanyController', 'Company', 'company',
    "return CompanyResource::collection(Company::all());",
    "\$company = Company::create(\$request->validated()); return new CompanyResource(\$company);",
    "\$company->update(\$request->validated()); return new CompanyResource(\$company);",
    "\$company->delete(); return response()->noContent();",
    "public function activate(Company \$company) { \$company->update(['status' => 'active']); return new CompanyResource(\$company); }\n    public function suspend(Company \$company) { \$company->update(['status' => 'suspended']); return new CompanyResource(\$company); }"
);

// User
writeRequest('StoreUserRequest', "            'name' => 'required|string|max:255',\n            'email' => 'required|email|unique:users,email',\n            'password' => 'required|string|min:6',\n            'role' => 'required|in:SUPER_ADMIN,ADMIN,ACCOUNTANT',");
writeRequest('UpdateUserRequest', "            'name' => 'sometimes|string|max:255',\n            'email' => 'sometimes|email',\n            'role' => 'sometimes|in:SUPER_ADMIN,ADMIN,ACCOUNTANT',");
writeController('UserController', 'User', 'user',
    "return UserResource::collection(User::all());",
    "\$data = \$request->validated(); \$data['password'] = bcrypt(\$data['password']); \$user = User::create(\$data); return new UserResource(\$user);",
    "\$data = \$request->validated(); if(isset(\$data['password'])) \$data['password'] = bcrypt(\$data['password']); \$user->update(\$data); return new UserResource(\$user);",
    "\$user->delete(); return response()->noContent();"
);

// Contact
writeRequest('StoreContactRequest', "            'type' => 'required|in:client,supplier',\n            'name' => 'required|string|max:255',\n            'phone' => 'nullable|string',\n            'address' => 'nullable|string',\n            'ice' => 'nullable|string|size:15',\n            'if' => 'nullable|string|max:9',\n            'rc' => 'nullable|string',");
writeRequest('UpdateContactRequest', "            'type' => 'sometimes|in:client,supplier',\n            'name' => 'sometimes|string|max:255',\n            'phone' => 'nullable|string',\n            'address' => 'nullable|string',\n            'ice' => 'nullable|string|size:15',\n            'if' => 'nullable|string|max:9',\n            'rc' => 'nullable|string',");
writeController('ContactController', 'Contact', 'contact',
    "return ContactResource::collection(Contact::all());",
    "\$contact = Contact::create(\$request->validated()); return new ContactResource(\$contact);",
    "\$contact->update(\$request->validated()); return new ContactResource(\$contact);",
    "\$contact->delete(); return response()->noContent();"
);

// BankAccount
writeRequest('StoreBankAccountRequest', "            'bank_name' => 'required|string|max:255',\n            'agency' => 'nullable|string',\n            'rib' => 'required|string|size:24',");
writeRequest('UpdateBankAccountRequest', "            'bank_name' => 'sometimes|string|max:255',\n            'agency' => 'nullable|string',\n            'rib' => 'sometimes|string|size:24',");
writeController('BankAccountController', 'BankAccount', 'bankAccount',
    "return BankAccountResource::collection(BankAccount::all());",
    "\$account = BankAccount::create(\$request->validated()); return new BankAccountResource(\$account);",
    "\$bankAccount->update(\$request->validated()); return new BankAccountResource(\$bankAccount);",
    "\$bankAccount->delete(); return response()->noContent();"
);

// ChequeBook
writeRequest('StoreChequeBookRequest', "            'bank_account_id' => 'required|exists:bank_accounts,id',\n            'start_number' => 'required|integer',\n            'end_number' => 'required|integer|gt:start_number',");
writeRequest('UpdateChequeBookRequest', "            'bank_account_id' => 'sometimes|exists:bank_accounts,id',\n            'start_number' => 'sometimes|integer',\n            'end_number' => 'sometimes|integer',");
writeController('ChequeBookController', 'ChequeBook', 'chequeBook',
    "return ChequeBookResource::collection(ChequeBook::all());",
    "\$data = \$request->validated(); \$data['current_number'] = \$data['start_number']; \$book = ChequeBook::create(\$data); return new ChequeBookResource(\$book);",
    "\$chequeBook->update(\$request->validated()); return new ChequeBookResource(\$chequeBook);",
    "\$chequeBook->delete(); return response()->noContent();"
);

// IncomingCheque
writeRequest('StoreIncomingChequeRequest', "            'contact_id' => 'required|exists:contacts,id',\n            'amount' => 'required|numeric',\n            'cheque_number' => 'required|string',\n            'due_date' => 'required|date',");
writeRequest('UpdateIncomingChequeRequest', "            'contact_id' => 'sometimes|exists:contacts,id',\n            'amount' => 'sometimes|numeric',\n            'cheque_number' => 'sometimes|string',\n            'due_date' => 'sometimes|date',");
writeController('IncomingChequeController', 'IncomingCheque', 'incomingCheque',
    "return IncomingChequeResource::collection(IncomingCheque::all());",
    "\$cheque = IncomingCheque::create(\$request->validated()); return new IncomingChequeResource(\$cheque);",
    "\$incomingCheque->update(\$request->validated()); return new IncomingChequeResource(\$incomingCheque);",
    "\$incomingCheque->delete(); return response()->noContent();",
    "public function updateStatus(Request \$request, IncomingCheque \$incomingCheque) { \n        \$request->validate(['status' => 'required|in:pending,deposited,paid,unpaid,endorsed', 'bank_account_id' => 'nullable|exists:bank_accounts,id']);\n        \$incomingCheque->update(\$request->only(['status', 'bank_account_id'])); return new IncomingChequeResource(\$incomingCheque);\n    }\n    public function endorse(Request \$request, IncomingCheque \$incomingCheque) {\n        \$request->validate(['supplier_id' => 'required|exists:contacts,id']);\n        \$incomingCheque->update(['status' => 'endorsed']);\n        return response()->json(['message' => 'Cheque endorsed successfully']);\n    }"
);

// OutgoingCheque
writeRequest('StoreOutgoingChequeRequest', "            'contact_id' => 'required|exists:contacts,id',\n            'cheque_book_id' => 'required|exists:cheque_books,id',\n            'amount' => 'required|numeric',");
writeRequest('UpdateOutgoingChequeRequest', "            'contact_id' => 'sometimes|exists:contacts,id',\n            'cheque_book_id' => 'sometimes|exists:cheque_books,id',\n            'amount' => 'sometimes|numeric',");
writeController('OutgoingChequeController', 'OutgoingCheque', 'outgoingCheque',
    "return OutgoingChequeResource::collection(OutgoingCheque::all());",
    '$data = $request->validated(); 
        $book = \App\Models\ChequeBook::findOrFail($data["cheque_book_id"]); 
        $data["cheque_number"] = str_pad($book->current_number++, 8, "0", STR_PAD_LEFT); 
        $book->save(); 
        $cheque = OutgoingCheque::create($data); 
        return new OutgoingChequeResource($cheque);',
    "\$outgoingCheque->update(\$request->validated()); return new OutgoingChequeResource(\$outgoingCheque);",
    "// Should likely not delete issued cheques easily, but adding for completeness.\n        \$outgoingCheque->delete(); return response()->noContent();"
);

// Invoice
writeRequest('StoreInvoiceRequest', "            'supplier_id' => 'required|exists:contacts,id',\n            'amount' => 'required|numeric',\n            'invoice_date' => 'required|date',\n            'delay_days' => 'required|integer|min:0', // Used to auto-calculate due_date");
writeRequest('UpdateInvoiceRequest', "            'supplier_id' => 'sometimes|exists:contacts,id',\n            'amount' => 'sometimes|numeric',\n            'invoice_date' => 'sometimes|date',\n            'status' => 'sometimes|in:pending,paid,overdue',");
writeController('InvoiceController', 'Invoice', 'invoice',
    "return InvoiceResource::collection(Invoice::all());",
    '$data = $request->validated(); 
        $data["due_date"] = date("Y-m-d", strtotime($data["invoice_date"] . " + " . $data["delay_days"] . " days"));
        unset($data["delay_days"]);
        $invoice = Invoice::create($data); return new InvoiceResource($invoice);',
    "\$invoice->update(\$request->validated()); return new InvoiceResource(\$invoice);",
    "\$invoice->delete(); return response()->noContent();"
);

// Rejection
writeRequest('StoreRejectionRequest', "            'cheque_id' => 'required|integer',\n            'type' => 'required|in:incoming,outgoing',\n            'reason' => 'required|string',");
writeRequest('UpdateRejectionRequest', "            'reason' => 'sometimes|string',\n            'resolved' => 'sometimes|boolean',");
writeController('RejectionController', 'Rejection', 'rejection',
    "return RejectionResource::collection(Rejection::all());",
    "\$rejection = Rejection::create(\$request->validated()); return new RejectionResource(\$rejection);",
    "\$rejection->update(\$request->validated()); return new RejectionResource(\$rejection);",
    "\$rejection->delete(); return response()->noContent();",
    "public function resolve(Rejection \$rejection) { \$rejection->update(['resolved' => true]); return new RejectionResource(\$rejection); }\n    public function toLitigation(Rejection \$rejection) { \$rejection->update(['sent_to_litigation' => true]); return new RejectionResource(\$rejection); }"
);

echo "CRUD Controllers setup complete.\n";

