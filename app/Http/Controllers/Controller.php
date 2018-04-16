<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function secure($username, $is_owner = false) {
        $user = User::where('username', $username)->first();

        if ($user) {
            $this->user = $user;
            $this->my_profile = (Auth::id() == $this->user->id) ? true : false;
            if ($is_owner && !$this->my_profile) {
                return false;
            }
            return true;
        }
        return false;
    }

}
