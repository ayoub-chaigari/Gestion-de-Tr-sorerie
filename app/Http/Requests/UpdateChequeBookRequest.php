<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChequeBookRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'bank_account_id' => 'sometimes|exists:bank_accounts,id',
            'start_number' => 'sometimes|integer',
            'end_number' => 'sometimes|integer',
        ];
    }
}