<?php

namespace Modules\Wahana\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CounterFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_id' => 'required|nullable|exists:wahana__devices,id',
            'name' => 'required|nullable|string'
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
