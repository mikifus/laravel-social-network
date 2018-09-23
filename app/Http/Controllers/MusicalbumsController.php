<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\UserProfileController;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Response;

use App\Models\Musicalbum;
use App\Models\MusicalbumTrack;
use App\Http\Requests;
use App\Http\Requests\MusicalbumAddRequest;
use App\Http\Requests\MusicalbumImagesAddRequest;
use App\Http\Requests\MusicalbumEditRequest;
use App\Http\Requests\MusicalbumAddTrackRequest;
use App\Http\Requests\MusicalbumPublishRequest;
use Illuminate\Support\Facades\Validator;
use Auth;
use Input;
use View;

class MusicalbumsController extends UserProfileController
{
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function showSlug($slug)
    {
        $el = Musicalbum::findBySlug($slug);
        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        $data['tracks'] = $el->tracks()->get();
        return $this->renderProfileView('musicalbums.view', $data);
    }

    private function redirectIfNotEditable($el) {
        if( empty($el) )
        {
            abort(404);
        }
        if( $el->status == Musicalbum::$STATUS_PUBLISHED )
        {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {
        View::share('steps', $this->getStepsConfig(1, 0));

        return $this->renderProfileView('musicalbums.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MusicalbumAddRequest $request)
    {
        $user = Auth::user();
        $el = new Musicalbum;
        $el->user_id = $user->id;
        $el->title = $request->title;
        $el->author = $request->author;
        $el->status = Musicalbum::$STATUS_CREATED;
        $el->description = $request->description;
        try {
            $el->save();
            $el->tag(trim(strip_tags($request->tags)));
        }
        catch (\Exception $e)
        {
            $el->delete();
            return back()->withErrors(['error' => "Unexpected error."]);
        }
        return redirect()->route('musicalbums.add_images', [ $el->id ])
                ->withSuccess(trans('musicalbum.add_success_continue'))
                ->withInput(Input::all());
    }

    /**
     * Show the form for editing an existing resource.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $data = [];
        $data['id'] = $el->id;
        $data['item'] = $el;
        View::share('steps', $this->getStepsConfig(1, $id));
        return $this->renderProfileView('musicalbums.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUpdate($id, MusicalbumEditRequest $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $el->description = $request->description;
        try {
            $el->save();
            $el->retag(trim(strip_tags($request->tags)));
        }
        catch (\Exception $e)
        {
            $el->delete();
            return back()->withErrors(['error' => "Unexpected error."])
                ->withInput(Input::all());
        }
        return redirect()->route('musicalbums.add_images', [ $el->id ])
                ->withSuccess(trans('musicalbum.add_success_continue'));
    }

    /**
     * Show the form for uploading the images.
     *
     * @return Response
     */
    public function getAddImages($id)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $data = [];
        $data['item'] = $el;
        View::share('steps', $this->getStepsConfig(2, $id));
        return $this->renderProfileView('musicalbums.add_images', $data);
    }

    /**
     * Store an image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImages($id, MusicalbumImagesAddRequest $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        if( empty($el) || $el->status == Musicalbum::$STATUS_PUBLISHED )
        {
            return Response::json([
                'error' => true,
                'message' => "Element not found.",
                'code' => 400
            ], 400);
        }
        switch ($request->cover) {
            case 'front':
                $el->front->destroy();
                $el->front = $request->file;
                break;
            case 'back':
                $el->back->destroy();
                $el->back = $request->file;
                break;
            default:
                return Response::json([
                    'error' => true,
                    'message' => "Unexpected error.",
                    'code' => 400
                ], 400);
        }
        try {
            $el->save();
        }
        catch (\Exception $e)
        {
            return Response::json([
                'error' => true,
//                'message' => "Unexpected error: " . $e->getMessage(),
                'message' => "Unexpected error.",
                'code' => 400
            ], 400);
        }
        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }


    /**
     * Destroy an image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyImages($id, Request $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        if( empty($el) || $el->status == Musicalbum::$STATUS_PUBLISHED )
        {
            return Response::json([
                'error' => true,
                'message' => "Element not found.",
                'code' => 400
            ], 400);
        }
        switch ($request->cover) {
            case 'front':
                $el->front = STAPLER_NULL;
                break;
            case 'back':
                $el->back = STAPLER_NULL;
                break;
            default:
                return Response::json([
                    'error' => true,
                    'message' => "Unexpected error.",
                    'code' => 400
                ], 400);
        }
        try {
            $el->save();
        }
        catch (\Exception $e)
        {
            return Response::json([
                'error' => true,
                'message' => "Unexpected error.",
                'code' => 400
            ], 400);
        }
        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finishImages($id, Request $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        return redirect()->route('musicalbums.add_tracks', [ $el->id ])
                ->withSuccess(trans('musicalbum.add_images_success_continue'));
    }

    /**
     * Show the form for uploading the tracks.
     *
     * @return Response
     */
    public function getAddTracks($id)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $data = [];
        $data['item'] = $el;
        $data['tracks'] = $el->tracks()->orderBy('position')->get();
        View::share('steps', $this->getStepsConfig(3, $id));
        return $this->renderProfileView('musicalbums.add_tracks', $data);
    }

    public function storeTracks($id, Request $request)
    {
        $user = Auth::user();
        $musicalbum = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($musicalbum);

        $trackAddRequest = new MusicalbumAddTrackRequest();

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

        $el = new \App\Models\MusicalbumTrack;
        $el->title = $title;
        $el->musicalbum_id = $musicalbum->id;
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
                'file' => " File ".$e->getFile()." Line ".$e->getLine(),
                'trace' => " Trace ".$e->getTraceAsString()." Line ".$e->getLine(),
                'code' => 400
            ], 400);
        }

        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    public function destroyTracks($id, $track_id)
    {
        $user = Auth::user();
        $musicalbum = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($musicalbum);

        $track = $musicalbum->tracks()->find($track_id);

        if( empty( $track ) )
        {
            return redirect()->route('musicalbums.add_tracks', ['id' => $id]);
        }

        MusicalbumTrack::destroy( $track->id);
        return redirect()->route('musicalbums.add_tracks', ['id' => $id])
                ->withSuccess(trans('tracks.destroy_success'));
    }

    /**
     * Checks if the tracks are ready
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finishTracks($id, Request $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        if( $el->tracks()->count() < 3 )
        {
            return back()->withErrors(trans('musicalbums.minimum_tracks_required'));
        }

        return redirect()->route('musicalbums.sort_tracks', ['id' => $id])
                ->withSuccess(trans('musicalbum.add_images_success_continue'));
    }

    /**
     * Show the form for sorting the tracks.
     *
     * @return Response
     */
    public function getSortTracks($id)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $tracks = $el->tracks()->orderBy('position')->get();

        $data = [];
        $data['item'] = $el;
        $data['tracks'] = $tracks;
        View::share('steps', $this->getStepsConfig(4, $id));
        return $this->renderProfileView('musicalbums.sort_tracks', $data);
    }

    /**
     * Save the tracks order.
     *
     * @return Response
     */
    public function saveSortTracks($id, Request $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $order_string = $request->get('order');
        $order = explode(',', $order_string);

        $tracks = $el->tracks()->get()->pluck('id')->toArray();
        foreach ($order as $id_order)
        {
            if( !in_array($id_order, $tracks) )
            {
                return redirect()->route('musicalbums.sort_tracks', ['id' => $id])
                        ->withErrors(trans('unexpected_error'));
            }
        }

        MusicalbumTrack::setNewOrder($order, 0);

        return redirect()->route('musicalbums.publish', ['id' => $id])
                ->withSuccess(trans('musicalbum.sort_success_continue'));

    }

    public function getPublish($id) {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $tracks = $el->tracks()->orderBy('position')->get();
        $images = $el->tracks()->orderBy('position')->get();

        $data = [];
        $data['item'] = $el;
        $data['tracks'] = $tracks;
        View::share('steps', $this->getStepsConfig(5, $id));

        return $this->renderProfileView('musicalbums.publish', $data);
    }

    /**
     * Final method that will close the edition of a musicalbum
     *
     * @return Response
     */
    public function finishPublish($id, MusicalbumPublishRequest $request)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $license_type = $request->get('license_type');
        $license_params = "";
        switch ($license_type) {
            case 'copyright':
                $license_params = $request->get('copyright_string');
                break;
            case 'cc':
                $license_params = $request->get('cc_license');
                break;
        }

        $el->license_type = $license_type;
        $el->license_params = $license_params;

        // After here, not editable anymore
        $el->status = Musicalbum::$STATUS_PUBLISHED;
        $el->save();

        return redirect()->route('musicalbums.slug_view', ['slug' => $el->slug])
                ->withSuccess(trans('musicalbum.publish_success'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
//    public function getDelete($id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $el = $user->musicalbums()->find($id);
        $this->redirectIfNotEditable($el);

        $el->delete();
        // TODO: Check if images and songs are also deleted.

        return redirect()->route('music');
    }

    /**
     * Makes the steps view configuration
     *
     * @return array
     */
    protected function getStepsConfig( $current_step, $id ) {
        $disable = [1,2,3,4,5,6];

        if( $id > 0 ) {
            unset($disable[ $current_step - 1 ]);
            unset($disable[array_search(2, $disable) ]);
            unset($disable[array_search(3, $disable) ]);

            $user = Auth::user();
            $el = $user->musicalbums()->find($id);
            if( $el->tracks()->count() >= 3 ) {
                unset($disable[array_search(4, $disable) ]);
                unset($disable[array_search(5, $disable) ]);
            }
        }

        return [
            'step' => $current_step,
            'disabled' => $disable,
        ];
    }

    /**
     * Async method for tags field autocomplete
     *
     * @param string $value
     * @return Response
     */
    protected function autocompleteTags($term)
    {
        return Response::json(Musicalbum::searchModelTags($term));
    }
}
