@extends('layouts.app')

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
                <div class="panel-heading">
                    <h2 class="pull-left">{{ trans('musicalbums.publish_heading', ['title' => $item->title]) }}</h2> @include('musicalbums.edit_option_buttons', ['item'=>$item,'user'=>$user])
                </div>
                <div class="panel-body">
                    @include('messages.errors')
                </div>
                <div class="panel-body">
                    <h3>{{ trans('musicalbums.publish_overview') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-push-2">
                        @if ($item->front->originalFilename())
                        <div class="col-xs-6">
                            <img style='width: 100%;' src="{{ $item->front->url() }}">
                        </div>
                        @endif
                        @if ($item->back->originalFilename())
                        <div class="col-xs-6">
                            <img style='width: 100%;' src="{{ $item->back->url() }}">
                        </div>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="list-group" id='sortable'>
                        @foreach($tracks as $track)
                        <li class="list-group-item" id='{{ $track->id }}'>
                            <h4 class="pull-left"> {{ $track->position+1 }}. {{ $track->author }} - {{ $track->title }}</h4>
                            <span class="badge">{{ $track->duration }}</span>
                            <div class="clearfix"></div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {!! Form::open(['route' => ['musicalbums.finish_publish', $item->id ], 'id' => 'publish_form']) !!}
                <div class="panel-body">
                    <h4>{{ trans('musicalbums.license') }}</h4>
                    <div class='text-center'>
                        <div class="btn-group"  data-toggle="buttons">
                            <label class="btn btn-primary active">
                                {!! Form::radio('license_type', 'copyright', ['checked' => 1]) !!} {{ trans('musicalbums.copyright') }}
                            </label>
                            <label class="btn btn-primary">
                                {!! Form::radio('license_type', 'cc') !!} {{ trans('musicalbums.creative_commons') }}
                            </label>
                            <label class="btn btn-primary">
                                {!! Form::radio('license_type', 'public_domain') !!} {{ trans('musicalbums.public_domain') }}
                            </label>
                        </div>
                    </div>
                    <div id='license_type_tabs' class='col-md-8 col-md-push-2' style='margin-top: 20px;'>
                        <div id='copyright_tab'>
                            {!! Form::label('copyright_string', trans('musicalbums.copyright_string')); !!}
                            <div class='input-group'>
                                <span class="input-group-addon"><i class='fa fa-copyright'></i></span>
                                {!! Form::text('copyright_string', '', ['class' => 'form-control', 'placeholder' => date('Y')." Example Records"]) !!}
                            </div>
                        </div>
                        <div id='creative_commons_tab'>
                            {!! Form::label('derivatives', trans('musicalbums.derivatives')); !!}
                            <div class=""  data-toggle="buttons">
                                <div class="radio">
                                    <label>{!! Form::radio('derivatives', 'yes', true) !!} {{ trans('musicalbums.derivatives_yes') }}</label>
                                </div>
                                <div class="radio">
                                    <label>{!! Form::radio('derivatives', 'no') !!} {{ trans('musicalbums.derivatives_no') }}</label>
                                </div>
                                <div class="radio">
                                    <label>{!! Form::radio('derivatives', 'sharealike') !!} {{ trans('musicalbums.derivatives_sharealike') }}</label>
                                </div>
                            </div>
                            {!! Form::label('commercial', trans('musicalbums.commercial')); !!}
                            <div class=""  data-toggle="buttons">
                                <div class="radio">
                                    <label>{!! Form::radio('commercial', 'yes', true) !!} {{ trans('musicalbums.commercial_yes') }}</label>
                                </div>
                                <div class="radio">
                                    <label>{!! Form::radio('commercial', 'no') !!} {{ trans('musicalbums.commercial_no') }}</label>
                                </div>
                            </div>
                            <div class='text-center'>
                                <img id="cc_image" src='https://i.creativecommons.org/l/by/4.0/88x31.png'>
                                {!! Form::hidden('cc_license', 'by') !!}
                            </div>
                        </div>
                        <div id='public_domain_tab' class='text-center'>
                            <img src='https://licensebuttons.net/p/mark/1.0/88x31.png'>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="panel-footer text-center">
                    <div class="form-group">
                        {!! Form::button(trans('musicalbums.publish_submit'),
                          ['class'=>'btn btn-primary', 'id' => 'publish_submit']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
$(function(){
    // License tabs
    $('#license_type_tabs > div').hide();
    $('#copyright_tab').show();
    $("input[name='license_type']").change(function(){
        $('#license_type_tabs > div').hide();
        switch($(this).val()) {
            case 'cc':
                $('#creative_commons_tab').show();
                break;
            case 'public_domain':
                $('#public_domain_tab').show();
                break;
            case 'copyright':
            default:
                $('#copyright_tab').show();
                break;
        }
    });

    // CC form
    var cc_url = "https://i.creativecommons.org/l/$1/4.0/88x31.png";

    var set_cc = function() {
        var params = 'by';
        switch($("input[name='commercial']:checked").val()) {
            case 'no':
                params += "-nc";
                break;
        }
        switch($("input[name='derivatives']:checked").val()) {
            case 'no':
                params += "-nd";
                break;
            case 'sharealike':
                params += "-sa";
                break;
        }
        var final_url = cc_url.replace('$1', params);
        $("#cc_image").attr('src', final_url);
        $("input[name='cc_license']").val(params);
    };

    $("input[name='derivatives']").change(function(){
        set_cc();
    });
    $("input[name='commercial']").change(function(){
        set_cc();
    });

    // Submit button
    $("#modal-submit .btn-ok").click(function(){
        $('#publish_form').submit();
    });
    $('#publish_submit').click(function(){
        $("#modal-submit").modal('show');
    });
});
</script>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-submit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{ trans('musicalbums.publish_confirm_modal') }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('modals.cancel') }}</button>
        <a class="btn btn-primary btn-ok">{{ trans('modals.confirm') }}</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@append
