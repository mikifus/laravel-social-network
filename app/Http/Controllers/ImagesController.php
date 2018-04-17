<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

use App\Models\Image;
use App\Models\Imagealbum;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageEditRequest;
use App\Http\Requests\ImageDestroyRequest;
use App\Models\User;
use App\Http\Controllers\UserProfileController;
use Auth;

class ImagesController extends UserProfileController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $user = Auth::user();
        $id = $user->id;

        $user_list = $user->messagePeopleList();

        $show = true;

        $images = $user->images()->orderBy('id', 'desc')->get();
        $imagealbums = $user->imagealbums()->orderBy('id', 'desc')->get();

        return view('images.index', compact('user', 'user_list', 'show', 'id', 'imagealbums', 'images'));
//        return $this->showUser($user->username, $userRepository);
    }

    public function showUser($username = '') {
        if(empty($username)) {
            $user = Auth::user();
        } else if (!$this->secure($username)) {
            return redirect('/404');
        } else {
            $user = User::where('username', $username)->first();
        }

        $id = $user->id;

        $user_list = $user->messagePeopleList();

        $show = false;
        if ($id != null) {
            $friend = User::find($id);
            if ($friend) {
                $show = true;
            }
        }

        $images = $user->images()->orderBy('id', 'desc')->get();
        $imagealbums = $user->imagealbums()->orderBy('id', 'desc')->get();

        return view('images.index', compact('user', 'user_list', 'show', 'id', 'imagealbums', 'images'));
//        return $this->showUser($user->username, $userRepository);
    }

//    public function showUser($username, UserRepository $userRepository) {
//        $user = $userRepository->findByUsername($username);
//        $images = $user->images()->orderBy('id', 'desc')->get();
//        $imagealbums = $user->imagealbums()->orderBy('id', 'desc')->get();
//        $data = [];
//        $data['images'] = $images;
//        $data['imagealbums'] = $imagealbums;
//        $data['user'] = $user;
//        return $this->renderProfileView('images.index', $data);
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {
        $user = Auth::user();
        $data = [];
        $data['imagealbums'] = Imagealbum::pluck('title', 'id');
        $data['user'] = $user;
        return $this->renderProfileView('images.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request\ImageAddRequestRequest  $request
     * @return Response
     */
    public function store(ImageAddRequest $request)
    {
        $user = Auth::user();

        $file = $request->file('file');
        $title = $request->title;
        if( empty($title) )
        {
            $title = $file->getClientOriginalName();
        }

        $el = new Image;
        $el->title = $title;
        $el->user_id = $user->id;
        $el->file = $file;
        try {
            $el->save();
        }
        catch (\Exception $e)
        {
            $el->delete();
            return back()->withErrors(['error' => "Unexpected error. Check file extension."]);
        }
        return redirect('images')->withSuccess(trans('images.add_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAsync(Request $request)
    {
        $user = Auth::user();

        $imageAddRequest = new ImageAddRequest();

        $file = $request->file('file');
        $validator = Validator::make($request->all(), $imageAddRequest->rules());

        if ($validator->fails()) {

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);

        }

        $title = $request->title;
        if( empty($title) )
        {
            $title = $file->getClientOriginalName();
        }

        $el = new Image;
        $el->title = $title;
        $el->user_id = $user->id;
        $el->file = $file;
        if (!empty($request->imagealbum_title)) {
            $imagealbum = new Imagealbum;
            $imagealbum->title = $request->imagealbum_title;
            $imagealbum->user_id = $user->id;
            $imagealbum->save();
            $el->imagealbum_id = $imagealbum->id;
        } else if (empty($request->imagealbum_id)) {
            $el->imagealbum_id = null;
        } else {
            $el->imagealbum_id = $request->imagealbum_id;
        }
        try {
            $el->save();
        }
        catch (\Exception $e)
        {
            $el->delete();
            return Response::json([
                'error' => true,
                'message' => "An unexpected error happened. Check file extension. " . $e->getMessage(),
                'code' => 400
            ], 400);
        }
//        return redirect('images')->withSuccess(trans('images.add_success'));

        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    /**
     * Show the form for editing a resource.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $user = Auth::user();
        $el = Image::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect('images')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['imagealbums'] = Imagealbum::pluck('title', 'id');
        $data['user'] = $user;
        return $this->renderProfileView('images.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request\ImageAddRequestRequest  $request
     * @return Response
     */
    public function update($id, ImageEditRequest $request)
    {
        $user = Auth::user();
        $el = Image::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect('images')->withErrors(['error'=>trans('general.permission_denied')]);
        }

        if( !empty($request->imagealbum_title) )
        {
            $imagealbum = new Imagealbum;
            $imagealbum->title = $request->imagealbum_title;
            $imagealbum->user_id = $user->id;
            $imagealbum->save();
            $el->imagealbum_id = $imagealbum->id;
        }
        else if ( empty($request->imagealbum_id) )
        {
            $el->imagealbum_id = null;
        }
        else
        {
            $el->imagealbum_id = $request->imagealbum_id;
        }
        try {
            $el->save();
        }
        catch (\Exception $e)
        {
            return back()->withErrors(['error' => "Unexpected error."]);
        }
        return redirect('images')->withSuccess(trans('images.add_success'));
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

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function showSlug($slug)
    {
        $el = Image::findBySlugOrFail($slug);
        $user = $el->user()->first();
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['user'] = $user;
        return $this->renderProfileView('images.view', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDelete($id)
    {
        $user = Auth::user();
        $el = Image::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect('images')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['user'] = $user;
//        return view('images.delete', $data);
        return $this->renderProfileView('images.delete', $data);
    }

    public function destroy(ImageDestroyRequest $request)
    {
        Image::destroy($request->id);
        return redirect('images')->withSuccess(trans('images.destroy_success'));
    }
}
