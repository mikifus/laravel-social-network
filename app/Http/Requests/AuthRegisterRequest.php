<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Auth;

class AuthRegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:7|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255',
            'country' => 'required|max:255',
            'city' => 'sometimes|required|max:255',
            'neighborhood' => 'sometimes|required|max:255',
            'how_know' => 'max:512',
            'avatar'       => 'mimes:jpg,jpeg,png',
            'password' => 'required|confirmed|min:8',
        ];
    }
}
