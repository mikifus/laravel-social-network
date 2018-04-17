@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <p>
                <a href="{{ URL::route('musicalbums.add') }}">
                    <button class="btn btn-primary" >
                        {{ trans('musicalbums.index_btn_add') }}
                    </button>
                </a>
                <a href="{{ URL::route('tracks.add') }}">
                    <button class="btn btn-primary" >
                        {{ trans('tracks.index_btn_add') }}
                    </button>
                </a>
            </p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>{{ trans('music.heading') }}</h2>
                </div>

                <div class="panel-body">
                    @include('messages.success')
                    @include('messages.errors')

                    @if (count($musicalbums) )
                        <div class="">
                            <ul class="media-list">
                                @foreach ($musicalbums as $item)
                                    <li class="media">
                                        <div class="media-body">
                                            @if ($item->status == \App\Models\Musicalbum::$STATUS_CREATED)
                                            <a href="{!! URL::route('musicalbums.edit', [$item->id]) !!}">
                                                <h3 class="media-heading">{!! $item->author !!} - {!! $item->title !!}</h3>
                                            </a>
                                            <div class="alert alert-warning">{{ trans('music.alert_unfinished_album') }}</div>
                                            @else
                                            <a href="{!! URL::route('musicalbums.slug_view', [$item->slug]) !!}">
                                                <h3 class="media-heading">{!! $item->author !!} - {!! $item->title !!}</h3>
                                            </a>
                                            @endif
                                            <a data-href="{!! URL::route('musicalbums.delete', [$item->id]) !!}" data-item_name="{{ $item->title }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                                <i class="fa fa-trash"></i> {!! trans('images.index_btn_delete') !!}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (count($tracks) )
                        <div class="">
                            <ul class="media-list">
                                @foreach ($tracks as $item)
                                    <li class="media">
                                        <div class="media-body">
                                            <a href="{!! URL::route('tracks.slug_view', [$item->slug]) !!}">
                                                <h3 class="media-heading">{!! $item->author !!} - {!! $item->title !!}</h3>
                                            </a>
                                            <a href="{!! URL::route('tracks.delete', [$item->id]) !!}">
                                                <button class="btn btn-primary" >
                                                    {!! trans('images.index_btn_delete') !!}
                                                </button>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.confirm')

@endsection
