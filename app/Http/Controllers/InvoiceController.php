<?php
namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Request;

class InvoiceController extends Controller {
    public function index() {
        return InvoiceResource::collection(Invoice::all());
    }
    public function store(StoreInvoiceRequest $request) {
        $data = $request->validated(); 
        $data["due_date"] = date("Y-m-d", strtotime($data["invoice_date"] . " + " . $data["delay_days"] . " days"));
        unset($data["delay_days"]);
        $invoice = Invoice::create($data); return new InvoiceResource($invoice);
    }
    public function show(Invoice $invoice) {
        return new InvoiceResource($invoice);
    }
    public function update(UpdateInvoiceRequest $request, Invoice $invoice) {
        $invoice->update($request->validated()); return new InvoiceResource($invoice);
    }
    public function destroy(Invoice $invoice) {
        $invoice->delete(); return response()->noContent();
    }
    
}