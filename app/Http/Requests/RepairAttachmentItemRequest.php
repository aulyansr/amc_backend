<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepairAttachmentItemRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|max:2048', // maximum size in kilobytes (2 MB = 2048 KB)
        ];
    }
}
