<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrder extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'exchange_rate' => 'required',
            'address_id' => [
                'required',
                Rule::exists('addresses','id')->where(function($query){
                    $query->where('customer_id', $this->customer_id);
                })
            ],
            'order_date' => 'required|date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'ORDER_CUSTOMER_MISSING',
            'customer_id.exists' => 'ORDER_CUSTOMER_NOT_EXIST',
            'address_id.required' => 'ORDER_ADDRESS_MISSING',
            'address_id.exists' => 'ORDER_ADDRESS_NOT_EXIST',
            'exchange_rate.required' => 'EXCHANGE_RATE_MISSING',
            'order_date.required' => 'ORDER_DATE_MISSING',
            'order_date.date_format' => 'ORDER_DATE_FORMAT_NOT_ACCEPTED'
        ];
    }
}
