<?php

namespace Modules\TransactionTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterReportRequest extends FormRequest
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
                    'staff' => 'sometimes|nullable|exists:users,id',
                    'from' => 'sometimes|date|nullable|date_format:d-m-Y',
                    'to' => 'sometimes|date|nullable|date_format:d-m-Y',
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
