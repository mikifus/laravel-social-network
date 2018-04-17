<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class ImageEditRequest extends Request
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
            'imagealbum_id' => 'integer|exists:imagealbums,id',
            'imagealbum_title' => 'nullable|min:4|unique:imagealbums,title'
        ];
    }
}
