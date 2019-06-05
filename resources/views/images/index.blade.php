@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">

			<div class="panel panel-default">
				<div class="panel-heading">
                    <h2 class='pull-left'>{{ trans('images.heading') }}</h2> @include('images.index_option_buttons', ['user'=>$user])
                </div>

                <div class="panel-body">
                    @include('messages.success')
                    @include('messages.errors')

                    <h3>{{ trans('images.albums_list') }}</h3>
                    <div class="row">
                    @foreach ($imagealbums as $album)
                        <div class="col-md-4">
                            <div class="card-container">
                                <div class="card card-shadow">
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
                                                <div class="btn-group">
                                                    <a class="btn btn-default" href="{{ URL::route('imagealbums.edit', $album->id) }}">
                                                        <i class="fa fa-pencil"></i>
                                                        {!! trans('imagealbums.index_btn_edit') !!}
                                                    </a>
                                                    <a data-href="{!! URL::route('imagealbums.destroy', [$album->id]) !!}" data-item_name="{{ $album->title }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                                        <i class="fa fa-trash"></i> {!! trans('imagealbums.index_btn_delete') !!}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="panel-body">
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
                                    <div class="card card-shadow">
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
                                                        <div class="btn-group">
                                                            <a class="btn btn-default" href="{{ URL::route('images.edit', $image->id) }}">
                                                                <i class="fa fa-pencil"></i>
                                                                {{ trans('images.index_btn_edit') }}
                                                            </a>
                                                            <a data-href="{!! URL::route('images.destroy', [$image->id]) !!}" data-item_name="{{ $image->tile }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                                                <i class="fa fa-trash"></i> {!! trans('images.index_btn_delete') !!}
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
    </div>
</div>

@include('modals.confirm')

@endsection
