@if(Auth::user())
    <ul class="nav navbar-nav navbar-right">
        @include('widgets.notifications')
        <li class="dropdown">
            <a href="#" class="dropdown-toggle parent" data-toggle="dropdown" role="button" aria-expanded="false">

                <img src="{{ Auth::user()->getPhoto() }}" alt="" />
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{ url('/'.Auth::user()->username) }}">
                        <i class="fa fa-user"></i> My Profile
                    </a>
                </li>
                <li>
                    <a href="{{ url('/settings') }}">
                        <i class="fa fa-cog"></i> Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>
@else
    <ul class="nav navbar-nav navbar-right">
        <li class="navbar-login">
            <a href="{{ url('/') }}">
                <i class="fa fa-user"></i> Login
            </a>
        </li>
    </ul>
@endif
