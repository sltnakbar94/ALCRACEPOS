<?php

namespace Modules\CashierTicket\Http\Requests\Cashier;

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
            'code' => 'required|nullable|exists:wahana__devices,code',
            'code.*' => 'required|nullable|exists:wahana__devices,code',
            'ticket_type' => 'sometimes|nullable|in:pass',
            'quantity' => 'sometimes|integer|nullable'
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
