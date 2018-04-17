<div class="pull-right">
    <div class="btn-group">
        <a class="btn btn-primary" href="{{ URL::route('videos.index') }}">
            {{ trans('videos.back_to_index') }}
        </a>
    </div>
</div>
<div class="clearfix"></div>

@include('modals.confirm')