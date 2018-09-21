<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class VideoalbumsEditRequest extends Request
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
            'description' => 'sometimes|nullable|min:4',
            'tags'        => 'sometimes|nullable|min:1'
        ];
    }
}
