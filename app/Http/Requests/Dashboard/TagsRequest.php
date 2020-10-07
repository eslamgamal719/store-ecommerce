<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TagsRequest extends FormRequest
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
            'slug'  => 'required|unique:tags,slug,' . $this->id
        ];

        foreach(config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => 'required'];
        }

        return $rules;
    }


    public function messages()
    {
        return [
           'ar.name.required'     => __('admin/tags.ar name required'),
           'en.name.required'     => __('admin/tags.en name required'),
            'slug.required'    => __('admin/tags.slug required'),
            'slug.unique'       => __('admin/tags.slug unique'),

        ];
    }
}
