<button v-promise-btn v-on:click="($event) => toggleLike('{!! $class !!}', {{ $item->id }}, $event)" type="button" class="btn btn-labeled btn-default btn-like" data-liked="{{ $item->liked ? 1 : 0 }}">
    <span class="btn-label">
    {!! $item->likesCount ?? 0 !!}
    </span>
    <span class="like-toggle" style="display: @if ($item->liked) {{ 'none' }} @endif">
        <i class="fa fa-thumbs-up"></i> {!! trans('profile.like') !!}
    </span>
    <span class="unlike-toggle" style="display: @if (!$item->liked) {{ 'none' }} @endif">
        <i class="fa fa-thumbs-down"></i> {!! trans('profile.unlike') !!}
    </span>
</button>
