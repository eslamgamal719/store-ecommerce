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
        $rules = [
            'slug'  => 'required|unique:products,slug,' . $this->id,
            'categories.*' => 'numeric|exists:categories,id',
            'categories.0' => 'required',
            'tags' => 'nullable',
            'brand_id' => 'required|exists:brands,id',
        ];

        foreach(config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.name' => 'required|max:100',
                $locale . '.description' => 'required|max:1000',
                $locale . '.short_description' => 'nullable|max:500'
            ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'ar.name.required'     => __('admin/product.ar name required'),
            'en.name.required'     => __('admin/product.en name required'),
            'slug.required'    => __('admin/product.slug required'),
            'slug.unique'       => __('admin/product.slug unique'),
            'ar.description.required'   => __('admin/product.ar description required'),
            'en.description.required'   => __('admin/product.en description required'),
            'categories.0.required'   => __('admin/product.category required'),
            'brand_id.required'   => __('admin/product.brand required'),
        ];
    }
}
