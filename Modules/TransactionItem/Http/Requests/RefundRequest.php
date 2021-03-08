<?php

namespace Modules\TransactionItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction_number' => 'required|nullable|exists:cashitem__transaction,transaction_number',
            'item' => 'required|nullable|exists:cashitem__cart,id',
            'quantity' => 'required|nullable|integer',
            'notes' => 'sometimes|nullable|string|max:191',
            'store_manager' => 'required|nullable|exists:users,email',
            'pin' => 'required|numeric',
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
