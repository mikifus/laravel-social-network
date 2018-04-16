@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-3">
			@include('users.partials.profile-section')
		</div>
		<div id="center-column" class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
                    <h3>{{ $item->title }}</h3>
                </div>

				<div class="panel-body">
                    <img src='{{ $item->file->url('original') }}' />
				</div>
			</div>
		</div>

		<div id="right-side-column" class="col-md-3">
			@include('friends.partials.friend-chat-list')
		</div>
	</div>
@endsection
