<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'attribute_id' => 'required|exists:attributes,id',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', 'max:100']];
        }

        return $rules;

    }


    public function messages()
    {
        return [
            'ar.name.required'  => __('admin/products.ar name required'),
            'en.name.required'  => __('admin/products.en name required'),
            'price.required' => __('admin/products.price is required'),
            'product_id'    => __('admin/products.must choose product'),
            'attribute_id'    => __('admin/products.must choose attribute')
        ];
    }
}
