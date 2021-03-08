<?php

namespace Modules\CashierItem\Http\Requests\Cashier;

use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|nullable|exists:product__item,code',
            'quantity' => 'required|nullable|integer'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
