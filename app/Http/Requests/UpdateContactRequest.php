<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'type' => 'sometimes|in:client,supplier',
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'ice' => 'nullable|string|size:15',
            'if' => 'nullable|string|max:9',
            'rc' => 'nullable|string',
        ];
    }
}