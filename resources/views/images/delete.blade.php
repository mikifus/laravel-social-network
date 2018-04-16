@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-3">
			@include('users.partials.profile-section')
		</div>
		<div id="center-column" class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('images.delete_heading') }}</div>

				<div class="panel-body">
                    @include('messages.errors')

                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <img src='{{ $item->file->url('thumb') }}' />
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading">{{ $item->title }}</h3>
                            </div>
                        </li>
                    </ul>

                    {!! Form::open(array('route' => 'images.destroy', 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('images.delete_confirm') ) !!}
                            {!! Form::hidden('confirm', 1) !!}
                            {!! Form::hidden('id', $item->id) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('images.delete_submit'),
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {!! Form::close() !!}
				</div>
			</div>
		</div>

		<div id="right-side-column" class="col-md-3">
			@include('friends.partials.friend-chat-list')
		</div>
	</div>
@endsection
