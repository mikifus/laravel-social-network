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

class VideosController extends UserProfileController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex(UserRepository $userRepository)
    {
        $user = Auth::user();
        return $this->showUser($user->username, $userRepository);
    }

    public function showUser($username, UserRepository $userRepository) {
        $user = $userRepository->findByUsername($username);
        $videos = $user->videos()->get();
        $videoalbums = $user->videoalbums()->get();
        $data = [];
        $data['videos'] = $videos;
        $data['videoalbums'] = $videoalbums;
        $data['user'] = $user;
        return view('videos.index', $data);
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
            return redirect('videos')->withErrors(['error'=>trans('general.permission_denied')]);
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
        }
        catch (\Exception $e)
        {
            $el->delete();
            return back()->withErrors(['error' => "Unexpected error."]);
        }
        return redirect('videos')->withSuccess(trans('videos.add_success'));
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
        }
        catch (\Exception $e)
        {
            return back()->withErrors(['error' => "Unexpected error."]);
        }
        return redirect('videos')->withSuccess(trans('videos.edit_success'));
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
            return redirect('videos')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $el->delete();
        return redirect('videos')->withSuccess(trans('videos.destroy_success'));
    }
}
