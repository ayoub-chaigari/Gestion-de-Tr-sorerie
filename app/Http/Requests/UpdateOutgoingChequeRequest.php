<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOutgoingChequeRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'contact_id' => 'sometimes|exists:contacts,id',
            'cheque_book_id' => 'sometimes|exists:cheque_books,id',
            'amount' => 'sometimes|numeric',
        ];
    }
}