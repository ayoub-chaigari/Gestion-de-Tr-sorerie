<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomingChequeRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'contact_id' => 'sometimes|exists:contacts,id',
            'amount' => 'sometimes|numeric',
            'cheque_number' => 'sometimes|string',
            'due_date' => 'sometimes|date',
        ];
    }
}