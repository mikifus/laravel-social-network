<?php

namespace App\Http\Controllers;

use Auth;

abstract class UserProfileController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    public function __construct() {
        $this->middleware('auth');
    }

    protected function renderProfileView($view = null, $data = [], $mergeData = [])
    {
        if( empty($data['user']) ) {
            $data['user'] = Auth::user();
        }
        return view($view, $data, $mergeData);
    }
}
