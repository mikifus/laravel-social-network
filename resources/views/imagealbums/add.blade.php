@extends('layouts.app')

@include('snippets.tagsinput-autocomplete', ['url' => route('imagealbums.autocomplete_tags',['term'=>'%QUERY'])])

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>{{ trans('imagealbums.add_heading') }}</h2></div>

                <div class="panel-body">
                    @include('messages.errors')

                    {!! Form::open(array('route' => 'imagealbums.store', 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('imagealbums.add_title') ) !!}
                            {!! Form::text('title',
                                NULL,
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('imagealbums.add_description') ) !!}
                            {!! Form::textarea('description',
                                NULL,
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('images.tags') ) !!}
                            {!! Form::text('tags',
                                NULL,
                                array('class'=>' form-control bootstrap-tagsinput')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('imagealbums.submit'),
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
