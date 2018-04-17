<div class="pull-right">
    <div class="btn-group">
        <a class="btn btn-primary" href="{{ URL::route('music_profile_path', $user->username) }}">
            {{ trans('musicalbums.edit_later') }}
        </a>
        <a data-href="{{ URL::route('musicalbums.delete', $item->id) }}" data-item_name="{{ $item->title }}" data-toggle="modal" data-target="#modal-confirm" data-target="#confirm" class="btn btn-danger pull-right" href="#">
            {{ trans('musicalbums.delete') }}
        </a>
    </div>
</div>
<div class="clearfix"></div>

@include('modals.confirm')