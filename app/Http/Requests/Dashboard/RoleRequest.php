<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'permissions' => 'required|array|min:1',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required'];
        }

        return $rules;

    }


}
