<div class="pull-right">
    <div class="btn-group">
        <a class="btn btn-primary" href="{{ URL::route('images.index') }}">
            {{ trans('imagealbums.back_to_index') }}
        </a>
        <a data-href="{{ URL::route('imagealbums.destroy', $item->id) }}" data-item_name="{{ $item->name }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger pull-right" href="#">
            {{ trans('imagealbums.delete') }}
        </a>
    </div>
</div>
<div class="clearfix"></div>

@include('modals.confirm')