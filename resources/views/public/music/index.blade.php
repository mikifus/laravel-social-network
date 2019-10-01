@extends('layouts.public')

@section('content')

@include('public.widgets.header', ['title_text' => trans('music.heading')])

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (count($musicalbums) )
                <h3 class="text-center">{{ trans('music.albums') }}</h3>
                <div class="h-20"></div>
                <div class="row">
                @foreach ($musicalbums as $album)
                    <div class="col-md-6">
                        <div class="card-container">
                            <div class="card card-shadow">
                                <div class="front">
                                    <a href="{{ route('musicalbums.slug_view', ['slug' => $album->slug]) }}">
                                        <div class="cover" style="height: 200px; background-image: url('{{ $album->getCover('medium') }}')"></div>
                                    </a>
                                    <div class="content">
                                        <div class="main">
                                            @if ($album->status == \App\Models\Musicalbum::$STATUS_CREATED)
                                            <a href="{{ route('musicalbums.edit', [$album->id]) }}">
                                                <h3 class="name">{{ $album->title }}</h3>
                                            </a>
                                            <div class="alert alert-warning">{{ trans('music.alert_unfinished_album') }}</div>
                                            @else
                                            <a href="{{ route('musicalbums.slug_view', ['slug' => $album->slug]) }}">
                                                <h3 class="name">{{ $album->title }}</h3>
                                            </a>
                                            @endif
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

            @if (count($tracks) )
                <h3 class="text-center">{{ trans('music.tracks') }}</h3>
                <div class="h-20"></div>
                <div class="row">
                @foreach ($tracks as $track)
                    <div class="col-md-6">
                        <div class="card-container">
                            <div class="card card-shadow">
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
                                                <p class="profession" style="height: 30px;">
                                                    @include('widgets.tag_array', ['item' => $track])
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
        </div>
    </div>
</div>

@endsection

