@extends('layouts.app')

@section('content')

    <div class="profile">

        @include('profile.widgets.header')


        @if ($can_see)
            <div class="container profile-main">
                <div class="row">
                    <div class="col-xs-12 col-md-3 pull-right">
                        @include('profile.widgets.user_follow_counts')
                        <div>
                            @include('widgets.item_liked', ['item' => $item])
                        </div>
                        <div class="text-center">
                            <vue-goodshare></vue-goodshare>
                        </div>
                    </div>
                    <div class="col-md-9">

                        <div>
                            <div class="pull-right">
                                @include('widgets.like_button', ['item' => $item, 'class' => Musicalbum::class])
                            </div>
                            <div class="content-page-title">
                                <h1>{!! $item->title !!}</h1>
                                {!! $item->author !!}
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                            @if ($item->front->originalFilename())
                                <img style='width: 100%;' src="{{ $item->front->url() }}">
                            @endif
                            @if ($item->back->originalFilename())
                                <img style='width: 100%;' src="{{ $item->back->url() }}">
                            @endif
                            </div>

                            <div class="col-md-6">
                            
                                <aplayer
                                    :music="{{ $first_track }}"
                                    :list="{{ $tracklist }}"
                                    ></aplayer>
                                
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                    {!! $item->description !!}
                                    </div>
                                    <div class="panel-body">
                                        @foreach ($item->tagArray as $tag)
                                        <span class="tag label label-info">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                    <div class="panel-body text-center">
                                        @include('widgets.license', ['item' => $item])
                                    </div>
                                </div>
                            </div>
                        </div>
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
