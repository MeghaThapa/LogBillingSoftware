<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseItemRequest extends FormRequest
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
            'quantity'=>'required|numeric',
            'rate'=>'required|integer',
            'product_id'=>'required'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->rate > $this->spA || $this->rate == $this->spA  ){
                $validator->errors()->add('field', 'Sp should be grater than cp!');
            }
        });
    }

}
