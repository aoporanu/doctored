@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">View Group</h3>
<br/>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_group" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong> Group Name:  </strong></label>
                <div class="col-md-9">
                    {{isset($group_details) ? $group_details->group_name : ''}}
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong>Logo:</strong></label>
                @if (isset($group_details->logo))
                <div class="col-md-2">
                    <img height="100%" width="100%" src="../../uploads/{{$group_details->logo}}">
                </div>
                @endif
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong>Banner:</strong></label>
                @if (isset($group_details->banner))
                <div class="col-md-2">
                    <img height="100%" width="100%" src="../../uploads/{{$group_details->banner}}">
                </div>
                @endif
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong> Group Description:  </strong></label>
                <div class="col-md-9">
                    {{isset($group_details) ? $group_details->group_description : old('group_description')}}
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Business Name:  </strong></label>
                <div class="col-md-9">
                    {{isset($group_details) ? $group_details->group_business_name : old('group_business_name')}}
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Address:  </strong></label>
                <div class="col-md-3">
                    {{isset($group_details) ? $group_details->address : old('address')}}
                </div>
                <div class="col-md-2">
                    {{isset($group_details) ? $group_details->address_place : old('address_place')}}
                </div>
                <div class="col-md-2">
                    {{isset($group_details) ? $group_details->address_lat : old('address_lat')}}
                </div>
                <div class="col-md-2">
                    {{isset($group_details) ? $group_details->address_long : old('address_long')}}
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Phone:  </strong></label>
                <div class="col-md-3">
                    {{ isset($phoneCode) ? $phoneCode : old('phonecode')}}
                </div>
                <div class="col-md-6">
                    {{isset($group_details) ? $group_details->phone : old('phone')}}
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Email:  </strong></label>
                <div class="col-md-9">
                    {{isset($group_details) ? $group_details->email : old('email')}}
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Licence:  </strong></label>
                <div class="col-md-9">
                    {{isset($group_details) ? $group_details->licence : old('licence')}}
                </div>
            </div>
            <h3>Mata Types</h3>
            <hr/>
            <br/>
            @foreach($specializations as $specialization)
            <div class="form-group  row">
                <label class="col-md-2"><strong> {{ucwords($specialization->gmetaname)}}:  </strong></label>
                <div class="col-md-9">
                    {{isset($metaTypeData[$specialization->gmetaname]) ? $metaTypeData[$specialization->gmetaname] : '' }}
                </div>
            </div>
            @endforeach
            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="button" onclick="window.location.href='/admin/edit_group/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$group_details->group_id)}}}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                    <button type="button" onclick="window.location.href = '/admin/groups'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection