<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Enumerations\CategoryType;
use Illuminate\Foundation\Http\FormRequest;

class ProductPriceRequest extends FormRequest
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
            'price'    => 'required|min:0|numeric',
            'product_id'  => 'required|exists:products,id',
            'special_price' => 'nullable|numeric',
            'special_price_type' => 'required_with:special_price|in:percent,fixed',
            'special_price_start' => 'required_with:special_price|date_format:Y-m-d',
            'special_price_end' => 'required_with:special_price|date_format:Y-m-d',
        ];
    }


    public function messages()
    {
        return [
            'price.required'     => __('admin/category.price required'),
            'special_price_type.required'   => __('admin/category.special price type required'),
            'special_price_start.required'   => __('admin/category.special price start required'),
            'special_price_end.required'   => __('admin/category.special price end required'),
        ];
    }
}
