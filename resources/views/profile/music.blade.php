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
                                                        <audio style="width: 100%;" controls src="{{ $track->file->url() }}">
                                                    </div>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ route('musicalbums.slug_view', ['slug' => $track->slug]) }}">
                                                                <h3 class="name">{{ $track->title }}</h3>
                                                                <p class="profession" style="height: 30px;">
                                                                    {{ str_limit($track->description, $limit = 100, $end = '...') }}
                                                                </p>
                                                                <p class="profession" style="height: 30px;">
                                                                    {{ str_limit(join(', ',$track->tagArray), $limit = 64, $end = '...') }}
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
