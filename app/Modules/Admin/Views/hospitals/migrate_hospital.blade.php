@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">Migrate Hospitals</h3>
<br/>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <!-- <form action="/admin/add_hospital" method="post" enctype="multipart/form-data"> -->
        <div class="form-group  row">
            <label class="col-md-2"><strong> Hospital Name:  </strong></label>
            <div class="col-md-9">

                {{isset($hospital_details) ? $hospital_details->hospital_name : ''}}
            </div>
        </div>
        @if($limited_access == 'All')
        <div class="form-group  row">
            <label class="col-md-2"><strong>  Group:  </strong></label>
            <div class="col-md-9">

                @foreach($groups as $group)
                @if(isset($groupDetails) && $groupDetails->group_id == $group->gid)  {{$group->group_name}} @endif
                @endforeach
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>  Users:  </strong></label>
            <div class="col-md-9">

                @foreach($users as $user)
                @if(isset($userDetails) && $userDetails->user_id == $user->user_id)  {{$user->user_name}} @endif
                @endforeach
            </div>
        </div>
        @endif
        <div class="form-group form-material row">
            <div class="col-md-9">
                <button type="button" onclick="window.location.href='/admin/migrate_hospital?hospital_id={{$hospital_details->hospital_id}}'" class="btn btn-primary waves-effect waves-classic">Migrate to Hospital</button>
                <button type="button" onclick="window.location.href = '/admin/hospitals'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection