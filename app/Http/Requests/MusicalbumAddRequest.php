<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Auth;

class MusicalbumAddRequest extends Request
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
            'title'        => 'required|min:1|max:255',
            'author'       => 'required|min:1|max:255',
            'description'  => 'required|min:25|max:2000',
            'tags'         => 'sometimes|nullable|min:1,',
            'category_id'  => 'sometimes|nullable|exists:categories,id'
        ];
    }
}
