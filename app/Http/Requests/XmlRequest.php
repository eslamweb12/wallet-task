<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XmlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string',
            'sender_account' => 'required|string',
            'receiver_bank_code' => 'required|string',
            'receiver_account' => 'required|string',
            'receiver_name' => 'required|string',
            'notes' => 'nullable|array',
            'payment_type' => 'nullable|integer',
            'charge_details' => 'nullable|string',
        ];
    }
}
