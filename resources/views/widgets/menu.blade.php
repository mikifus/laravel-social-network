<div class="menu">
    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ url('/') }}" class="menu-home">
                <i class="fa fa-home"></i>
                {{ trans('widgets.menu.home') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{!! url('/'.$user->username.'/music') !!}" class="menu-dm">
                <i class="fa fa-music"></i>
                {{ trans('widgets.menu.music') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{!! url('/'.$user->username.'/images') !!}" class="menu-dm">
                <i class="fa fa-image"></i>
                {{ trans('widgets.menu.images') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{!! url('/'.$user->username.'/videos') !!}" class="menu-dm">
                <i class="fa fa-video"></i>
                {{ trans('widgets.menu.videos') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('/nearby') }}" class="menu-nearby">
                <i class="fa fa-map-marker"></i>
                {{ trans('widgets.menu.nearby') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('/groups') }}" class="menu-groups">
                <i class="fa fa-users"></i>
                {{ trans('widgets.menu.groups') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ url('/direct-messages') }}" class="menu-dm">
                <i class="fa fa-commenting"></i>
                {{ trans('widgets.menu.direct_messages') }}
            </a>
        </li>
    </ul>
</div>
