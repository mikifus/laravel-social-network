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
                <ul class="media-list">
                    @foreach ($imagealbums as $item)
                        <li class="media">
                            <div class="media-left">
                                @if (!is_null($item->thumb()))
                                <img src='{{ $item->thumb()->file->url('thumb') }}' />
                                @else
                                <div class="alert alert-warning">{{ trans('imagealbums.empty') }}</div>
                                @endif
                            </div>
                            <div class="media-body">
                                <a href="{{ URL::route('imagealbums.slug_view', [$item->slug]) }}">
                                    <h3 class="media-heading">{{ $item->title }}</h3>
                                </a>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="{{ URL::route('imagealbums.edit', $item->id) }}">
                                        <i class="fa fa-pencil"></i>
                                        {!! trans('imagealbums.index_btn_edit') !!}
                                    </a>
                                    <div>{!! $item->tagList !!}</div>
                                    <a data-href="{!! URL::route('imagealbums.destroy', [$item->id]) !!}" data-item_name="{{ $item->title }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                        <i class="fa fa-trash"></i> {!! trans('imagealbums.index_btn_delete') !!}
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="panel-body">
                <h3>{{ trans('images.images_list') }}</h3>
                <ul class="media-list">
                    @foreach ($images as $item)
                        <li class="media">
                            <div class="media-left">
                                <img src='{{ $item->file->url('thumb') }}' />
                            </div>
                            <div class="media-body">
                                <a href="{{ URL::route('images.slug_view', [$item->slug]) }}">
                                    <h3 class="media-heading">{{ $item->title }}</h3>
                                </a>
                                <div>{!! $item->tagList !!}</div>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="{{ URL::route('images.edit', $item->id) }}">
                                        <i class="fa fa-pencil"></i>
                                        {{ trans('images.index_btn_edit') }}
                                    </a>
                                    <a data-href="{!! URL::route('images.destroy', [$item->id]) !!}" data-item_name="{{ $item->tile }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                        <i class="fa fa-trash"></i> {!! trans('images.index_btn_delete') !!}
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
    </div>
</div>

@include('modals.confirm')

@endsection
