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
                                <a href="{!! route('profile.music') !!}">{!! trans('profile.admin_link') !!}</a>
                            </div>
                            <div class="content-page-title">
                                {!! trans('profile.music_header') !!}
                                @if ($user->isId( Auth::user()->id ) )
                                @endif
                            </div>
                        </div>

                        @if($musicalbums->count() == 0)
                            <div class="alert-message alert-message-danger">
                                {!! trans('profile.music_musicalbums_empty') !!}
                            </div>
                        @else
                            <div class="row">

                                @foreach($musicalbums as $album)


                                    <div class="col-md-6">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <a href="{{ route('musicalbums.slug_view', ['slug' => $album->slug]) }}">
                                                        <div class="cover" style="height: 200px; background-image: url('{{ $album->getCover('medium') }}')"></div>
                                                    </a>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ route('musicalbums.slug_view', ['slug' => $album->slug]) }}">
                                                                <h3 class="name">{{ $album->title }}</h3>
                                                            </a>
                                                            <p class="profession">
                                                                @include('widgets.tag_array', ['item' => $album])
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif

                        @if($tracks->count() == 0)
                            <!--<div class="alert-message alert-message-danger">
                                {!! trans('profile.music_tracks_empty') !!}
                            </div>-->
                        @else
                            <div class="row">
                                @foreach($tracks as $track)
                                    <div class="col-md-6">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <div>
                                                        <aplayer
                                                            :music="{{ $track->track_json() }}"
                                                            ></aplayer>
                                                    </div>
                                                    <div class="content">
                                                        <div class="main">
<!--                                                             <a href="{{ route('musicalbums.slug_view', ['slug' => $track->slug]) }}"> -->
                                                                
                                                                <p class="profession" style="height: 30px;">
                                                                    {{ str_limit($track->description, $limit = 100, $end = '...') }}
                                                                </p>
                                                                <p class="profession text-center">
                                                                    @include('widgets.like_button', ['item' => $track, 'class' => Track::class])
                                                                    @include('widgets.rating_stars', ['item' => $track, 'class' => Track::class])
                                                                </p>
                                                                <p class="profession" style="height: 30px;">
                                                                    @include('widgets.tag_array', ['item' => $track])
                                                                </p>
<!--                                                             </a> -->
                                                        </div>
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
