<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return
        [
			'branch_id' => 'required',
			'shift_id' => 'required',
			'nama' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'branch_id.required' => 'Cabang tidak boleh kosong!',
            'shift_id.required' => 'Shift tidak boleh kosong!',
            'required' => ':attribute tidak boleh kosong!',
            'numeric' => ':attribute harus angka!',
        ];
    }
}
