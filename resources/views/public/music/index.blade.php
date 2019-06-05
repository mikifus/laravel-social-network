@extends('layouts.public')

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>{{ trans('music.heading') }}</h2>
                </div>

                <div class="panel-body">
                    @if (count($musicalbums) )
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
    </div>
</div>

@endsection

