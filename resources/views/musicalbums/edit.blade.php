@extends('layouts.app')

@include('snippets.include_jsvalidator')
@section('footer')
{!! JsValidator::formRequest('App\Http\Requests\MusicalbumEditRequest', '#musicalbum_form') !!}
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
                <div class="panel-heading"><h2 class='pull-left'>{{ trans('musicalbums.edit_heading', ['title' => $item->title]) }}</h2> @include('musicalbums.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>
                {!! Form::open(array('route' => ['musicalbums.store_update', $item->id], 'class' => 'form', 'id' => 'musicalbum_form')) !!}
                <div class="panel-body">
                    @include('messages.errors')
                </div>
                <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label( trans('musicalbums.add_title') ) !!}

                            <h4>{{ $item->title }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('musicalbums.add_author') ) !!}
                            <h4>{{ $item->author }}</h4>
                        </div>
                        <div class="form-group" >
                            {!! Form::label( trans('musicalbums.add_description') ) !!}
                            {!! Form::textarea('description',
                                Input::old('description') ? Input::old('description') : $item->description,
                                array('class'=>' form-control')) !!}
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
