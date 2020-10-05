<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Enumerations\CategoryType;
use App\Rules\ProductQty;
use Illuminate\Foundation\Http\FormRequest;

class ProductStockRequest extends FormRequest
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
            'sku'    => 'nullable|min:3|max:10',
            'product_id'  => 'required|exists:products,id',
            'manage_stock' => 'required|in:0,1',
            'in_stock' => 'required|in:0,1',
            //'qty' => 'required_if:manage_stock,==,1',
            'qty' => [new ProductQty($this->manage_stock)]

        ];
    }


    public function messages()
    {
        return [
            'name.required'     => __('admin/category.name required'),
            'slug.required'    => __('admin/category.slug required'),
            'slug.unique'       => __('admin/category.slug unique'),
            'photo.required'   => __('admin/category.photo required'),
            'photo.mimes'   => __('admin/category.photo invalid'),
            'type.required'   => __('admin/category.type required'),
        ];
    }
}
