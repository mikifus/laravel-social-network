<button v-promise-btn v-on:click="($event) => toggleLike('{!! $class !!}', {{ $item->id }}, $event)" type="button" class="btn btn-labeled btn-default btn-like">
    <span class="btn-label">
    {!! $item->likesCount !!}
    </span>
    <span class="like-toggle" style="display: @if ($item->liked) {{ 'none' }} @endif">
        <i class="fa fa-thumbs-up"></i> {!! trans('profile.like') !!}
    </span>
    <span class="unlike-toggle" style="display: @if (!$item->liked) {{ 'none' }} @endif">
        <i class="fa fa-thumbs-down"></i> {!! trans('profile.unlike') !!}
    </span>
</button>
