<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Musicalbum;

class MusicalbumPublishRequest extends Request
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
        $rules = [
            'license_type'          => 'required|in:copyright,cc,public_domain'
        ];
        if( Request::get('license_type') == 'copyright' )
        {
            $rules['copyright_string']        = 'required|min:1|max:255';
        }
        else if ( Request::get('license_type') == 'cc' )
        {
            $rules['cc_license']        = 'required|in:by,by-nd,by-sa,by-nc,by-nc-nd,by-nc-sa';
        }
        return $rules;
    }
}
