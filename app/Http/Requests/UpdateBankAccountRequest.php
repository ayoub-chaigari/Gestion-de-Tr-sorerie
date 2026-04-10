<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBankAccountRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'bank_name' => 'sometimes|string|max:255',
            'agency' => 'nullable|string',
            'rib' => 'sometimes|string|size:24',
        ];
    }
}