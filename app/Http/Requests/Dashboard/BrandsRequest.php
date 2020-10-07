<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BrandsRequest extends FormRequest
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
            'photo' => 'required_without:id|mimes:jpg,jpeg,png'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required'];
        }

        return $rules;

    }


    public function messages()
    {
        return [
            'ar.name.required'  => __('admin/brands.ar name required'),
            'en.name.required'  => __('admin/brands.en name required'),
            'photo.required' => __('admin/brands.photo required'),
            'photo.mimes'    => __('admin/brands.photo not valid')
        ];
    }
}
