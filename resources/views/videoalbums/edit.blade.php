@extends('layouts.app')

@include('snippets.tagsinput-autocomplete', ['url' => route('videoalbums.autocomplete_tags',['term'=>'%QUERY'])])
@include('snippets.include_jsvalidator')

@section('footer')
<script>
$(document).ready(function(){
    $.validator.setDefaults({
        ignore: []
    });
});
</script>
{!! JsValidator::formRequest('App\Http\Requests\VideoalbumsEditRequest', '.videoalbums_edit_form') !!}
@append

@section('title',trans('videoalbums.edit_page_title'))
@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 class='pull-left'>{{ trans('videoalbums.edit_heading') }}</h2> @include('videoalbums.edit_option_buttons', ['item'=>$item,'user'=>$user])</div>

                <div class="panel-body">
                    @include('messages.errors')

                    {!! Form::open(array('route' => ['videoalbums.update', $item->id], 'class' => 'form videoalbums_edit_form')) !!}
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.add_name') ) !!}

                            <h4>{{ $item->name }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.add_description') ) !!}
                            {!! Form::textarea('description',
                                $item->description,
                                array('required',
                                      'class'=>' form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('videoalbums.tags') ) !!}
                            {!! Form::text('tags',
                                $item->tagList,
                                array('class'=>' form-control bootstrap-tagsinput')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label( trans('images.add_category') ) !!}
                            {!! Form::select('category_id',
                            [null=>trans('images.add_no_category')] + $categories,
                            $category_id,
                            ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('videoalbums.submit'),
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
