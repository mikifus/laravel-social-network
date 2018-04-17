<div class="pull-right">
    <div class="btn-group">
        <a class="btn btn-primary" href="{{ URL::route('videos.add') }}">
            {{ trans('videos.index_btn_add') }}
        </a>
    </div>
</div>
<div class="clearfix"></div>

@include('modals.confirm')