<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'ref_price_aud' => 'required|numeric',
            'rrp_cny' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'PRODUCT_NAME_MISSING',
            'name.max' => 'PRODUCT_NAME_TOO_LONG',
            'ref_price_aud.required' => 'PRODUCT_PRICE_AUD_MISSING',
            'ref_price_aud.numeric' => 'PRICE_AUD_MUST_BE_NUMERIC',
            'rrp_cny.required' => 'PRICE_CNY_MISSING',
            'rrp_cny.numeric' => 'PRICE_CNY_MUST_BE_NUMERIC'
        ];
            
    }
}
