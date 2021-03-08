<?php

namespace Modules\Shift\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CloseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'actual_cash' => 'required|nullable|integer',
            'notes' => 'sometimes|nullable|string'
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
