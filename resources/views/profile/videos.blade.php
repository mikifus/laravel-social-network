@extends('layouts.app')

@section('content')

    <div class="profile">

        @include('profile.widgets.header')


        @if ($can_see)
            <div class="container profile-main">
                <div class="row">
                    <div class="col-xs-12 col-md-3 pull-right">
                        @include('profile.widgets.user_follow_counts')
                        <div class="hidden-sm hidden-xs">
                            @include('widgets.suggested_people')
                        </div>
                    </div>
                    <div class="col-md-9">

                        <div>
                            <div class="pull-right">
                                <a href="{!! route('profile.videos') !!}">{!! trans('profile.admin_link') !!}</a>
                            </div>
                            <div class="content-page-title">
                                {!! trans('profile.videos_header') !!}
                                @if ($user->isId( Auth::user()->id ) )
                                @endif
                            </div>
                        </div>

                        @if(!isset($videoalbums))
                        @elseif ($videoalbums->count() == 0)
                            <div class="alert-message alert-message-danger">
                                {!! trans('profile.videos_videoalbums_empty') !!}
                            </div>
                        @else
                            <div class="row">

                                @foreach($videoalbums as $album)


                                    <div class="col-md-6">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <a href="{{ route('videoalbums.slug_view', ['slug' => $album->slug]) }}">
                                                        <div class="cover" style="height: 200px; background-image: url('{{ $album->getCover() }}')"></div>
                                                    </a>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ route('videoalbums.slug_view', ['slug' => $album->slug]) }}">
                                                                <h3 class="name">{{ $album->title }}</h3>
                                                                <p class="profession">
                                                                    {{ str_limit($album->description, $limit = 100, $end = '...') }}
                                                                </p>
                                                                <p class="profession">
                                                                    {{ str_limit(join(', ',$album->tagArray), $limit = 64, $end = '...') }}
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif

                        @if($videos->count() == 0)
                            <!--<div class="alert-message alert-message-danger">
                                {!! trans('profile.music_tracks_empty') !!}
                            </div>-->
                        @else
                            <div class="row">
                                @foreach($videos as $index => $video)
                                <div class="col-lg-4 col-md-12 mb-4">

                                    <!--Modal: Name-->
                                    <div class="modal fade" id="video_modal_{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">

                                            <!--Content-->
                                            <div class="modal-content">

                                                <!--Body-->
                                                <div class="modal-body mb-0 p-0">
                                                    {!! $video->getMediaObjectAttribute()->setAttribute(['width' => "100%",'height' => "400"]) !!}
<!--                                                     <div class="embed-responsive embed-responsive-16by9 z-depth-1-half"> -->
<!--                                                         <iframe class="embed-responsive-item" src="" allowfullscreen></iframe> -->
<!--                                                     </div> -->

                                                </div>

                                                <!--Footer-->
                                                <div class="modal-footer justify-content-center">
                                                    <span class="mr-4">Spread the word!</span>
<!--                                                     <a type="button" class="btn-floating btn-sm btn-fb"><i class="fa fa-facebook"></i></a> -->
                                                    <!--Twitter-->
<!--                                                     <a type="button" class="btn-floating btn-sm btn-tw"><i class="fa fa-twitter"></i></a> -->
                                                    <!--Google +-->
<!--                                                     <a type="button" class="btn-floating btn-sm btn-gplus"><i class="fa fa-google-plus"></i></a> -->
                                                    <!--Linkedin-->
<!--                                                     <a type="button" class="btn-floating btn-sm btn-ins"><i class="fa fa-linkedin"></i></a> -->

                                                    <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>

                                                </div>

                                            </div>
                                            <!--/.Content-->

                                        </div>
                                    </div>
                                    <!--Modal: Name-->
                                    <div class="card">
                                        <div class="front">
                                            <a style="cursor: pointer;" data-toggle="modal" data-target="#video_modal_{{ $index }}">
                                                <div class="cover" style="height: 200px; background-image: url('{{ $video->getCover() }}')"></div>
                                            </a>
                                                <div class="content">
                                                    <div class="main">
                                                        <a style="cursor: pointer;" data-toggle="modal" data-target=""#video_modal_{{ $index }}">
                                                            <h3 class="name">{{ $video->title }}</h3>
                                                        </a>
                                                        <p class="profession">
                                                            {{ str_limit(join(', ',$video->tagArray), $limit = 64, $end = '...') }}
                                                        </p>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                    
<!--                                     <a style="cursor: pointer;"> -->
<!--                                         <img class="img-fluid z-depth-1" style="width: 100%;" src="{{ $video->get_video_thumbnail($video->url) }}" alt="video" data-toggle="modal" data-target="#modal1"> -->
<!--                                         <div class="text-center">{{ $video->title }}</div> -->
<!--                                     </a> -->

                                </div>
<!--                                    <div class="col-md-6">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <div>
                                                        <audio style="width: 100%;" controls src="{{ $video->url }}">
                                                    </div>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ route('videoalbums.slug_view', ['slug' => $video->slug]) }}">
                                                                <h3 class="name">{{ $video->title }}</h3>
                                                                <p class="profession" style="height: 30px;">
                                                                    {{ str_limit($video->tagList, $limit = 50, $end = '...') }}
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <div class="alert-message alert-message-default">
                    <h4>{{ '@'.$user->username."'s" }} profile is private.</h4>
                    <p>Please follow to see {{ '@'.$user->username."'s" }} profile.</p>
                </div>
            </div>
        @endif

    </div>

@endsection

@section('footer')
    <script src="{{ asset('js/profile.js') }}"></script>

@endsection
