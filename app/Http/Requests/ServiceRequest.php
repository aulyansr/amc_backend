<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
			'name' => 'required',
			'description' => 'required',
			'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048', // maximum size in kilobytes (2 MB = 2048 KB)
        ];
    }
}
