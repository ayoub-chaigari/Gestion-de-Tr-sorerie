<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreBankAccountRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'bank_name' => 'required|string|max:255',
            'agency' => 'nullable|string',
            'rib' => 'required|string|size:24',
        ];
    }
}