<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SliderImageRequest extends FormRequest
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
            'document' => 'required|array|min:1',
            'document.*' => 'required|string',
        ];
    }


    public function messages()
    {
        return [
            'document.required'     => __('admin/product.document required'),
            'document.string'    => __('admin/product.document must be string'),
        ];
    }
}
