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
				<div class="panel-heading">
                    <h3>{{ $item->title }}</h3>
                </div>

				<div class="panel-body">
                    <img src='{{ $item->file->url('original') }}' />
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
