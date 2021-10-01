<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|email|unique:users',
            'phone' => 'required|unique:user_profiles||min:10',
            'password' => 'required|string|regex:/[a-z]/|regex:/[0-9]/|min:8',
            'rpassword' => 'required|same:password',
            'fullname' => 'required',
            'image' =>   'required|mimes:jpeg,bmp,png|max:5120',
            'dob' => 'nullable',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'username.unique' => 'The Email has already been taken.',
        ];
    }
}
