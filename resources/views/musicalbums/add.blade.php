@extends('layouts.app')

@include('snippets.include_jsvalidator')
@include('snippets.tagsinput-autocomplete', ['url' => route('musicalbums.autocomplete_tags',['term'=>'%QUERY'])])

@section('footer')
<script>
$(document).ready(function(){
    $.validator.setDefaults({
        ignore: []
    });
});
</script>
@append

@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\MusicalbumAddRequest', '#musicalbum_form') !!}
@append

@section('content')
<div class="h-20"></div>
<div class="container">

    @include('musicalbums.steps')

    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 class="pull-left">{{ trans('musicalbums.add_heading') }}</h2> @include('musicalbums.add_option_buttons')</div>
                {!! Form::open(array('route' => 'musicalbums.store', 'class' => 'form', 'id' => 'musicalbum_form')) !!}
                <div class="panel-body">
                    @include('messages.errors')
                </div>
                <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label( trans('musicalbums.add_title') ) !!}
                            {!! Form::text('title',
                                Input::old('title'),
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('musicalbums.add_author') ) !!}
                            {!! Form::text('author',
                                Input::old('author'),
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group" >
                            {!! Form::label( trans('musicalbums.add_description') ) !!}
                            {!! Form::textarea('description',
                                Input::old('description'),
                                array('class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('musicalbums.tags') ) !!}
                            {!! Form::text('tags',
                                NULL,
                                array('class'=>' form-control bootstrap-tagsinput')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('images.add_category') ) !!}
                            {!! Form::select('category_id',
                            [null=>trans('images.add_no_category')] + $categories,
                            NULL,
                            ['class' => 'form-control']) !!}
                        </div>
                </div>
                <div class="panel-footer text-center">
                    <div class="form-group">
                        {!! Form::submit(trans('musicalbums.submit_and_continue'),
                          ['class'=>'btn btn-primary', 'id' => 'submit']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
