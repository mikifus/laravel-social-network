@extends('layouts.app')

@section('content')

	<div class="row">
		<div class="col-md-3">
			@include('users.partials.profile-section')
		</div>

		<div id="center-column" class="col-md-6">

				<div class="row feed-list">


					@if($feeds->count())

						@foreach($feeds as $feed)

							@include('feeds.partials.feed-list')

						@endforeach

						<div class="paginator text-center">
						 	{!! $feeds->render() !!}
						</div>
					@else
						@if(Auth::user()->isId($user->id))
							<div class="alert alert-info no-feeds-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You haven't posted anything yet.
							</div>

						@else
							<div class="alert alert-info no-feeds-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> {!! $user->username !!} has't posted anything yet.
						</div>

						@endif

					@endif

				</div>

		</div>

        <div id="right-side-column" class="col-md-3">
            @if(Auth::check())
                @include('friends.partials.friend-chat-list')
            @endif
		</div>
	</div>

@stop