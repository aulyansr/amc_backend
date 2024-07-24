<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
			'booked_date' => 'required',
			'branch_id' => 'required',
			'master_address_id' => 'required',
			'master_customer_id' => 'required',
			'total_ac' => 'required',
			'sub_total_service' => 'required',
			'reason' => 'required',
			'location_range' => 'required',
			'transport_fee' => 'required',
			// 'sub_total' => 'required',
			'diskon' => 'required',
			'grand_total' => 'required',
            'services' => 'required|array',

        ];
    }
}
