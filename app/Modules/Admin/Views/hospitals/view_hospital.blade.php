@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">View Hospitals</h3>
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
                {{App\Modules\Admin\Controllers\AdminIndexController::getGroupByHospitalId($hospital_details->hospital_id)}}
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

        <div class="form-group  row">
            <label class="col-md-2"><strong> Hospital Business Name:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->hospital_business_name : old('hospital_business_name')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong>  Hospital Type:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) && $hospital_details->hospital_type == 'H' ? 'Hospital' : 'Clinic'}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Date of registration:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->dateofregistration : old('dateofregistration')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Logo:  </strong></label>
            <div class="col-md-9">
                @if (isset($hospital_details->logo))
                <div class="col-md-2">
                    <img height="100%" width="100%" src="{{'/uploads/'.$hospital_details->logo}}">
                </div>
                @endif
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Banner:  </strong></label>
            <div class="col-md-9">
                @if (isset($hospital_details->banner))
                <div class="col-md-2">
                    <img height="100%" width="100%" src="{{'/uploads/'.$hospital_details->banner}}">
                </div>
                @endif
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Phone:  </strong></label>
            <div class="col-md-3">{{ isset($phoneCode) ? $phoneCode : old('phonecode')}}</div>
            <div class="col-md-6">
                {{isset($phoneNumber) ? $phoneNumber : old('phone')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Email:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->email : old('email')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Fax:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->fax : old('fax')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Licence:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->licence : old('licence')}}
            </div>
        </div>
        <h3>Address Details </h3>
        <hr/>
        <br/>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Address Line 1:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_line1 : old('address_line1')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Address Line 2:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_line2 : old('address_line2')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Address Line 3:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_line3 : old('address_line3')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Country:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_country : old('address_country')}}  
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong> State:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_state : old('address_state')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> City:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_city : old('address_city')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Zip code:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_postcode : old('address_postcode')}}
            </div>
        </div>
        <!-- Maps related code -->
        <div class="form-group  row">
            <label class="col-md-2"><strong> Enter Location:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->location : old('location')}}
            </div>
        </div>
        <!-- End Maps related code -->
        <div class="form-group  row" style="display:none;">
            <label class="col-md-2"><strong> Latitude:  </strong></label>
            <div class="col-md-9">
                <input readonly="true" name="address_lat" class="form-control" id="cityLat" value="{{isset($hospital_details) ? $hospital_details->address_lat : old('address_lat')}}" />
            </div>
        </div>
        <div class="form-group  row" style="display:none;">
            <label class="col-md-2"><strong> Longitude:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->address_long : old('address_long')}}
            </div>
        </div>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Summary:  </strong></label>
            <div class="col-md-9">
                {{isset($hospital_details) ? $hospital_details->summary : old('summary')}}
            </div>
        </div>
        @if($limited_access == 'All')
        <div class="form-group  row">
            <label class="col-md-2"><strong>  Group:  </strong></label>
            <div class="col-md-9">
                @foreach($groups as $group)
                @if(isset($groupDetails) && $groupDetails->group_id == $group->gid) {{$group->group_name}} @endif
                @endforeach
            </div>
        </div>
        @endif
        <h3>Specilizations</h3>
        <hr/>
        <br/>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Specilizations:  </strong></label>
            <div class="col-md-9">
                <div class="select2-primary">
                    @foreach($specializations as $specialization)
                        @if(isset($specializationList) && in_array($specialization->id, $specializationList)) 
                            {{$specialization->specialization_name}}
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <h3>Consultation Types</h3>
        <hr/>
        <br/>
        <div class="form-group  row">
            <label class="col-md-2"><strong> Consultation Types:  </strong></label>
            <div class="col-md-9">
                <div class="select2-primary">
                    @foreach($consultationTypes as $consultation)
                        @if(isset($consultationList) && in_array($consultation->ctype_id, $consultationList)) 
                        {{$consultation->ctype_name}}
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <h3>Mata Types</h3>
        <hr/>
        <br/>
        @foreach($hospitalMetaTypes as $hospitalMeta)
        <div class="form-group  row">
            <label class="col-md-2"><strong> {{ucwords($hospitalMeta->hmetaname)}}:  </strong></label>
            <div class="col-md-9">
                {{isset($hospitalMetaList[$hospitalMeta->hmeta_id]) ? $hospitalMetaList[$hospitalMeta->hmeta_id] : '' }}           
            </div>
        </div>
        @endforeach
        <div class="form-group form-material row">
            <div class="col-md-9">
                <button type="button" onclick="window.location.href='/admin/edit_hospital/{{$hospital_id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                <button type="button" onclick="window.location.href = '/admin/hospitals'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
            </div>
        </div>
    </div>
</div>
@endsection