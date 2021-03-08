<?php

namespace Modules\CashierItem\Http\Requests\Cashier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity.*' => 'sometimes|nullable|integer',
            'quantity' => 'sometimes|nullable|integer',
            'rowid' => 'sometimes|nullable|string'
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
