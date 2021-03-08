<?php

namespace Modules\Item\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceivingFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|nullable|exists:product__item,id',
            'quantity' => 'required|numeric|nullable',
            'enter_date' => 'required|date_format:d-m-Y|nullable',
            'buy_price' => 'required|numeric|nullable',
            'notes' => 'nullable|sometimes|string|max:191'
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
