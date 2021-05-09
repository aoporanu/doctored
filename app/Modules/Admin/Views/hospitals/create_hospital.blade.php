@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">Create/Edit Hospital</h3>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_hospital" method="post" enctype="multipart/form-data">
            <h3>Hospital Info</h3>
            <hr/>
            <br/>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Hospital Name:  </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="hospital_id" value="{{isset($hospital_details) ? $hospital_details->hospital_id : 0}}" />
                    <input name="hospital_name" class="form-control" id="hospital_name" value="{{isset($hospital_details) ? $hospital_details->hospital_name : old('hospital_name')}}" />
                    @error('hospital_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Hospital Business Name:  </strong></label>
                <div class="col-md-9">
                    <input name="hospital_business_name" class="form-control" id="hospital_business_name" value="{{isset($hospital_details) ? $hospital_details->hospital_business_name : old('hospital_business_name')}}" />
                    @error('hospital_business_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong>  Hospital Type:  </strong></label>
                <div class="col-md-9">
                    <select name="hospital_type" class="form-control">
                        <option value="">Please type</option>
                        <option value="H" {{isset($hospital_details) && $hospital_details->hospital_type == 'H' ? 'selected' : ''}}>Hospital</option>
                        <!--<option value="C" {{isset($hospital_details) && $hospital_details->hospital_type == 'C' ? 'selected' : ''}}>Clinic</option>-->
                    </select>
                </div>
                @error('hospital_type')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Date of registration:  </strong></label>
                <div class="col-md-9">
                    <input type="date" name="dateofregistration" class="form-control" id="dateofregistration" value="{{isset($hospital_details) ? $hospital_details->dateofregistration : old('dateofregistration')}}" max="{{ date('Y-m-d')}}"/>
                    @error('dateofregistration')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Logo:  </strong></label>
                <div class="col-md-9">
                    <!--input name="logo" class="form-control" id="logo" value="{{isset($hospital_details) ? $hospital_details->logo : ''}}" /-->
                    <input type="file" name="logo" id="logo" multiple="">
                    @if (isset($hospital_details->logo))
                    <div class="col-md-2">
                    <img height="100%" width="100%" src="{{'/uploads/'.$hospital_details->logo}}">
                    </div>
                    @endif
                    @error('logo')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Banner:  </strong></label>
                <div class="col-md-9">
                    <!--input name="banner" class="form-control" id="banner" value="{{isset($hospital_details) ? $hospital_details->banner : ''}}" /-->
                        <input type="file" name="banner" id="banner" multiple="">
                        @if (isset($hospital_details->banner))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="{{'/uploads/'.$hospital_details->banner}}">
                        </div>
                        @endif
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Phone:  </strong></label>
                <div class="col-md-3"><select class="phonecode pc form-control" name="phonecode" data-value="{{ isset($phoneCode) ? $phoneCode : old('phonecode')}}"> </select></div>
                <div class="col-md-6"><input name="phone" class="form-control" id="phone" value="{{isset($phoneNumber) ? $phoneNumber : old('phone')}}" />
                    @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Email:  </strong></label>
                <div class="col-md-9">
                    <input type="email" name="email" class="form-control" id="email" value="{{isset($hospital_details) ? $hospital_details->email : old('email')}}" />
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Fax:  </strong></label>
                <div class="col-md-9">
                    <input name="fax" class="form-control" id="fax" value="{{isset($hospital_details) ? $hospital_details->fax : old('fax')}}" />
                    @error('fax')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Licence:  </strong></label>
                <div class="col-md-9">
                    <input name="licence" class="form-control" id="licence" value="{{isset($hospital_details) ? $hospital_details->licence : old('licence')}}" />
                    @error('licence')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <h3>Address Details </h3>
            <hr/>
            <br/>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Address Line 1:  </strong></label>
                <div class="col-md-9">
                    <input name="address_line1" class="form-control" id="address_line1" value="{{isset($hospital_details) ? $hospital_details->address_line1 : old('address_line1')}}" />
                    @error('address_line1')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Address Line 2:  </strong></label>
                <div class="col-md-9">
                    <input name="address_line2" class="form-control" id="address_line2" value="{{isset($hospital_details) ? $hospital_details->address_line2 : old('address_line2')}}" />
                    @error('address_line2')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Address Line 3:  </strong></label>
                <div class="col-md-9">
                    <input name="address_line3" class="form-control" id="address_line3" value="{{isset($hospital_details) ? $hospital_details->address_line3 : old('address_line3')}}" />
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Country:  </strong></label>
                <div class="col-md-9">
                    <!--<input name="address_country" class="form-control" id="address_country" value="{{isset($hospital_details) ? $hospital_details->address_country : ''}}" />-->
                    <select class="form-control countries @error('address_country') is-invalid @enderror" id="countryId" aria-describedby="address_country" placeholder="Country" name="address_country" data-value="{{isset($hospital_details) ? $hospital_details->address_country : old('address_country')}}">
                        <option value="" >Select Country</option>
                        <!--                        <option value="GB">United Kingdom </option>
                                                <option value="NL">Netherlands </option>
                                                <option value="US">United States of America</option>-->
                    </select>

                    @error('address_country')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror  
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong> State:  </strong></label>
                <div class="col-md-9">
                    <!--<input name="address_state" class="form-control" id="address_state" value="{{isset($hospital_details) ? $hospital_details->address_state : ''}}" />-->
                    <select class="form-control states @error('address_state') is-invalid @enderror" name="address_state" class="states" id="stateId" data-value="{{isset($hospital_details) ? $hospital_details->address_state : old('address_state')}}">
                        <option value="">Select State</option>
                    </select>
                    @error('address_state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> City:  </strong></label>
                <div class="col-md-9">
                    <!--<input name="address_city" class="form-control" id="address_city" value="{{isset($hospital_details) ? $hospital_details->address_city : ''}}" />-->
                    <select class="form-control cities @error('address_city') is-invalid @enderror" name="address_city" class="cities" id="cityId" data-value="{{isset($hospital_details) ? $hospital_details->address_city : old('address_city')}}">
                        <option value="">Select City</option>
                    </select>
                    @error('address_city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Zip code:  </strong></label>
                <div class="col-md-9">
                    <input name="address_postcode" class="form-control" id="address_postcode" value="{{isset($hospital_details) ? $hospital_details->address_postcode : old('address_postcode')}}" />
                </div>
            </div>
            <!-- Maps related code -->
            <div class="form-group  row">
                <label class="col-md-2"><strong> Enter Location:  </strong></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="searchInMap" name="location" placeholder="Enter location" value="{{isset($hospital_details) ? $hospital_details->location : old('location')}}" />
                    <input type="hidden" id="PlaceName" />
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
                    <input readonly="true" name="address_long" class="form-control" id="cityLng" value="{{isset($hospital_details) ? $hospital_details->address_long : old('address_long')}}" />
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Summary:  </strong></label>
                <div class="col-md-9">
                    <textarea name="summary" class="form-control" id="summary">{{isset($hospital_details) ? $hospital_details->summary : old('summary')}}</textarea>
                </div>
            </div>
            @if($limited_access == 'All')
            <div class="form-group  row">
                <label class="col-md-2"><strong>  Group:  </strong></label>
                <div class="col-md-9">
                    <select name="group_id" id="group_id" class="form-control">
                        <option value="0">Please select group</option>
                        @foreach($groups as $group)
                        <option value="{{$group->gid}}" @if(isset($groupDetails) && $groupDetails->group_id == $group->gid) selected @endif>
                            {{$group->group_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
{{--            <div class="form-group  row">
                <label class="col-md-2"><strong>  Users:  </strong></label>
                <div class="col-md-9">
                    <select name="user_id" id="user_id" class="form-control" data-value=@if(isset($userDetails)) {{$userDetails->user_id}} @endif>
                        <option value="0">Please user</option>
                        @foreach($users as $user)
                        <option value="{{$user->user_id}}">
                            {{$user->user_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>--}}
            @endif
            <h3>Specilizations</h3>
            <hr/>
            <br/>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Specilizations:  </strong></label>
                <div class="col-md-9">
                    <div class="select2-primary">
                        <select class="form-control" multiple="multiple" data-plugin="select2" data-placeholder="Select Specilization" name="specialization[]">
                            @foreach($specializations as $specialization)
                            <option value="{{$specialization->id}}" @if(isset($specializationList) && in_array($specialization->id, $specializationList)) selected @endif>{{$specialization->specialization_name}}</option>
                            @endforeach    
                        </select>
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
                        <select class="form-control" multiple="multiple" data-plugin="select2" data-placeholder="Select Consultation Types" name="consultation_types[]">
                            @foreach($consultationTypes as $consultation)
                            <option value="{{$consultation->ctype_id}}" @if(isset($consultationList) && in_array($consultation->ctype_id, $consultationList)) selected @endif>{{$consultation->ctype_name}}</option>
                            @endforeach    
                        </select>
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
                    <input name="{{$hospitalMeta->hmetaname}}" id="{{$hospitalMeta->hmetaname}}" class="form-control" 
                           value="{{isset($hospitalMetaList[$hospitalMeta->hmeta_id]) ? $hospitalMetaList[$hospitalMeta->hmeta_id] : '' }}" />
                    @error($hospitalMeta->hmetaname)
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            @endforeach
{{--            <h3>Doctors</h3>
            <hr/>
            <br/>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Doctors:  </strong></label>
                <div class="col-md-9">
                    <div class="select2-primary">
                        <select class="form-control" multiple="multiple" data-plugin="select2" data-placeholder="Select Consultation Types" name="consultation_types[]">
                            @foreach($doctorsList as $doctorInfo)
                            <option value="{{$doctorInfo->id}}" @if(isset($consultationList) && in_array($consultation->ctype_id, $consultationList)) selected @endif>{{$doctorInfo->title.' '.$doctorInfo->firstname.' '.$doctorInfo->lastname}}</option>
                            @endforeach    
                        </select>
                    </div>
                </div>
            </div>--}}
            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/hospitals'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?php echo env('GOOGLE_MAPS_KEY') ?>&libraries=places"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('searchInMap'));
        google.maps.event.addListener(places, 'place_changed', function () {
            var place = places.getPlace();
            var address = place.formatted_address;
            /*    var latitude = place.geometry.location.A;
             var longitude = place.geometry.location.F;*/
            document.getElementById('PlaceName').value = address;
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();

        });
    });
</script>
@endsection