@extends('layouts.app')

@include('snippets.tagsinput-autocomplete', ['url' => route('images.autocomplete_tags',['term'=>'%QUERY'])])

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-heading"><h2 class='pull-left'>{{ trans('images.edit_heading') }}</h2> @include('images.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>

                <div class="panel-body">
                    @include('messages.errors')

                    {!! Form::open(array('route' => ['images.update', $item->id], 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('images.add_title') ) !!}

                            <h4>{{ $item->title }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('images.add_file') ) !!}

                            <div class="thumbnail">
                                <img src="{{ $item->file->url('thumb') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('images.tags') ) !!}
                            {!! Form::text('tags',
                                $item->tagList,
                                array('class'=>' form-control bootstrap-tagsinput')) !!}
                        </div>

                        @if (count($imagealbums) > 0)
                        <div class="form-group">
                            {!! Form::label( trans('images.add_imagealbum') ) !!}<br />
                            {!! Form::select('imagealbum_id',
                            [null=>trans('images.add_no_imagealbum')] + $imagealbums->toArray(),
                            $item->imagealbum_id,
                            ['class' => 'form-control']) !!}
                        </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label( trans('images.add_imagealbum_title') ) !!}
                            {!! Form::text('imagealbum_title',
                                NULL,
                                array('class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('images.add_category') ) !!}
                            {!! Form::select('category_id',
                            [null=>trans('images.add_no_category')] + $categories,
                            $category_id,
                            ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('images.submit'),
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
