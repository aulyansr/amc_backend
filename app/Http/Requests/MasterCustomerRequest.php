<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MasterCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $customerId = $this->route('masterCustomer'); // Assuming 'customer' is the parameter name in your route

        return [
            'phone' => [
                'required',
                'numeric',
                Rule::unique('master_customers')->where(function ($query) use ($customerId) {
                    $query->whereNull('deleted_at')->orWhere('id', $customerId);
                })->ignore($customerId),
            ],
            'type' => 'required',
            'email' =>[
                'required',
                'email',
                Rule::unique('master_customers')->where(function ($query) use ($customerId) {
                    $query->whereNull('deleted_at')->orWhere('id', $customerId);
                })->ignore($customerId),
            ],

            // other validation rules
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong!',
            'numeric' => ':attribute harus angka!',
            'unique' => ':attribute Sudah Terdaftar'
        ];
    }
}
