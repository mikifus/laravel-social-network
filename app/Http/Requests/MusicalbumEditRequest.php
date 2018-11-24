<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Musicalbum;

class MusicalbumEditRequest extends Request
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
        return [
            'description'      => 'required|min:25|max:2000',
            'tags'             => 'sometimes|nullable|min:1,',
            'category_id'      => 'sometimes|nullable|exists:categories,id'
        ];
    }
}
