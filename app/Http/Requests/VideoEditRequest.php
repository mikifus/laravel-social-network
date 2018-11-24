<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class VideoEditRequest extends Request
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
            'videoalbum_id'    => 'integer|nullable|exists:videoalbums,id',
            'videoalbum_title' => 'sometimes|nullable|min:4|unique:videoalbums,name',
            'tags'             => 'sometimes|nullable|min:1',
            'category_id'      => 'sometimes|nullable|exists:categories,id'
        ];
    }
}
