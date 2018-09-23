<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\UserProfileController;
use Auth;
use App\Models\User;

class MusicController extends UserProfileController
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

        // Albums
        if( $user->isId( Auth::user()->id ) ) {
            $musicalbums = $user->musicalbums()->orderBy('id', 'desc')->get();
        } else {
            $musicalbums = $user->publishedMusicalbums()->orderBy('id', 'desc')->get();
        }

        // Tracks
        $tracks = $user->tracks()->orderBy('id', 'desc')->get();
        

        $data = [];
        $data['musicalbums'] = $musicalbums;
        $data['tracks'] = $tracks;
        $data['user'] = $user;

        return $this->renderProfileView('profile.music', $data);
    }

    public function showUser($username) {
        if (empty($username)) {
            return redirect()->route('music');
        } else if (!$this->secure($username)) {
            return abort(404);
        } else {
            $user = User::where('username', $username)->first();
        }

        // Albums
//         if( $user->isId( Auth::user()->id ) ) {
//             $musicalbums = $user->musicalbums()->orderBy('id', 'desc')->get();
//         } else {
//             $musicalbums = $user->publishedMusicalbums()->orderBy('id', 'desc')->get();
//         }
        $musicalbums = $user->publishedMusicalbums()->orderBy('id', 'desc')->get();
        
        
//         $can_see = $user->canSeeProfile(Auth::id());

        // Tracks
        $tracks = $user->tracks()->orderBy('id', 'desc')->get();
        

        $data = [];
        $data['musicalbums'] = $musicalbums;
        $data['tracks'] = $tracks;
        $data['user'] = $user;
        $data['can_see'] = $user->canSeeProfile(Auth::id());

        return $this->renderProfileView('profile.music', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
