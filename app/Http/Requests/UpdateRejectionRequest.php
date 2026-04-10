<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRejectionRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'reason' => 'sometimes|string',
            'resolved' => 'sometimes|boolean',
        ];
    }
}