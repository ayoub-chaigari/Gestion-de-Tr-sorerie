<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'supplier_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric',
            'invoice_date' => 'required|date',
            'delay_days' => 'required|integer|min:0', // Used to auto-calculate due_date
        ];
    }
}