<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'supplier_id' => 'sometimes|exists:contacts,id',
            'amount' => 'sometimes|numeric',
            'invoice_date' => 'sometimes|date',
            'status' => 'sometimes|in:pending,paid,overdue',
        ];
    }
}