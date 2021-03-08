<?php

namespace Modules\TransactionTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    protected $redirectRoute = "transTicketView";
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
                    'code' => 'sometimes|nullable|exists:wahana__devices,code',
                    'number' => 'sometimes|nullable|exists:cashticket__transaction,transaction_number',
                    'transNum' => 'sometimes|nullable|exists:cashticket__transaction,transaction_number',
                    'item' => 'sometimes|nullable|exists:cashticket__cart,id',
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
