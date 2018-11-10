<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class RateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: Check privacy of liked element
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
            'model'       => 'required|min:3',
            'id'          => 'required|integer',
            'rating'      => 'required|integer|min:1|max:5'
        ];
    }
}
