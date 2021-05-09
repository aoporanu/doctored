@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Members</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_member" method="post" enctype="multipart/form-data">
            <!-- <div class="form-group  row">
              <label class="col-md-2"><strong>Patient Code: </strong></label>
              <div class="col-md-9">
              <input type="hidden" name="patient_id" value="{{isset($patients->id) ? $patients->id : 0}}" />
              
                <input name="patientcode" class="form-control" id="patientcode" value="{{isset($patients->patientcode) ? $patients->patientcode : ''}}" />
              </div>
            </div> -->

            <div class="form-group  row">
                <label class="col-md-2">Title: </label>
                <div class="col-md-9">
                    <input type="hidden" name="patient_id" value="{{isset($patients->id) ? $patients->id : 0}}" />
                    <input type="radio" id="mr" name="title" value="mr" {{ (isset($patients->title) && $patients->title=="mr")? "checked" : "" }} >
                    Mr
                    <input type="radio" id="mrs" name="title" value="mrs" {{ (isset($patients->title) && $patients->title=="mrs")? "checked" : "" }} >
                    Mrs
                    <input type="radio" id="miss" name="title" value="miss" {{ (isset($patients->title) && $patients->title=="miss")? "checked" : "" }} >
                    Miss
                    <input type="radio" id="ms" name="title" value="ms" {{ (isset($patients->title) && $patients->title=="ms")? "checked" : "" }} >
                    Ms
                </div>
            </div>


            <!-- <div class="form-group  row">
              <label class="col-md-2"><strong> Title :</strong></label>
              <div class="col-md-9">
              <input name="title" class="form-control" id="title" value="{{isset($patients->title) ? $patients->title : ''}}"/>
              </div>
            </div> -->




            <div class="form-group  row">
                <label class="col-md-2"><strong> First Name:</strong></label>
                <div class="col-md-9">
                    <input name="firstname" class="form-control @error('firstname') is-invalid @enderror" id="firstname" value="{{isset($patients->firstname) ? $patients->firstname : ''}}" />
                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Last Name: </strong></label>
                <div class="col-md-9">
                    <input name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="lastname" value="{{isset($patients->lastname) ? $patients->lastname : ''}}" />
                    @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror     
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Gender: </strong></label>
                <div class="col-md-9">
                    <input type="radio" id="male" name="gender" value="Male" {{ ($patients->gender=="Male")? "checked" : "" }} >
                    Male
                    <input type="radio" id="female" name="gender" value="Female" {{ ($patients->gender=="Female")? "checked" : "" }}>
                    Female

  <!-- <input name="gender" class="form-control" id="gender" value="{{isset($patients->gender) ? $patients->gender : ''}}" /> -->
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Dob: </strong></label>
                <div class="col-md-9">
                    <input type="date" min="1950-01-01" max="<?php echo date('Y-m-d') ?>"  class="form-control @error('dob') is-invalid @enderror" id="dob" placeholder="" name="dob" value="{{isset($patients->dob) ? $patients->dob : ''}}">
                    @error('dob')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <!-- <div class="form-group  row">
              <label class="col-md-2"><strong>Photo: </strong></label>
              <div class="col-md-9">
              <input name="photo" class="form-control" id="photo" value="{{isset($patients->photo) ? $patients->photo : ''}}" />
              </div>
            </div> -->

            <div class="form-group  row">
                <label class="col-md-2"><strong>Photo:</strong></label>
                <div class="col-md-2">
                <!-- <input name="banner" class="form-control" id="banner" value="{{isset($page_details->banner) ? $page_details->banner  : ''}}" /> -->

                    <input type="file" name="photo" id="photo" multiple="">
                </div>
                @if (isset($patients->photo))
                <div class="col-md-2">
                    <img height="100%" width="100%" src="../uploads/{{$patients->photo}}">
                </div>
                @endif
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Phone: </strong></label>
                <div class="col-md-9">
                    <input name="phone" class="form-control  @error('phone') is-invalid @enderror" id="phone" value="{{isset($patients->phone) ? $patients->phone : ''}}" />
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Email: </strong></label>
                <div class="col-md-9">
                    <input name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{isset($patients->email) ? $patients->email : ''}}" />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <!-- <div class="form-group  row">
              <label class="col-md-2"><strong>Password: </strong></label>
              <div class="col-md-9">
              <input name="password" type="password" class="form-control" id="password" value="{{isset($patients->password) ? $patients->password : ''}}" />
              </div>
            </div> -->

            <div class="form-group  row">
                <label class="col-md-2"><strong>Address Line 1: </strong></label>
                <div class="col-md-9">
                    <input name="address_line1" class="form-control @error('address_line1') is-invalid @enderror" id="address_line1" value="{{isset($patients->address_line1) ? $patients->address_line1 : ''}}" />
                    @error('address_line1')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Address Line 2: </strong></label>
                <div class="col-md-9">
                    <input name="address_line2" class="form-control" id="address_line2" value="{{isset($patients->address_line2) ? $patients->address_line2 : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Address Line 3: </strong></label>
                <div class="col-md-9">
                    <input name="address_line3" class="form-control" id="address_line3" value="{{isset($patients->address_line3) ? $patients->address_line3 : ''}}" />
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
                <label class="col-md-2"><strong>Postal Code: </strong></label>
                <div class="col-md-9">
                    <input name="address_postcode" class="form-control" id="address_postcode" value="{{isset($patients->address_postcode) ? $patients->address_postcode : ''}}" />
                </div>
            </div>

            <!-- <div class="form-group  row">
              <label class="col-md-2"><strong>Present Address: </strong></label>
              <div class="col-md-9">
              <input name="address_address" class="form-control" id="address_address" value="{{isset($patients->address_address) ? $patients->address_address : ''}}" />
              </div>
            </div>

            <div class="form-group  row">
              <label class="col-md-2"><strong>Permanent Address: </strong></label>
              <div class="col-md-9">
              <input name="address_long" class="form-control" id="address_long" value="{{isset($patients->address_long) ? $patients->address_long : ''}}" />
              </div>
            </div> -->

            <div class="form-group  row">
                <label class="col-md-2"><strong>Last Screening: </strong></label>
                <div class="col-md-9">
                    <input name="last_screening" class="form-control" id="last_screening" value="{{isset($patients->last_screening) ? $patients->last_screening : ''}}" />
                </div>
            </div>

            <!-- <div class="form-group  row">
              <label class="col-md-2"><strong>Last Screening Date: </strong></label>
              <div class="col-md-9">
              <input name="last_screening_date" class="form-control" id="last_screening_date" value="{{isset($patients->last_screening_date) ? $patients->last_screening_date : ''}}" />
              </div>
            </div> -->

            <div class="form-group  row">
                <label class="col-md-2"><strong>Emergency Contact First name: </strong></label>
                <div class="col-md-9">
                    <input name="emer_firstname" class="form-control" id="emer_firstname" value="{{isset($patients->emer_firstname) ? $patients->emer_firstname : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Emergency Contact Last name: </strong></label>
                <div class="col-md-9">
                    <input name="emer_lastname" class="form-control" id="emer_lastname" value="{{isset($patients->emer_lastname) ? $patients->emer_lastname : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Emergency Contact Phone: </strong></label>
                <div class="col-md-9">
                    <input name="emer_phone" class="form-control" id="emer_phone" value="{{isset($patients->emer_phone) ? $patients->emer_phone : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Emergency Contact Email: </strong></label>
                <div class="col-md-9">
                    <input name="emer_email" class="form-control" id="emer_email" value="{{isset($patients->emer_email) ? $patients->emer_email : ''}}" />
                </div>
            </div>
            <h3>Mata Types</h3>
            <hr/>
            <br/>
            @foreach($patienMetaTypes as $patienMeta)
            <div class="form-group  row">
                <label class="col-md-2"><strong> {{ucwords($patienMeta->pmetaname)}}:  </strong></label>
                <div class="col-md-9">
                    <input name="{{$patienMeta->pmetaname}}" id="{{$patienMeta->pmetaname}}" class="form-control" 
                           value="{{isset($patienMetaList[$patienMeta->pmeta_id]) ? $patienMetaList[$patienMeta->pmeta_id] : old($patienMeta->pmetaname) }}" />
                    @error($patienMeta->pmetaname)
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            @endforeach
            <input type="hidden" id="terms" name="terms" value="yes">


            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/members'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>            
        </form>
    </div>

</div>

@endsection