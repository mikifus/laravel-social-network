<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Videoalbum;
use App\Http\Requests\VideoalbumsEditRequest;
use Amranidev\Ajaxis\Ajaxis;
// use \Serverfireteam\Panel\CrudController;
use URL;
use Auth;
use Response;

/**
 * Class VideoalbumController.
 *
 * @author  The scaffold-interface created at 2017-02-18 11:47:16pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class VideoalbumsController extends UserProfileController
{
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function showSlug($slug)
    {
        $el = Videoalbum::findBySlug($slug);
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['videos'] = $el->videos()->get();
        $data['can_see'] = $el->user()->canSeeProfile(Auth::id());
        return $this->renderProfileView('profile.videos', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
//    public function getIndex()
//    {
//        $title = 'Index - videoalbum';
//        $videoalbums = Videoalbum::paginate(6);
//        return view('videoalbum.index',compact('videoalbums','title'));
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {
        return $this->renderProfileView('videoalbums.add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $user = Auth::user();
        $el = Videoalbum::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('profile.videos')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        return $this->renderProfileView('videoalbums.edit', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - videoalbum';

        return view('videoalbum.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $title = 'Show - videoalbum';

        if($request->ajax())
        {
            return URL::to('videoalbum/'.$id);
        }

        $videoalbum = Videoalbum::findOrfail($id);
        return view('videoalbum.show',compact('title','videoalbum'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit - videoalbum';
        if($request->ajax())
        {
            return URL::to('videoalbum/'. $id . '/edit');
        }


        $videoalbum = Videoalbum::findOrfail($id);
        return view('videoalbum.edit',compact('title','videoalbum'  ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $videoalbum = new Videoalbum();
        $videoalbum->name = $request->title;
        $videoalbum->description = $request->description;
        $videoalbum->user_id = $user->id;
        $videoalbum->save();
        $videoalbum->tag(trim(strip_tags($request->tags)));

        return redirect()->route('profile.videos')->withSuccess(trans('videoalbums.add_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id,VideoalbumsEditRequest $request)
    {
        $videoalbum = Videoalbum::findOrfail($id);
        $videoalbum->name = $request->name;
        $videoalbum->description = $request->description;
        $videoalbum->save();
        $videoalbum->retag(trim(strip_tags($request->tags)));

        return redirect()->route('profile.videos')->withSuccess(trans('videoalbums.update_success'));
    }

    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request  $request
     * @return  String
     */
//    public function DeleteMsg($id,Request $request)
//    {
//        $msg = Ajaxis::MtDeleting('Warning!!','Would you like to remove This?','/videoalbum/'. $id . '/delete');
//
//        if($request->ajax())
//        {
//            return $msg;
//        }
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
     	$el = Videoalbum::findOrfail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('profile.videos')->withErrors(['error'=>trans('general.permission_denied')]);
        }
     	$el->delete();
        return redirect()->route('profile.videos')->withSuccess(trans('videoalbums.destroy_success'));
    }

    /**
     * Async method for tags field autocomplete
     *
     * @param string $value
     * @return Response
     */
    protected function autocompleteTags($term)
    {
        return Response::json(Videoalbum::searchModelTags($term));
    }
}
