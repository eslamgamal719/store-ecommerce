<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Enumerations\CategoryType;
use Illuminate\Foundation\Http\FormRequest;

class GeneralProductRequest extends FormRequest
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
            'name'    => 'required|max:100',
            'slug'  => 'required|unique:products,slug',
            'description' => 'required|max:1000',
            'short_description' => 'nullable:max:500',
            'categories' => 'array|min:1',
            'categories.*' => 'numeric|exists:categories,id',
            'tags' => 'nullable',
            'brand_id' => 'required|exists:brands,id',
        ];
    }


    public function messages()
    {
        return [
            'name.required'     => __('admin/category.name required'),
            'slug.required'    => __('admin/category.slug required'),
            'slug.unique'       => __('admin/category.slug unique'),
            'description.required'   => __('admin/category.description required'),
            'categories.min:1'   => __('admin/category.category required'),
            'brand_id.required'   => __('admin/category.brand required'),
        ];
    }
}
