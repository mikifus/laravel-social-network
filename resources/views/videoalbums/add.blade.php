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
                <div class="panel-heading"><h2 class="pull-left">{{ trans('videoalbums.add_heading') }}</h2></div>

                <div class="panel-body">
                    @include('messages.errors')

                    {!! Form::open(array('route' => 'videoalbums.store', 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.add_title') ) !!}
                            {!! Form::text('title',
                                NULL,
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.add_description') ) !!}
                            {!! Form::textarea('description',
                                NULL,
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('videoalbums.submit'),
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection