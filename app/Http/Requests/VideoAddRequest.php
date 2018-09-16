<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;


use Auth;
use MediaEmbed\MediaEmbed;

class VideoAddRequest extends Request
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
     * Adds a video_url validation rule.
     *
     * @return array
     */
    public function rules()
    {
        Validator::extend('video_url', function($attribute, $value, $parameters)
        {
            $MediaEmbed = new MediaEmbed();
            $MediaObject = $MediaEmbed->parseUrl( $value );
            return $MediaObject ? true : false;
        });

        return [
            'title'            => 'required|min:4',
            'url'              => 'required|url|video_url',
            'tags'             => 'sometimes|nullable|min:1,',
            'videoalbum_id'    => 'sometimes|integer|min:1|exists:videoalbums,id',
            'videoalbum_title' => 'sometimes|nullable|min:4|unique:videoalbums,name'
        ];
    }
}
