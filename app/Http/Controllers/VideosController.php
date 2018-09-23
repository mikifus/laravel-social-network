<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserProfileController;
use \App\Repositories\User\UserRepository;

use App\Models\Video;
use App\Models\Videoalbum;
use App\Http\Requests\VideoAddRequest;
use App\Http\Requests\VideoEditRequest;
use App\Http\Requests\VideoDestroyRequest;
use Auth;
use App\Models\User;
use Cviebrock\EloquentTaggable\Models\Tag;
use Response;

class VideosController extends UserProfileController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $user = Auth::user();
        if (!$this->secure($user->username)) {
            return abort(404);
        }
        $videos = $user->videos()->get();
        $videoalbums = $user->videoalbums()->get();
        $data = [];
        $data['videos'] = $videos;
        $data['videoalbums'] = $videoalbums;
        $data['user'] = $user;
        return view('videos.index', $data);
    }

    public function showUser($username) {
        if (empty($username)) {
            $user = Auth::user();
        } else if (!$this->secure($username)) {
            return abort(404);
        } else {
            $user = User::where('username', $username)->first();
        }
        $videos = $user->videos()->get();
        $videoalbums = $user->videoalbums()->get();
        $data = [];
        $data['videos'] = $videos;
        $data['videoalbums'] = $videoalbums;
        $data['user'] = $user;
        $data['can_see'] = $user->canSeeProfile(Auth::id());
        return $this->renderProfileView('profile.videos', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function showSlug($slug)
    {
        $el = Video::findBySlug($slug);
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['can_see'] = $el->user()->canSeeProfile(Auth::id());
        return $this->renderProfileView('profile.videos', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {
        $data = [];
        $data['videoalbums'] = Videoalbum::pluck('name', 'id');
        return $this->renderProfileView('videos.add', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $user = Auth::user();
        $el = Video::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('profile.videos')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['videoalbums'] = Videoalbum::pluck('name', 'id');
        return $this->renderProfileView('videos.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(VideoAddRequest $request)
    {
        $user = Auth::user();
        $el = new Video;
        $el->title = $request->title;
        $el->user_id = $user->id;
        $el->url = $request->url;
        if( !empty($request->videoalbum_title) )
        {
            $videoalbum = new Videoalbum;
            $videoalbum->name = $request->videoalbum_title;
            $videoalbum->user_id = $user->id;
            $videoalbum->save();
            $el->videoalbum_id = $videoalbum->id;
        }
        else if ( empty($request->videoalbum_id) )
        {
            $el->videoalbum_id = null;
        }
        else
        {
            $el->videoalbum_id = $request->videoalbum_id;
        }
        try {
            $el->save();
            $el->tag(trim(strip_tags($request->tags)));
        }
        catch (\Exception $e)
        {
            $el->delete();
            return back()->withErrors(['error' => "Unexpected error."]);
        }
        return redirect()->route('profile.videos')->withSuccess(trans('videos.add_success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update($id, VideoEditRequest $request)
    {
        $user = Auth::user();
        $el = Video::findOrFail($id);

        if( !empty($request->videoalbum_title) )
        {
            $videoalbum = new Videoalbum;
            $videoalbum->name = $request->videoalbum_title;
            $videoalbum->user_id = $user->id;
            $videoalbum->save();
            $el->videoalbum_id = $videoalbum->id;
        }
        else if ( empty($request->videoalbum_id) )
        {
            $el->videoalbum_id = null;
        }
        else
        {
            $el->videoalbum_id = $request->videoalbum_id;
        }
        try {
            $el->save();
            $el->retag(trim(strip_tags($request->tags)));
        }
        catch (\Exception $e)
        {
            return back()->withErrors(['error' => "Unexpected error."]);
        }
        return redirect()->route('profile.videos')->withSuccess(trans('videos.edit_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $el = Video::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('profile.videos')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $el->delete();
        return redirect()->route('profile.videos')->withSuccess(trans('videos.destroy_success'));
    }

    /**
     * Async method for tags field autocomplete
     *
     * @param string $value
     * @return Response
     */
    protected function autocompleteTags($term)
    {
        return Response::json(Video::searchModelTags($term));
    }
}
