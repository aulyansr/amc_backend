<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TechnicianRequest extends FormRequest
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
                'technician_level_id' => 'required',
                'nik' => 'required',
                'fullname' => 'required',
                'no_hp' => 'required',
                'gender' => 'required',
                'birthdate' => 'required',
                'join_date' => 'required',
                'email' => 'required',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
    }
}
