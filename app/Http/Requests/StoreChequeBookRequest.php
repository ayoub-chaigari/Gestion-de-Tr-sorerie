<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreChequeBookRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer|gt:start_number',
        ];
    }
}