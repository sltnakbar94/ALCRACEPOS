<?php

namespace Modules\TransactionItem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    protected $redirectRoute = "transItemView";
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'code' => 'sometimes|nullable|exists:product__item,code',
                    'number' => 'sometimes|nullable|exists:cashitem__transaction,transaction_number',
                    'transNum' => 'sometimes|nullable|exists:cashitem__transaction,transaction_number',
                    'item' => 'sometimes|nullable|exists:cashitem__cart,id',
                ];
                break;

            case 'POST':
                
                break;
            
            default:
                # code...
                break;
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
