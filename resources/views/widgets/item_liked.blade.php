<div class="panel panel-default">
    <div class="panel-heading">
        {!! trans('profile.likers') !!}
    </div>
    <div class="panel-body">
        <div class="row">
        @foreach($item->collectLikers()->take(9) as $user)
            <div class="col-xs-4">
                    <div class="">
                        <a href="{{ url('/'.$user->username) }}">
                            <img src="{{ $user->getPhoto(50, 50) }}" alt="{{ $user->name }}" class="img-circle" />
                        </a>
                    </div>
                    <div class="">
                        <a href="{{ url('/'.$user->username) }}">
                            <small>{{ '@'.$user->username }}</small>
                        </a>
                    </div>
                    <div class="clearfix"></div>
            </div>
        @endforeach
        </div>
    </div>
</div>
