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
                    <h2 class="pull-left">{{ trans('videos.heading') }}</h2>  @include('videos.index_option_buttons', ['user'=>$user])
                </div>
                <div class="panel-body">
                    @include('messages.success')
                    @include('messages.errors')

                    <h3>{{ trans('videos.albums_list') }}</h3>
                    <ul class="media-list">
                        @foreach ($videoalbums as $item)
                            <li class="media">
                                <div class="media-left">
                                    @if ( sizeof($item->videos) > 0 )
                                        {!!
                                        $item->videos[0]->media_object->setAttribute([
                                            'width' => 250,
                                            'height' => 150
                                        ]);
                                        $item->videos[0]->media_object->getEmbedCode() !!}
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h3 class="media-heading">{{ $item->name }}</h3>
                                    <div class="btn-group">
                                        <a class="btn btn-default" href="{{ URL::route('videoalbums.edit', $item->id) }}">
                                            <i class="fa fa-pencil"></i>
                                            {{ trans('videoalbums.index_btn_edit') }}
                                        </a>
                                        </a>
                                        <a data-href="{!! URL::route('videoalbums.destroy', [$item->id]) !!}" data-item_name="{{ $item->name }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                            <i class="fa fa-trash"></i> {!! trans('videos.index_btn_delete') !!}
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-body">
                    <h3>{{ trans('videos.videos_list') }}</h3>
                    <ul class="media-list">
                        @foreach ($videos as $item)
                            <li class="media">
                                <div class="media-left">
                                    {!!
                                    $item->media_object->setAttribute([
                                        'width' => 250,
                                        'height' => 150
                                    ]);
                                    $item->media_object->getEmbedCode() !!}
                                </div>
                                <div class="media-body">
                                    <h3 class="media-heading">{{ $item->title }}</h3>
                                    <div class="btn-group">
                                        <a class="btn btn-default" href="{{ URL::route('videos.edit', $item->id) }}">
                                            <i class="fa fa-pencil"></i>
                                            {{ trans('videos.index_btn_edit') }}
                                        </a>
                                        <a data-href="{!! URL::route('videos.destroy', [$item->id]) !!}" data-item_name="{{ $item->title }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger" href="#">
                                            <i class="fa fa-trash"></i> {!! trans('videos.index_btn_delete') !!}
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.confirm')

@endsection
