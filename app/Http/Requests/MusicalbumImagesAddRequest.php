<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Musicalbum;
use Auth;

class MusicalbumImagesAddRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = app( 'auth' )->user();
        $el   = Musicalbum::findOrFail( $this->route('id') );

        return $user->isId( $el->user_id );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Cover refers to the kind of image uploaded
        return [
            'cover'       => 'required|in:front,back',
            'file'        => 'required|image|mimes:jpeg,jpg,png|max:10000'
        ];
    }
}
