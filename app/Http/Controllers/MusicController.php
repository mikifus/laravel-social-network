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
        return $this->showUser($user->username);
    }

    public function showUser($username) {
        if (empty($username)) {
            $user = Auth::user();
        } else if (!$this->secure($username)) {
            return redirect('/404');
        } else {
            $user = User::where('username', $username)->first();
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

        return $this->renderProfileView('music.index', $data);
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
