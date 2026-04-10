<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreRejectionRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'cheque_id' => 'required|integer',
            'type' => 'required|in:incoming,outgoing',
            'reason' => 'required|string',
        ];
    }
}