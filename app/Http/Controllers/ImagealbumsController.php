<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserProfileController;

use Illuminate\Http\Request;
use Auth;
use App\Models\Imagealbum;
use App\Http\Requests\ImagealbumsEditRequest;
use Rinvex\Categories\Models\Category;

class ImagealbumsController extends UserProfileController {

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function showSlug($slug)
    {
        $el = Imagealbum::findBySlug($slug);
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['images'] = $el->images()->get();
        $data['can_see'] = $el->user()->canSeeProfile(Auth::id());
        return $this->renderProfileView('imagealbums.view', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {
        $data = [];
        $data['categories'] = Category::pluck('name', 'id')->toArray();
        return $this->renderProfileView('imagealbums.add', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $user = Auth::user();
        $el = Imagealbum::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('images.index')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['categories'] = Category::pluck('name', 'id')->toArray();
        $data['category_id'] = sizeof($el->categories) > 0 ? $el->categories[0]->id : 0;
        return $this->renderProfileView('imagealbums.edit', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - imagealbum';

        return view('imagealbum.create');
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
        $el = new Imagealbum();

        $el->title = $request->title;

        $el->description = $request->description;

        $el->user_id = $user->id;

        $el->save();
        $el->tag(trim(strip_tags($request->tags)));
        if(empty($request->category_id)) {
            $el->detachCategories();
        } else {
            $el->attachCategories([intval($request->category_id)]);
        }

        return redirect()->route('images.index')->withSuccess(trans('imagealbums.add_success'));
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
        $title = 'Show - imagealbum';

        if($request->ajax())
        {
            return URL::to('imagealbum/'.$id);
        }

        $el = Imagealbum::findOrfail($id);
        return view('imagealbum.show',compact('title','imagealbum'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - imagealbum';
        if($request->ajax())
        {
            return URL::to('imagealbum/'. $id . '/edit');
        }


        $el = Imagealbum::findOrfail($id);
        return view('imagealbum.edit',compact('title','imagealbum'  ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id, ImagealbumsEditRequest $request)
    {
        $el = Imagealbum::findOrfail($id);
//         $el->title = $request->title; // No! Can't change it.
        $el->description = $request->description;
        $el->save();
        $el->retag(trim(strip_tags($request->tags)));
        if(empty($request->category_id)) {
            $el->detachCategories();
        } else {
            $el->attachCategories([intval($request->category_id)]);
        }

        return redirect()->route('images.index')->withSuccess(trans('imagealbums.edit_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
     	$el = Imagealbum::findOrfail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('images.index')->withErrors(['error'=>trans('general.permission_denied')]);
        }
     	$el->delete();
        return redirect()->route('images.index')->withSuccess(trans('imagealbums.destroy_success'));
    }
}
