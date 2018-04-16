@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('users.partials.profile-section')
    </div>
    <div id="center-column" class="col-md-9">
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
                        {!! Form::submit(trans('imagealbums.submit'),
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection