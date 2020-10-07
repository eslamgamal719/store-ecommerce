<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'id'             => 'required|exists:settings',
            'plain_value'    => 'nullable|numeric',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [
                $locale . '.value' => 'required'
            ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'value.required'       => __('admin/settings.value required'),
            'plain_value.numeric'  => __('admin/settings.plain_value required')
        ];
    }
}
