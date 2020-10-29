<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Enumerations\CategoryType;
use App\Rules\ProductQty;
use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id'  => 'required|exists:products,id',
            'document' => 'required|array|min:1',
            'document.*' => 'required|string',
        ];
    }


    public function messages()
    {
        return [
            'product_id.required'     => __('admin/product.product_id required'),
            'document.required'     => __('admin/product.document required'),
            'document.string'    => __('admin/product.document must be string'),
        ];
    }
}
