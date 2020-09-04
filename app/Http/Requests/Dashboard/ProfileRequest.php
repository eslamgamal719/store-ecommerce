<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'    => 'required',
            'email'  => 'required|email|unique:admins,email,' . $this->id,
            'password' => 'nullable|confirmed|min:8'
        ];
    }


    public function messages()
    {
        return [
            'name.required'     => __('admin/profile.name required'),
            'email.required'    => __('admin/profile.email required'),
            'email.email'       => __('admin/profile.email valid'),
            'email.unique'      => __('admin/profile.email unique'),
            'password.confirmed' => __('admin/profile.password confirm error'),
            'password.min' => __('admin/profile.password min'),
        ];
    }
}
