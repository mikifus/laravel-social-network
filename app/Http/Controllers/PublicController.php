<?php

namespace App\Http\Controllers;

use App\Library\IPAPI;
use App\Library\sHelper;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Musicalbum;
use App\Models\Track;
use App\Models\Image;

class PublicController extends Controller
{

    public function __construct()
    {
//         $this->middleware('auth');
    }

    /**
     * List music
     *
     * @return \Illuminate\Http\Response
     */
    public function music(Request $request)
    {

        // TODO: Only public visibility
        $musicalbums = Musicalbum::limit(10)->get();
        $tracks = Track::limit(10)->get();

        return view('public.music.index', compact('musicalbums', 'tracks'));
    }

    /**
     * List images
     *
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request)
    {

        // TODO: Only public visibility
        $images = Image::limit(10)->get();

        return view('public.images.index', compact('images'));
    }


    public function search(Request $request){


//         $s = $request->input('s');
//         if (empty($s)) return redirect('/');
// 
// 
//         $user = Auth::user();
// 
//         $posts = Post::leftJoin('users', 'users.id', '=', 'posts.user_id')
//             ->where(function($query) use ($user) {
// 
//                 $query->where('users.private', 0)->orWhere(function($query) use ($user){
//                     $query->whereExists(function ($query) use($user){
//                         $query->select(DB::raw(1))
//                             ->from('user_following')
//                             ->whereRaw('user_following.following_user_id = users.id and user_following.follower_user_id = '.$user->id);
//                     });
//                 })->orWhere(function($query) use ($user){
//                     $query->where('users.private', 1)->where('users.id', $user->id);
//                 });
// 
//             })->where('posts.content', 'like', '%'.$s.'%')->where('posts.group_id', 0)
//             ->groupBy('posts.id')->select('posts.*')->orderBy('posts.id', 'DESC')->get();
// 
//         $comment_count = 2;
// 
//         $users = User::where('name', 'like', '%'.$s.'%')->orWhere('username', 'like', '%'.$s.'%')->orderBy('name', 'ASC')->get();
// 
//         return view('search', compact('users', 'posts', 'user', 'comment_count'));

    }
}
