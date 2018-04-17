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
				<div class="panel-heading">{{ trans('tracks.delete_heading') }}</div>

				<div class="panel-body">
                    @include('messages.errors')

                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading">{{ $item->title }}</h3>
                            </div>
                        </li>
                    </ul>

                    {!! Form::open(array('route' => 'tracks.destroy', 'class' => 'form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('tracks.delete_confirm') ) !!}
                            {!! Form::hidden('confirm', 1) !!}
                            {!! Form::hidden('id', $item->id) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('tracks.delete_submit'),
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
</div>
@endsection
