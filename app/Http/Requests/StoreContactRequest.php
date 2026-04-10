<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'type' => 'required|in:client,supplier',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'ice' => 'nullable|string|size:15',
            'if' => 'nullable|string|max:9',
            'rc' => 'nullable|string',
        ];
    }
}