<?php

namespace Modules\ChangePassword\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|numeric|digits_between:6,6',
            'newPassword' => 'required|numeric|digits_between:6,6|same:retypeNewPassword',
            'retypeNewPassword' => 'required|numeric|digits_between:6,6',
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
