<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
// use App\Library\sHelper;
// use App\Models\User;
// use App\Models\UserFollowing;
use Auth;
// use DB;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;
use App\Http\Requests\ToggleLikeRequest;


class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function toggle(ToggleLikeRequest $request){
        $model = $request->input('model');
        $id = $request->input('id');
        
        $full_model_name = "App\Models\\".$model;
        $user = Auth::user();
        
        $model_object = $full_model_name::find($id)->first();
        $model_object->toggleLikeBy($user->id);
//         $user->toggleLike($model_object);

        $response = array(
            'likedBy'     => $user->hasLiked($model_object),
            'likesCount' => $model_object->likesCount
        );

        return Response::json($response);
    }

}
