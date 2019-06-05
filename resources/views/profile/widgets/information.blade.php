<div class="profile-information">
    @if($my_profile)
        <div class="edit-button">
            <div class="button-frame">
                <a href="javascript:;" data-toggle="modal" data-target="#profileInformation">
                    <i class="fa fa-pencil"></i>
                    Edit
                </a>
            </div>
        </div>
    @endif
    <ul class="list-group">
        @if($user->has('location'))
        <li class="list-group-item">
            <i class="fa fa-map-marker"></i>
            {{ $user->location->city->name }}
        </li>
        @endif
        @if ($user->bio)
        <li class="list-group-item">
            <i class="fa fa-info-circle"></i>
            {{ $user->bio }}
        </li>
        @endif
    </ul>
</div>


<div class="panel panel-default">
    <div class="panel-heading">trans('relationships.profile.titles') @if($my_profile) <a href="javascript:;" data-toggle="modal" data-target="#profileRelationship"><i>{{ trans('relationships.add_new') }}</i></a> @endif</div>

    <ul class="list-group" style="max-height: 300px; overflow-x: auto">
        @if($relationship->count() == 0 && $relationship2->count() == 0)
            <li class="list-group-item">No Relationship!</li>
        @endif
        @if($relationship->count() > 0)
            @foreach($relationship as $relative)
                <li class="list-group-item">
                    {{ $relative->getType() }} -> <a href="{{ url('/'.$relative->relative->username) }}">{{ $relative->relative->name }}</a>
                    @if($my_profile)
                    <a href="javascript:;" onclick="removeRelation(0, {{ $relative->id }})" class="pull-right"><i class="fa fa-times"></i></a>
                    @endif
                </li>
            @endforeach
        @endif
        @if($relationship2->count() > 0)
            @foreach($relationship2 as $relative)
                <li class="list-group-item">
                    {{ $relative->getType() }} <- <a href="{{ url('/'.$relative->main->username) }}">{{ $relative->main->name }}</a>
                    @if($my_profile)
                    <a href="javascript:;" onclick="removeRelation(1, {{ $relative->id }})" class="pull-right"><i class="fa fa-times"></i></a>
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>



<div class="panel panel-default">
    <div class="panel-heading">{{ trans('hobbies.profile.title') }} @if($my_profile) <a href="javascript:;" data-toggle="modal" data-target="#profileHobbies"><i>{{ trans('actions.edit') }}</i></a> @endif</div>

    <ul class="list-group" style="max-height: 300px; overflow-x: auto">
        @if($user->hobbies()->count() == 0)
            <li class="list-group-item">{{ trans('hobbies.no_hobby') }}</li>
        @else
            @foreach($user->hobbies()->get() as $hobby)
                <li class="list-group-item">{{ $hobby->hobby->name }}</li>
            @endforeach
        @endif
    </ul>


</div>



@if($my_profile)
<div class="modal fade" id="profileInformation" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">trans('profile.your_information')</h5>
            </div>

            <div class="modal-body">
                <form id="form-profile-information">
                    <div class="form-group">
                        <label>trans('profile.location.title'):</label>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                                    <input type="text" class="form-control location-input" readonly value="{{ $user->getAddress() }}" aria-describedby="basic-addon1">
                                    <input type="hidden" value="" name="map_info" class="map-info">
                                </div>
                            </div>
                            <div class="col-md-12 map-place"></div>
                        </div>
                        <div class="clearfix"></div>
                        <a href="javascript:;" onclick="findMyLocation()">trans('relationships.location.refind_my_location')</a>
                    </div>
                    <div class="form-group">
                        <label>trans('profile.bio.title')</label>
                        <textarea name="bio" class="form-control">{{ $user->bio }}</textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="saveInformation()"> {{ trans('actions.save') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('actions.close') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="profileHobbies" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('actions.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">{{ trans('hobbies.profile.your_hobbies') }}</h5>
            </div>
            <form id="form-profile-hobbies" method="post" action="{{ url('/'.$user->username.'/save/hobbies') }}">

                {{ csrf_field() }}

                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('hobbies.profile.title') }}:</label>
                        <div class="row">
                            <div class="col-xs-12">
                                <select class="form-control select2-multiple" name="hobbies[]" multiple="multiple" style="width: 100%">
                                    @foreach($hobbies as $hobby)
                                        <option value="{{ $hobby->id }}" @if($user->hasHobby($hobby->id)){{ 'selected' }}@endif>{{ $hobby->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">{{ trans('actions.save') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('actions.close') }}</button>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="profileRelationship" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('actions.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">{{ trans('relationships.profile.add_new') }}</h5>
            </div>
            <form id="form-profile-hobbies" method="post" action="{{ url('/'.$user->username.'/save/relationship') }}">

                {{ csrf_field() }}



                <div class="modal-body">

                    @if($user->messagePeopleList()->count() == 0)
                        <!--You don't have follower which they follows you-->
                        {{ trans('relationships.profile.you_dont_have_follower') }}
                    @else

                    <div class="form-group">
                        <label>{{ trans('relationships.profile.person.title') }}:</label>
                        <div class="row">
                            <div class="col-xs-12">
                                <select class="form-control" name="person" style="width: 100%">
                                    @foreach($user->messagePeopleList()->get() as $fr)
                                        <option value="{{ $fr->follower->id }}">{{ $fr->follower->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Relation:</label>
                        <div class="row">
                            <div class="col-xs-12">
                                <select class="form-control" name="relation" style="width: 100%">
                                    <option value="0">{{ \App\Models\UserRelationship::getTypeString(0) }}</option>
                                    <option value="1">{{ \App\Models\UserRelationship::getTypeString(1) }}</option>
                                    <option value="2">{{ \App\Models\UserRelationship::getTypeString(2) }}</option>
                                    <option value="3">{{ \App\Models\UserRelationship::getTypeString(3) }}</option>
                                    <option value="4">{{ \App\Models\UserRelationship::getTypeString(4) }}</option>
                                    <option value="5">{{ \App\Models\UserRelationship::getTypeString(5) }}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    @endif

                </div>

                <div class="modal-footer">
                    @if($user->messagePeopleList()->count() > 0)
                    <button type="submit" class="btn btn-success">Save</button>
                    @endif
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endif
