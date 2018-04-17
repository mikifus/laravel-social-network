<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Image;

class ImageDestroyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = app( 'auth' )->user();
        $el   = Image::findOrFail( $this->get( 'id' ) );

        return $el->user_id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'confirm' => 'required|accepted',
        ];
    }
}
