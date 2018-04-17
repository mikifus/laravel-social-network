<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Videoalbum;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use \Serverfireteam\Panel\CrudController;
use Auth;

/**
 * Class VideoalbumController.
 *
 * @author  The scaffold-interface created at 2017-02-18 11:47:16pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class VideoalbumsController extends UserProfileController
{
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
            return redirect('videos')->withErrors(['error'=>trans('general.permission_denied')]);
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

        return redirect('videos')->withSuccess(trans('videoalbums.add_success'));
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
    public function edit($id,Request $request)
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
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $videoalbum = Videoalbum::findOrfail($id);

        $videoalbum->name = $request->name;

        $videoalbum->description = $request->description;


        $videoalbum->save();

        return redirect('videoalbum');
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
            return redirect('videos')->withErrors(['error'=>trans('general.permission_denied')]);
        }
     	$el->delete();
        return redirect('videos')->withSuccess(trans('videoalbums.destroy_success'));
    }
}
