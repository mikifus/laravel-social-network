<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;

use Auth;

class TrackAddRequest extends Request
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
        // Workaround for js validation not validating the file.
        Validator::extend('no_js_validation', function($attribute, $value, $parameters, $validator) {
            return true;
        });
        return [
            'title'        => 'required|min:1|max:255',
            'author'       => 'required|min:1|max:255',
            'feat'         => 'nullable|min:1|max:255',
            'beatmaker'    => 'nullable|min:1|max:255',
            'description'  => 'nullable|min:1|max:700',
            'file'         => 'required|mimes:mp3,mpga|max:15000|no_js_validation',
            'tags'         => 'sometimes|nullable|min:1'
        ];
    }
}
