<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreIncomingChequeRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'contact_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric',
            'cheque_number' => 'required|string',
            'due_date' => 'required|date',
        ];
    }
}