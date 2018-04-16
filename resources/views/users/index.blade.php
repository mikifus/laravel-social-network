@extends('layouts.default')

@section('content')

	<div class="row">

		<div id="center-column" class="col-md-6">
			@if($users->count())
				<div class="users-list">

					@foreach($users as $user)

						<div class="media listed-object-close">
							<div class="pull-left">
								<a href="{!! route('user_profile_path', $user->username) !!}"><img class="media-object avatar medium-avatar" src="{!! $user->avatar->url('medium') !!}" alt="{!! $user->username !!}"></a>
							</div>
							<div class="media-body">
								<h4 class="media-heading">{!! $user->username !!}</h4>
                                @if(Auth::user())
                                <div class="pull-right">
                                    @include('friends.partials.friend-button', ['user' => $user])
								</div>
                                @endif
							</div>
						</div>
					@endforeach
				</div>
					<div class="paginator text-center">
						 {!! $users->render() !!}
					</div>
			@else

				<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> No users were found.</div>

			@endif



		</div>

		<div id="right-side-column" class="col-md-3">
		</div>
	</div>

@stop