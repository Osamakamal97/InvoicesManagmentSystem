<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'invoice_number' => 'required',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'product_id' => 'required|not_in:0',
            'section_id' => 'required|not_in:0',
            'discount' => 'required|numeric',
            'rate_vat' => 'required|not_in:0',
            'value_vat' => 'required|numeric',
            'total' => 'required|numeric',
            'collection_amount' => 'nullable|numeric', 
            'commission_amount' => 'required|numeric',
            'note' => 'nullable',
            'user_id'=>'nullable',
            'attachment' => 'required|mimes:pdf,jpeg,png,jpg'
        ];
    }
}
