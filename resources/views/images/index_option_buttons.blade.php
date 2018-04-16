<div class="pull-right">
    <div class="btn-group">
        <a class="btn btn-primary" href="{{ URL::route('images.add') }}">
            {{ trans('images.index_btn_add') }}
        </a>
    </div>
</div>
<div class="clearfix"></div>

@include('modals.confirm')