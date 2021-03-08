<?php

namespace Modules\Item\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Auth;
use Modules\Item\Entities\ProductItem;

class ItemFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $product = ProductItem::onlyTrashed()->where(['code' => $request->code])->first();
        if (Auth::user()->hasRole('superadministrator')) {
            
            switch ($this->method()) {
                case 'POST':
                    return [
                        'code' => 'required|nullable|numeric',
                        'category' => 'sometimes|nullable|exists:product__category,id',
                        'item' => 'required|nullable|string',
                        'price' => 'required|nullable|numeric',
                        'stock' => 'required|nullable|numeric',
                        'status' => 'required|nullable|in:publish,unpublish',
                    ];
                    break;

                case 'PATCH':
                    return [
                        // 'code' => 'required|nullable|numeric|unique:product__item,code,'.$request->id,
                        'category' => 'sometimes|nullable|exists:product__category,id',
                        'item' => 'required|nullable|string',
                        'price' => 'required|nullable|numeric',
                        'status' => 'required|nullable|in:publish,unpublish',
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
                        'code' => 'required|nullable|numeric',
                        'category' => 'sometimes|nullable|exists:product__category,id',
                        'item' => 'required|nullable|string',
                        'price' => 'required|nullable|numeric',
                        'stock' => 'required|nullable|numeric',
                        'status' => 'required|nullable|in:publish,unpublish',
                    ];
                    break;

                case 'PATCH':
                    return [
                        // 'code' => 'required|nullable|numeric|unique:product__item,code,'.$request->id,
                        'category' => 'sometimes|nullable|exists:product__category,id',
                        'item' => 'required|nullable|string',
                        // 'price' => 'required|nullable|numeric',
                        'status' => 'required|nullable|in:publish,unpublish',
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
