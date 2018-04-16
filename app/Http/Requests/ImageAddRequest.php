<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Auth;

class ImageAddRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'      => 'min:4',
            'file'       => 'required|image|mimes:jpg,jpeg,png,gif',
            'imagealbum_id' => 'sometimes|integer|min:1|exists:imagealbums,id',
            'imagealbum_title' => 'sometimes|min:4|unique:imagealbums,title'
        ];
    }
}