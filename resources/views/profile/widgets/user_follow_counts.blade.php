<div class="count_widget">
    <div class="row">
        <div class="col-xs-4">
            <a class="blue" href="{{ url('/'.$user->username) }}">
                {{ $user->posts()->count() }}
            </a>
            {!! trans('profile.post_count') !!}
        </div>
        <div class="col-xs-4">
            <a class="green" href="{{ url('/'.$user->username.'/following') }}">
                {{ $user->following()->where('allow', 1)->count() }}
            </a>
            
            {!! trans('profile.following_count') !!}
        </div>
        <div class="col-xs-4">
            <a class="purple" href="{{ url('/'.$user->username.'/followers') }}">
                {{ $user->follower()->where('allow', 1)->count() }}
            </a>
            {!! trans('profile.followers_count') !!}
        </div>
        <div class="col-xs-4">
            <a class="purple" href="{{ url('/'.$user->username.'/music') }}">
                {{ $user->tracks()->count() }}
            </a>
            {!! trans('profile.tracks_count') !!}
        </div>
        <div class="col-xs-4">
            <a class="purple" href="{{ url('/'.$user->username.'/videos') }}">
                {{ $user->videos()->count() }}
            </a>
            {!! trans('profile.videos_count') !!}
        </div>
        <div class="col-xs-4">
            <a class="purple" href="{{ url('/'.$user->username.'/images') }}">
                {{ $user->images()->count() }}
            </a>
            {!! trans('profile.images_count') !!}
        </div>
    </div>
</div>
