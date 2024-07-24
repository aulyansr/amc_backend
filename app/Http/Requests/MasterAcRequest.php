<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterAcRequest extends FormRequest
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
        return [
            'brand' => 'required',
            'ac_name' => 'required',
            'model' => 'required',
            'pk' => 'required',
            'is_inverter' => 'required',
            'freon_type' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong!',
            'numeric' => ':attribute harus angka!',
        ];
    }
}
