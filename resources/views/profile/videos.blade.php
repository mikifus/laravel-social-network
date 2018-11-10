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
                            <div class="content-page-title">
                                {!! trans('profile.videos_header') !!}
                                @if ($user->isId( Auth::user()->id ) )
                                <a href="{!! route('profile.videos') !!}" class="btn btn-default">
                                    <i class="fa fa-pencil"></i> {!! trans('profile.admin_link') !!}
                                </a>
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
                                                                <h3 class="name">{{ $album->name }}</h3>
                                                                <p class="profession">
                                                                    @include('widgets.tag_array', ['item' => $album])
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
                                                <!--Header-->
                                                <div class="modal-header mb-0 p-0">
                                                    <button type="button" class="btn btn-outlined-default btn-rounded btn-md ml-4 pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                                    <h4>{{ $video->title }}</h4>
                                                </div>

                                                <!--Body-->
                                                <div class="modal-body mb-0 p-0">
                                                    {!! $video->getMediaObjectAttribute()->setAttribute(['width' => "100%",'height' => "400"]) !!}
                                                </div>

                                                <!--Tags-->
                                                <div class="modal-body mb-0 p-0">
                                                    @foreach ($video->tagArray as $tag)
                                                    <span class="tag label label-info">{{ $tag }}</span>
                                                    @endforeach
                                                </div>

                                                <!--Footer-->
                                                <div class="modal-footer justify-content-center">
                                                    @include('widgets.like_button', ['item' => $video, 'class' => Video::class])
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
                                                    <a style="cursor: pointer;" data-toggle="modal" data-target="#video_modal_{{ $index }}">
                                                        <h3 class="name">{{ $video->title }}</h3>
                                                    </a>
                                                    <p class="profession">
                                                        @include('widgets.tag_array', ['item' => $video])
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @else
            @include('widgets.profile_private')
        @endif

    </div>

@endsection

@section('footer')
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
