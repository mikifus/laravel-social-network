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
                    <h2>{!! $item->author !!} - {!! $item->title !!}</h2>
                </div>

                <div class="panel-body">
                    @if (count($tracks) )
                    <div class="">
                        <ul class="media-list">
                            @foreach ($tracks as $track)
                            <li class="media">
                                <div class="media-body">
                                    <h3 class="media-heading">{!! $track->author !!} - {!! $track->title !!}</h3>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection