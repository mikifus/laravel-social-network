@extends('layouts.app')

@section('content')

    <div class="profile">

        @include('profile.widgets.header')


        @if ($can_see)
            <div class="container profile-main">
                <div class="row">
                    <div class="col-xs-12 col-md-3 pull-right">
                        @include('profile.widgets.user_follow_counts')
                    </div>
                    <div class="col-md-9">

                        <div>
                            <div class="pull-right">
                                <a href="{!! route('images.index') !!}">{!! trans('profile.admin_link') !!}</a>
                            </div>
                            <div class="content-page-title">
                                {!! trans('profile.images_header') !!}
                                @if ($user->isId( Auth::user()->id ) )
                                @endif
                            </div>
                        </div>

                        @if(!isset($imagealbums))
                        @elseif ($imagealbums->count() == 0)
                            <div class="alert-message alert-message-danger">
                                {!! trans('profile.images_imagealbums_empty') !!}
                            </div>
                        @else
                            <div class="row">

                                @foreach($imagealbums as $album)


                                    <div class="col-md-6">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <a href="{{ route('imagealbums.slug_view', ['slug' => $album->slug]) }}">
                                                        <div class="cover" style="height: 200px; background-image: url('{{ $album->getCover() }}')"></div>
                                                    </a>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ route('imagealbums.slug_view', ['slug' => $album->slug]) }}">
                                                                <h3 class="name">{{ $album->title }}</h3>
                                                                <p class="profession">
                                                                    {{ str_limit($album->description, $limit = 100, $end = '...') }}
                                                                </p>
                                                                <p class="profession">
                                                                    @include('widgets.category_array', ['item' => $album])
                                                                </p>
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

                        @if($images->count() == 0)
                            <!--<div class="alert-message alert-message-danger">
                                {!! trans('profile.music_tracks_empty') !!}
                            </div>-->
                        @else
                            <div class="row">
                                @foreach($images as $index => $image)
                                <div class="col-lg-4 col-md-12 mb-4">

                                    <!--Modal: Name-->
                                    <div class="modal fade" id="image_modal_{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">

                                            <!--Content-->
                                            <div class="modal-content">
                                                <!--Header-->
                                                <div class="modal-header mb-0 p-0">
                                                    <button type="button" class="btn btn-outlined-default btn-rounded btn-md ml-4 pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                                    <h4>{{ $image->title }}</h4>
                                                </div>

                                                <!--Body-->
                                                <div class="modal-body mb-0 p-0">
                                                    <img style="width: 100%;" src="{{ $image->file->url() }}" alt="{{ $image->title }}" title="{{ $image->title }}">
                                                </div>

                                                <!--Tags-->
                                                <div class="modal-body mb-0 p-0">
                                                    @foreach ($image->tagArray as $tag)
                                                    <span class="tag label label-info">{{ $tag }}</span>
                                                    @endforeach
                                                </div>

                                                <!--Footer-->
                                                <div class="modal-footer justify-content-center">
                                                    @include('widgets.like_button', ['item' => $image, 'class' => Image::class])
                                                </div>

                                            </div>
                                            <!--/.Content-->

                                        </div>
                                    </div>
                                    <!--Modal: Name-->
                                    <div class="card">
                                        <div class="front">
                                            <a style="cursor: pointer;" data-toggle="modal" data-target="#image_modal_{{ $index }}">
                                                <div class="cover" style="height: 200px; background-image: url('{{ $image->getCover() }}')"></div>
                                            </a>
                                                <div class="content">
                                                    <div class="main">
                                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#image_modal_{{ $index }}">
                                                            <h3 class="name">{{ $image->title }}</h3>
                                                        </a>
                                                        <p class="profession">
                                                            @include('widgets.category_array', ['item' => $image])
                                                        </p>
                                                        <p class="profession">
                                                            @include('widgets.tag_array', ['item' => $image])
                                                        </p>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                </div>
<!--                                    <div class="col-md-6">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <div>
                                                        <audio style="width: 100%;" controls src="{{ $image->url }}">
                                                    </div>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ route('imagealbums.slug_view', ['slug' => $image->slug]) }}">
                                                                <h3 class="name">{{ $image->title }}</h3>
                                                                <p class="profession" style="height: 30px;">
                                                                    {{ str_limit($image->tagList, $limit = 50, $end = '...') }}
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
            @include('widgets.profile_private')
        @endif

    </div>

@endsection

@section('footer')
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
