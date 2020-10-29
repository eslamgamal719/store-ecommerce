<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\UniqueAttributeName;
use Illuminate\Foundation\Http\FormRequest;

class AttributesRequest extends FormRequest
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
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required','max:50', new UniqueAttributeName($this->name, $this->id)]];
        }

        return $rules;

    }


    public function messages()
    {
        return [
            'ar.name.required'  => __('admin/product.ar name required'),
            'en.name.required'  => __('admin/product.en name required'),
        ];
    }
}
