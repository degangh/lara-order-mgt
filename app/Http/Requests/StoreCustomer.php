<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
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
            'address' => 'required',
            'mobile' => 'required',
            'name_py' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'CUSTOMER_NAME_MISSING',
            'name_py.required' => 'CUSTOMER_NAME_SHORT_MISSING',
            'address.required' => 'CUSTOMER_ADDRESS_MISSING',
            'mobile.required' => 'CUSTOMER_ADDRESS_MISSING'
        ];
    }
}
