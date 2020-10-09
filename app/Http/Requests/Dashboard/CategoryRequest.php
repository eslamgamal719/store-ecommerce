<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Enumerations\CategoryType;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'slug'  => 'required|unique:categories,slug,' . $this->id,
            'photo' => 'mimes:jpg,png,jpeg',
            'type'  => 'required|in:'. CategoryType::MainCategory . "," . CategoryType::SubCategory,
        ];

        foreach(config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required'];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'ar.name.required'     => __('admin/category.ar name required'),
            'en.name.required'     => __('admin/category.en name required'),
            'slug.required'    => __('admin/category.slug required'),
            'slug.unique'       => __('admin/category.slug unique'),
            'photo.required'   => __('admin/category.photo required'),
            'photo.mimes'   => __('admin/category.photo invalid'),
            'type.required'   => __('admin/category.type required'),
        ];
    }
}
