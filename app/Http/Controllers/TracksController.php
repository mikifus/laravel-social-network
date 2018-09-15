<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserProfileController;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

use App\Models\Track;
use App\Http\Requests\TrackAddRequest;
use App\Http\Requests\TrackDestroyRequest;
use App\Http\Requests;
use Auth;

class TracksController extends UserProfileController
{

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function showSlug($slug)
    {
        $el = Track::findBySlugOrFail($slug);
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        return $this->renderProfileView('tracks.view', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {
        return $this->renderProfileView('tracks.add');
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

        $trackAddRequest = new TrackAddRequest();

        $file = $request->file('file');
        $validator = Validator::make($request->all(), $trackAddRequest->rules());

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

        $el = new Track;
        $el->title = $title;
        $el->author = $request->author;
        $el->feat = $request->feat ? $request->feat : '';
        $el->beatmaker = $request->beatmaker ? $request->beatmaker : '';
        $el->description = $request->description ? $request->description : '';
        $el->user_id = $user->id;
        $el->file = $file;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $el = Track::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('music')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['user'] = $this->user;
//        return view('images.delete', $data);
        return $this->renderProfileView('tracks.delete', $data);
    }

//     public function destroy(TrackDestroyRequest $request)
//     {
//         Track::destroy($request->id);
//         return redirect()->route('music')->withSuccess(trans('tracks.destroy_success'));
//     }

    public function destroy($id)
    {
        $user = Auth::user();
        $el = Track::findOrFail($id);
        if( $el->user_id != $user->id )
        {
            return redirect()->route('music')->withErrors(['error'=>trans('general.permission_denied')]);
        }
        Track::destroy($id);
        return redirect()->route('music')->withSuccess(trans('tracks.destroy_success'));
    }
}
