<?php

namespace Modules\Wahana\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class WahanaFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Auth::user()->hasRole('superadministrator')) {
            switch ($this->method()) {
                case 'POST':
                    return [
                        'name' => 'required|nullable|string',
                        'price' => 'required|nullable|numeric',
                        'type' => 'required|nullable|in:One Time,With Timer',
                        'timer_count' => 'sometimes|nullable|numeric',
                        // 'status' => 'required|nullable|in:Ready,Maintenance,Out Of Order',
                    ];
                    break;

                case 'PATCH':
                    return [
                        'id' => 'required|nullable|exists:wahana__devices,id',
                        'name' => 'required|nullable|string',
                        'price' => 'required|nullable|numeric',
                        'type' => 'required|nullable|in:One Time,With Timer',
                        'timer_count' => 'sometimes|nullable|numeric',
                        // 'status' => 'required|nullable|in:Ready,Maintenance,Out Of Order',
                    ];
                    break;

                default:
                    # code...
                    break;
            }
        }if (Auth::user()->hasRole('storemanager')) {
            switch ($this->method()) {
                case 'POST':
                    return [
                        'name' => 'required|nullable|string',
                        'price' => 'required|nullable|numeric',
                        'type' => 'required|nullable|in:One Time,With Timer',
                        'timer_count' => 'sometimes|nullable|numeric',
                        // 'status' => 'required|nullable|in:Ready,Maintenance,Out Of Order',
                    ];
                    break;

                case 'PATCH':
                    return [
                        'id' => 'required|nullable|exists:wahana__devices,id',
                        'name' => 'required|nullable|string',
                        // 'price' => 'required|nullable|numeric',
                        'type' => 'required|nullable|in:One Time,With Timer',
                        'timer_count' => 'sometimes|nullable|numeric',
                        // 'status' => 'required|nullable|in:Ready,Maintenance,Out Of Order',
                    ];
                    break;

                default:
                    # code...
                    break;
            }
        }
        
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
