@extends('layouts.app')

@section('title',trans('videoalbums.edit_page_title'))
@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 class='pull-left'>{{ trans('videoalbums.edit_heading') }}</h2> @include('videoalbums.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>

                <div class="panel-body">
                    @include('messages.errors')

                    {!! Form::open(array('route' => ['videoalbums.update', $item->id], 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.add_name') ) !!}

                            <h4>{{ $item->name }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.add_description') ) !!}
                            {!! Form::textarea('description',
                                $item->description,
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
