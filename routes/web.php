<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('layouts.guest');
    });
});

// Auth routes
Auth::routes();

// Public routes
Route::get('/public/music', 'PublicController@music')->name('public.music');
// Route::match(array('GET', 'POST'), '/public/music/search', 'PublicController@search')->name('public.music.search');
Route::get('/public/images', 'PublicController@images')->name('public.images');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings', 'SettingsController@index');
Route::post('/settings', array(
    'as' => 'settings',
    'uses' => 'SettingsController@update'
));


// Posts
Route::get('/posts/list', 'PostsController@fetch');
Route::post('/posts/new', 'PostsController@create');
Route::post('/posts/delete', 'PostsController@delete');
Route::post('/posts/like', 'PostsController@like');
Route::post('/posts/likes', 'PostsController@likes');
Route::post('/posts/comment', 'PostsController@comment');
Route::post('/posts/comments/delete', 'PostsController@deleteComment');
Route::get('/post/{id}', 'PostsController@single');
Route::post('/posts/link_preview', 'PostsController@linkPreview')->name('posts.link_preview');

// Search
Route::get('/search', 'HomeController@search');


// Groups
Route::get('/groups', 'GroupController@index');
Route::get('/group/{id}', 'GroupController@group');
Route::get('/group/{id}/stats', 'GroupController@stats');


// Follow
Route::post('/follow', 'FollowController@follow');
Route::get('/followers/pending', 'FollowController@pending');
Route::post('/follower/request', 'FollowController@followerRequest');
Route::post('/follower/denied', 'FollowController@followDenied');

// Relatives
Route::get('/relatives/pending', 'RelativesController@pending');
Route::post('/relative/delete', 'RelativesController@delete');
Route::post('/relative/request', 'RelativesController@relativeRequest');


// Nearby
Route::get('/nearby', 'NearbyController@index');

// Messages
Route::get('/direct-messages', 'MessagesController@index');
Route::get('/direct-messages/show/{id}', 'MessagesController@index');
Route::post('/direct-messages/chat', 'MessagesController@chat');
Route::post('/direct-messages/send', 'MessagesController@send');
Route::post('/direct-messages/new-messages', 'MessagesController@newMessages');
Route::post('/direct-messages/people-list', 'MessagesController@peopleList');
Route::post('/direct-messages/delete-chat', 'MessagesController@deleteChat');
Route::post('/direct-messages/delete-message', 'MessagesController@deleteMessage');
Route::post('/direct-messages/notifications', 'MessagesController@notifications');

// Find Location
Route::get('/find-my-location', 'FindLocationController@index');
Route::get('/save-my-location', 'FindLocationController@save');
Route::get('/save-my-location2', 'FindLocationController@save2');

// Profile
Route::get('/{username}', 'ProfileController@index');
Route::post('/{username}/upload/profile-photo', 'ProfileController@uploadProfilePhoto');
Route::post('/{username}/upload/cover', 'ProfileController@uploadCover');
Route::post('/{username}/save/information', 'ProfileController@saveInformation');
Route::get('/{username}/following', 'ProfileController@following');
Route::get('/{username}/followers', 'ProfileController@followers');
Route::post('/{username}/save/hobbies', 'ProfileController@saveHobbies');
Route::post('/{username}/save/relationship', 'ProfileController@saveRelationship');


/**
 * Multimedia
 */
// Images
//Route::group(['middleware' => 'web'], function() {
    Route::get('profile/images', ['as' => 'images.index', 'uses' => 'ImagesController@getIndex']);
    Route::get('profile/images/add', ['as' => 'images.add', 'uses' => 'ImagesController@getAdd']);
    Route::post('profile/images/add', ['as' => 'images.store_async', 'uses' => 'ImagesController@storeAsync']);
    Route::get('profile/images/edit/{id}', ['as' => 'images.edit', 'uses' => 'ImagesController@getEdit']);
    Route::post('profile/images/udpate/{id}', ['as' => 'images.update', 'uses' => 'ImagesController@update']);
//     Route::get('profile/images/delete/{id}', ['as' => 'images.destroy', 'uses' => 'ImagesController@getDelete']);
//     Route::post('profile/images/delete', ['as' => 'images.delete', 'uses' => 'ImagesController@destroy']);
    Route::get('profile/images/destroy/{id}', ['as' => 'images.destroy', 'uses' => 'ImagesController@destroy']);
    Route::get('/{username}/images/', ['as' => 'images_profile_path', 'uses' => 'ImagesController@showUser']);
    Route::get('image/{slug}', ['as' => 'images.slug_view', 'uses' => 'ImagesController@showSlug']);
    Route::get('/images/autocomplete_tags/{term}', ['as' => 'images.autocomplete_tags', 'uses' => 'ImagesController@autocompleteTags']);
//});

//imagealbum Routes
//Route::group(['middleware' => 'web'], function() {
//    Route::get('imagealbums/add', [ 'as' => 'imagealbums.add', 'uses' => 'ImagealbumsController@getAdd' ]);
    Route::post('profile/imagealbums/store', ['as' => 'imagealbums.store', 'uses' => 'ImagealbumsController@store']);
    Route::get('profile/imagealbums/edit/{id}', ['as' => 'imagealbums.edit', 'uses' => 'ImagealbumsController@getEdit']);
    Route::post('profile/imagealbums/edit/{id}', ['as' => 'imagealbums.update', 'uses' => 'ImagealbumsController@update']);
    Route::get('profile/imagealbums/delete/{id}', ['as' => 'imagealbums.destroy', 'uses' => 'ImagealbumsController@destroy']);
    Route::get('/imagealbums/autocomplete_tags/{term}', ['as' => 'imagealbums.autocomplete_tags', 'uses' => 'ImagealbumsController@autocompleteTags']);
    Route::get('imagealbums/{slug}', ['as' => 'imagealbums.slug_view', 'uses' => 'ImagealbumsController@showSlug']);
//});

// Videos
Route::get('profile/videos', ['as' => 'profile.videos', 'uses' => 'VideosController@getIndex']);
Route::get('profile/videos/add', ['as' => 'videos.add', 'uses' => 'VideosController@getAdd']);
Route::post('profile/videos/add', ['as' => 'videos.store', 'uses' => 'VideosController@store']);
Route::get('profile/videos/edit/{id}', ['as' => 'videos.edit', 'uses' => 'VideosController@getEdit']);
Route::post('profile/videos/edit/{id}', ['as' => 'videos.update', 'uses' => 'VideosController@update']);
Route::get('profile/videos/delete/{id}', ['as' => 'videos.destroy', 'uses' => 'VideosController@destroy']);
Route::get('/videos/autocomplete_tags/{term}', ['as' => 'videos.autocomplete_tags', 'uses' => 'VideosController@autocompleteTags']);

Route::get('/{username}/videos/', ['as' => 'videos_profile_path', 'uses' => 'VideosController@showUser']);
Route::get('videos/{slug}', ['as' => 'videos.slug_view', 'uses' => 'VideosController@showSlug']);


//videoalbum Routes
//Route::group(['middleware' => 'web'], function() {
    Route::get('profile/videoalbums/add', ['as' => 'videoalbums.add', 'uses' => 'VideoalbumsController@getAdd']);
    Route::post('profile/videoalbums/store', ['as' => 'videoalbums.store', 'uses' => 'VideoalbumsController@store']);
    Route::get('profile/videoalbums/edit/{id}', ['as' => 'videoalbums.edit', 'uses' => 'VideoalbumsController@getEdit']);
    Route::post('profile/videoalbums/edit/{id}', ['as' => 'videoalbums.update', 'uses' => 'VideoalbumsController@update']);
    Route::get('profile/videoalbums/delete/{id}', ['as' => 'videoalbums.destroy', 'uses' => 'VideoalbumsController@destroy']);
    Route::get('/videoalbums/autocomplete_tags/{term}', ['as' => 'videoalbums.autocomplete_tags', 'uses' => 'VideoalbumsController@autocompleteTags']);
    Route::get('videoalbums/{slug}', ['as' => 'videoalbums.slug_view', 'uses' => 'VideoalbumsController@showSlug']);
//    Route::get('videoalbums', [ 'as' => 'videoalbums.index', 'uses' => 'VideoalbumsController@getIndex' ]);
//  Route::resource('videoalbum','\App\Http\Controllers\VideoalbumController');
//  Route::post('videoalbums/{id}/update', [ 'as' => 'videoalbums.index', 'uses' => '\App\Http\Controllers\VideoalbumsController@update' ]);
//  Route::get('videoalbums/{id}/delete', [ 'as' => 'videoalbums.index', 'uses' => '\App\Http\Controllers\VideoalbumsController@destroy' ]);
//  Route::get('videoalbums/{id}/deleteMsg', [ 'as' => 'videoalbums.index', 'uses' => '\App\Http\Controllers\VideoalbumsController@DeleteMsg' ]);
//});


/**
 * Music
 */
//Route::post('videos/add', [ 'as' => 'videos.store', 'uses' => 'VideosController@store' ]);
//Route::post('videos/delete', [ 'as' => 'videos.destroy', 'uses' => 'VideosController@destroy' ]);

Route::get('profile/music', ['as' => 'profile.music', 'uses' => 'MusicController@getIndex']);

Route::get('/{username}/music', ['as' => 'music_profile_path', 'uses' => 'MusicController@showUser']);

// Track management
Route::get('profile/tracks/add', ['as' => 'tracks.add', 'uses' => 'TracksController@getAdd']);

Route::post('profile/tracks/add', ['as' => 'tracks.store_async', 'uses' => 'TracksController@storeAsync']);

Route::get('profile/tracks/destroy/{id}', ['as' => 'tracks.destroy', 'uses' => 'TracksController@destroy']);

Route::post('profile/tracks/delete', ['as' => 'tracks.delete', 'uses' => 'TracksController@getDelete']);

Route::get('profile/track/{slug}', ['as' => 'tracks.slug_view', 'uses' => 'TracksController@showSlug']);
Route::get('tracks/autocomplete_tags/{term}', ['as' => 'tracks.autocomplete_tags', 'uses' => 'TracksController@autocompleteTags']);

//Route::controller('tracks', 'TracksController'); // The specific routes are declared first
// Music album management
Route::get('profile/musicalbums/add', ['as' => 'musicalbums.add', 'uses' => 'MusicalbumsController@getAdd']);
Route::post('profile/musicalbums/add', ['as' => 'musicalbums.store', 'uses' => 'MusicalbumsController@store']);

Route::get('profile/musicalbums/edit/{id}', ['as' => 'musicalbums.edit', 'uses' => 'MusicalbumsController@getEdit']);
Route::post('profile/musicalbums/edit/{id}', ['as' => 'musicalbums.store_update', 'uses' => 'MusicalbumsController@storeUpdate']);

Route::get('profile/musicalbums/add_images/{id}', ['as' => 'musicalbums.add_images', 'uses' => 'MusicalbumsController@getAddImages']);
Route::post('profile/musicalbums/add_images/{id}', ['as' => 'musicalbums.store_images', 'uses' => 'MusicalbumsController@storeImages']);
Route::post('profile/musicalbums/destroy_images/{id}', ['as' => 'musicalbums.destroy_images', 'uses' => 'MusicalbumsController@destroyImages']);
Route::post('profile/musicalbums/finish_images/{id}', ['as' => 'musicalbums.finish_images', 'uses' => 'MusicalbumsController@finishImages']);

Route::get('profile/musicalbums/add_tracks/{id}', ['as' => 'musicalbums.add_tracks', 'uses' => 'MusicalbumsController@getAddTracks']);
Route::post('profile/musicalbums/add_tracks/{id}', ['as' => 'musicalbums.store_tracks', 'uses' => 'MusicalbumsController@storeTracks']);
Route::get('profile/musicalbums/destroy_tracks/{id}/{track_id}', ['as' => 'musicalbums.destroy_tracks', 'uses' => 'MusicalbumsController@destroyTracks']);
Route::post('profile/musicalbums/finish_tracks/{id}', ['as' => 'musicalbums.finish_tracks', 'uses' => 'MusicalbumsController@finishTracks']);
Route::get('profile/musicalbums/sort_tracks/{id}', ['as' => 'musicalbums.sort_tracks', 'uses' => 'MusicalbumsController@getSortTracks']);
Route::post('profile/musicalbums/sort_tracks/{id}', ['as' => 'musicalbums.save_sort_tracks', 'uses' => 'MusicalbumsController@saveSortTracks']);
Route::get('profile/musicalbums/publish/{id}', ['as' => 'musicalbums.publish', 'uses' => 'MusicalbumsController@getPublish']);
Route::post('profile/musicalbums/publish/{id}', ['as' => 'musicalbums.finish_publish', 'uses' => 'MusicalbumsController@finishPublish']);

Route::get('profile/musicalbums/delete/{id}', ['as' => 'musicalbums.delete', 'uses' => 'MusicalbumsController@destroy']);

Route::get('musicalbums/{slug}', ['as' => 'musicalbums.slug_view', 'uses' => 'MusicalbumsController@showSlug']);

Route::get('/musicalbums/autocomplete_tags/{term}', ['as' => 'musicalbums.autocomplete_tags', 'uses' => 'MusicalbumsController@autocompleteTags']);

// Likes and rating
Route::post('likes/toggle', ['as' => 'like.toggle', 'uses' => 'LikeController@toggle']);
Route::post('likes/rate', ['as' => 'like.rate', 'uses' => 'LikeController@rate']);

