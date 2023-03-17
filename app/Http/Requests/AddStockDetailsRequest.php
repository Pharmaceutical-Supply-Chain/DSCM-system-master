<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddStockDetailsRequest extends FormRequest
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
        return [
            'drug_amount' => ['required'],
            'drug_entry_date' => ['required'],
            'drug_residual' => ['required'],
            'production_date' => ['required'],
            'expiration_date' => ['required'],
            'drug_unit_price' => ['required']
        ];
    }
}
