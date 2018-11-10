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
                                {{ $item->title }}
                                @if ($user->isId( Auth::user()->id ) )
                                <a href="{!! route('videos.edit', ['id' => $item->id]) !!}" class="btn btn-default">
                                    <i class="fa fa-pencil"></i> {!! trans('profile.admin_link') !!}
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="">
                            <img src='{{ $item->file->url('original') }}' style="width: 100%;" />
                        </div>

                        <!--Tags-->
                        <div class="">
                            @include('widgets.tag_array', ['item' => $item])
                        </div>

                        <!--Footer-->
                        <div class="justify-content-center">
                            @include('widgets.like_button', ['item' => $item, 'class' => Video::class])
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
