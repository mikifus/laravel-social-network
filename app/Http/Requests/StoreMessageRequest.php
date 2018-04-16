<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class StoreMessageRequest extends Request
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
            'subject'       => 'required|min:3',
            'message'       => 'required|min:3',
            'username'      => 'required|min:7',
            'user_id'       => 'required|exists:users,id,validated,1|not_in:'.Auth::user()->id
        ];
    }
}
