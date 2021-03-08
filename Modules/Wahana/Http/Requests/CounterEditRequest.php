<?php

namespace Modules\Wahana\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CounterEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device' => 'required|nullable|exists:wahana__devices,id',
            'id' => 'required|nullable|exists:wahana__counter,id',
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
