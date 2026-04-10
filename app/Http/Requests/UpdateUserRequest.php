<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'role' => 'sometimes|in:SUPER_ADMIN,ADMIN,ACCOUNTANT',
        ];
    }
}