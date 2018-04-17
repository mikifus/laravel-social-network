<div class="row form-group steps">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="@if ($steps['step'] === 1) {{ 'active' }} @elseif ( in_array(1, $steps['disabled']) ) {{ 'disabled' }} @endif">
                <a href="@if (!in_array(1, $steps['disabled'])) {!! URL::route('musicalbums.edit', [$item->id]) !!} @else {{ '#' }} @endif"  >
                    <h4 class="list-group-item-heading">{{ trans('musicalbums.steps_add_title') }}</h4>
                    <p class="list-group-item-text">{{ trans('musicalbums.steps_add_desc') }}</p>
                </a>
            </li>
            <li class="@if ($steps['step'] === 2) {{ 'active' }} @elseif ( in_array(2, $steps['disabled']) ) {{ 'disabled' }} @endif" class="disabled">
                <a href="@if (!in_array(2, $steps['disabled'])) {!! URL::route('musicalbums.add_images', [$item->id]) !!} @else {{ '#' }} @endif"  >
                    <h4 class="list-group-item-heading">{{ trans('musicalbums.steps_images_title') }}</h4>
                    <p class="list-group-item-text">{{ trans('musicalbums.steps_images_desc') }}</p>
                </a>
            </li>
            <li class="@if ($steps['step'] === 3) {{ 'active' }} @elseif ( in_array(3, $steps['disabled']) ) {{ 'disabled' }} @endif" class="disabled">
                <a href="@if (!in_array(3, $steps['disabled'])) {!! URL::route('musicalbums.add_tracks', [$item->id]) !!} @else {{ '#' }} @endif"  >
                    <h4 class="list-group-item-heading">{{ trans('musicalbums.steps_tracks_title') }}</h4>
                    <p class="list-group-item-text">{{ trans('musicalbums.steps_tracks_desc') }}</p>
                </a>
            </li>
            <li class="@if ($steps['step'] === 4) {{ 'active' }} @elseif ( in_array(4, $steps['disabled']) ) {{ 'disabled' }} @endif" class="disabled">
                <a href="@if (!in_array(4, $steps['disabled'])) {!! URL::route('musicalbums.sort_tracks', [$item->id]) !!} @else {{ '#' }} @endif"  >
                    <h4 class="list-group-item-heading">{{ trans('musicalbums.steps_sort_title') }}</h4>
                    <p class="list-group-item-text">{{ trans('musicalbums.steps_sort_desc') }}</p>
                </a>
            </li>
            <li class="@if ($steps['step'] === 5) {{ 'active' }} @elseif ( in_array(5, $steps['disabled']) ) {{ 'disabled' }} @endif" class="disabled">
                <a href="@if (!in_array(5, $steps['disabled'])) {!! URL::route('musicalbums.publish', [$item->id]) !!} @else {{ '#' }} @endif"  >
                    <h4 class="list-group-item-heading">{{ trans('musicalbums.steps_publish_title') }}</h4>
                    <p class="list-group-item-text">{{ trans('musicalbums.steps_publish_desc') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>