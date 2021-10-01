<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $user = auth()->user();

        return [
            'username' => 'required|email|unique:users,username,' . $user->id,
            'phone' => 'required|unique:user_profiles,phone,' . $user->profile->id . '|min:10',
            'password' => 'nullable|string|regex:/[a-z]/|regex:/[0-9]/|min:8',
            'rpassword' => 'nullable|same:password',
            'fullname' => 'required',
            'dob' => 'nullable',
        ];
    }
}
