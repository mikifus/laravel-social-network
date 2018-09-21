@extends('layouts.app')

@include('snippets.tagsinput-autocomplete', ['url' => route('videos.autocomplete_tags',['term'=>'%QUERY'])])

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 class='pull-left'>{{ trans('videos.edit_heading') }}</h2> @include('videos.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>

                <div class="panel-body">
                    @include('messages.errors')

                    {!! Form::open(array('route' => ['videos.update', $item->id], 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('videos.add_title') ) !!}

                            <h4>{{ $item->title }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('videos.add_url') ) !!}

                            <div>
                                {!!
                                    $item->media_object->setAttribute([
                                        'width' => 400,
                                        'height' => 200
                                    ]);
                                    $item->media_object->getEmbedCode() !!}
                            </div>
                        </div>

                        @if (count($videoalbums) > 0)
                        <div class="form-group">
                            {!! Form::label( trans('videos.add_videoalbum') ) !!}<br />
                            {!! Form::select('videoalbum_id',
                            [null=>trans('videos.add_no_videoalbum')] + $videoalbums->toArray(),
                            $item->videoalbum_id,
                            ['class' => 'form-control']) !!}
                        </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label( trans('videos.add_videoalbum_title') ) !!}
                            {!! Form::text('videoalbum_title',
                                NULL,
                                array('class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('videos.tags') ) !!}
                            {!! Form::text('tags',
                                $item->tagList,
                                array('class'=>' form-control bootstrap-tagsinput')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('videos.submit'),
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
