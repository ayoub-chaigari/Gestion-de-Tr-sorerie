<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreOutgoingChequeRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'contact_id' => 'required|exists:contacts,id',
            'cheque_book_id' => 'required|exists:cheque_books,id',
            'amount' => 'required|numeric',
        ];
    }
}