@extends('layouts.app')

@section('footer')
<script type="text/javascript">
$( function() {
    function order_to_form()
    {
        var sorted = $( "#sortable" ).sortable( "toArray" );
        $('#sorting_value').val( sorted.join(',') );
    }
    $( "#sortable" ).sortable({
        update: function( event, ui ) {
            order_to_form();
        }
    });
    $( "#sortable" ).disableSelection();

    // Set order initially if the user doesn't make any change.
    order_to_form();
} );
</script>
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
                <div class="panel-heading"><h2 class="pull-left">{{ trans('musicalbums.sort_tracks_heading', ['title' => $item->title]) }}</h2> @include('musicalbums.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>
                <div class="panel-body">
                    <h3>{{ trans('musicalbums.sort_tracks') }}</h3>
                    <ul class="list-group" id='sortable'>
                        @foreach($tracks as $track)
                        <li class="list-group-item" style="cursor: move;" id='{{ $track->id }}'>
                            <h4 class="pull-left"><i class="fa fa-bars"></i> {{ $track->author }} - {{ $track->title }}</h4>
                            <span class="badge">{{ $track->duration }}</span>
                            <div class="clearfix"></div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer text-center">
                    {!! Form::open(['route' => ['musicalbums.save_sort_tracks', $item->id ]]) !!}
                    <div class="form-group">
                        {!! Form::hidden('order', '', ['id'=>'sorting_value']) !!}

                        {!! Form::submit(trans('musicalbums.submit_and_continue'),
                          ['class'=>'btn btn-primary', 'id' => 'submit']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
