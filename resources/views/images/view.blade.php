@extends('layouts.app')

@section('content')

    <div class="profile">

        @include('profile.widgets.header')


        @if ($can_see)
            <div class="container profile-main">
                <div class="row">
                    <div class="col-md-9">

                        <div>
                            <div class="pull-right">
                                @include('widgets.like_button', ['item' => $item, 'class' => Image::class])
                                @include('widgets.rating_stars', ['item' => $item, 'class' => Image::class])
                            </div>
                            <div class="content-page-title">
                                <div>{{ $item->title }}</div>
                                <div>
                                    @if ($user->isId( Auth::user()->id ) )
                                    <a href="{!! route('videos.edit', ['id' => $item->id]) !!}" class="btn btn-default">
                                        <i class="fa fa-pencil"></i> {!! trans('profile.admin_link') !!}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="">
                            <img src='{{ $item->file->url('original') }}' style="width: 100%;" />
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                            {{ $item->description }}
                            </div>
                            <div class="panel-body">
                            @include('widgets.tag_array', ['item' => $item])
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-md-3">
                        @include('profile.widgets.user_follow_counts')
                        <div>
                            @include('widgets.item_liked', ['item' => $item])
                        </div>
                        <div class="text-center">
                            <vue-goodshare></vue-goodshare>
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
