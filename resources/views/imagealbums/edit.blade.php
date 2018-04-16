@extends('layouts.app')

@section('title',trans('imagealbums.edit_page_title'))
@section('content')
<div class="row">
    <div class="col-md-3">
        @include('users.partials.profile-section')
    </div>
    <div id="center-column" class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading"><h2 class='pull-left'>{{ trans('imagealbums.edit_heading') }}</h2> @include('imagealbums.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>

            <div class="panel-body">
                @include('messages.errors')

                {!! Form::open(array('route' => ['imagealbums.update', $item->id], 'class' => 'form')) !!}
                    <div class="form-group">
                        {!! Form::label( trans('imagealbums.add_title') ) !!}

                        <h4>{{ $item->title }}</h4>
                    </div>
                    <div class="form-group">
                        {!! Form::label( trans('imagealbums.add_description') ) !!}
                        {!! Form::textarea('description',
                            $item->description,
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
