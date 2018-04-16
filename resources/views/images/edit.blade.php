@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('users.partials.profile-section')
    </div>
    <div id="center-column" class="col-md-9">
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
                        {!! Form::submit(trans('images.submit'),
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
