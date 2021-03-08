<?php

namespace Modules\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|nullable|string',
            'phone' => 'required|nullable|numeric',
            'address' => 'sometimes|nullable|string',
            'username' => 'required|nullable|alpha_num|unique:users,email',
            'pin' => 'required|nullable|numeric|digits_between:6,6',
            'level' => 'required|nullable|exists:roles,id',
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
