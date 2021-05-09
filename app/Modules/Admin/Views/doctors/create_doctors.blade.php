@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Doctors</h3>
<div class="panel">
    <br/>
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_doctors" method="post" enctype="multipart/form-data">
            <div class="form-group  row">
                <label class="col-md-2">Title: </label>
                <div class="col-md-9">
                    <input type="hidden" name="id" value="{{isset($doctors->id) ? $doctors->id : 0}}" />
                    <input type="radio" id="mr" name="title" value="mr" {{ (isset($doctors->title) && $doctors->title=="mr")? "checked" : "" }} >
                    Mr
                    <input type="radio" id="mrs" name="title" value="mrs" {{ (isset($doctors->title) && $doctors->title=="mrs")? "checked" : "" }} >
                    Mrs
                    <input type="radio" id="miss" name="title" value="miss" {{ (isset($doctors->title) && $doctors->title=="miss")? "checked" : "" }} >
                    Miss
                    <input type="radio" id="ms" name="title" value="ms" {{ (isset($doctors->title) && $doctors->title=="ms")? "checked" : "" }} >
                    Ms
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="firstname" >First Name<span class="mand">*</span></label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror"  id="firstname" placeholder="First Name" name="firstname" value="{{isset($doctors->firstname) ? $doctors->firstname : old('firstname')}}">
                        @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="lastname">Last Name<span class="mand">*</span></label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" placeholder="Last Name" name="lastname" value="{{isset($doctors->lastname) ? $doctors->lastname : old('lastname')}}">
                        @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror     
                    </div>
                </div>
<!--                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="phone">Mobile Phone<span class="mand">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" aria-describedby="phone" placeholder="Phone Number" name="phone" value="{{isset($doctors->phone) ? $doctors->phone : ''}}">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>-->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-md-3"><strong> Phone:  </strong></label>
                        <div class="col-md-6">
                            <select class="phonecode pc form-control" name="phonecode" data-value="{{ isset($phoneCode) ? $phoneCode : old('phonecode')}}"> </select>
                        </div>
                        <div class="col-md-6">
                            <input name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{isset($phoneNumber) ? $phoneNumber : old('phone')}}" />
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="email">Email Address<span class="mand">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email Address" name="email" value="{{isset($doctors->email) ? $doctors->email : old('email')}}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="licence">licence ID</label>
                        <input type="licence" class="form-control @error('licence') is-invalid @enderror" id="licence" placeholder="licence" name="licence" value="{{isset($doctors->licence) ? $doctors->licence : old('licence')}}">
                        @error('licence')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror          
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-md-2">Gender: </label>
                        <div class="col-md-9">
                            <input type="radio" id="male" name="gender" value="Male" {{ (isset($doctors->gender) && $doctors->gender=="Male")? "checked" : "" }} >
                            Male
                            <input type="radio" id="female" name="gender" value="Female" {{ (isset($doctors->gender) && $doctors->gender=="Female")? "checked" : "" }}>
                            Female
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" id="no" name="opt_clinic" value="no">
            <input type="hidden" id="terms" name="terms" value="yes">

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group ">
                        <label for="dob">Date of Birth<span class="mand">*</span></label>
                        <input type="date" min="1950-01-01" max="<?php echo date('Y-m-d') ?>"  class="form-control @error('dob') is-invalid @enderror" id="dob" placeholder="" name="dob" value="{{isset($doctors->dob) ? $doctors->dob : old('dob')}}">
                        @error('dob')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="col-md-2">Photo:</label>
                        <div class="col-md-2">
                           <!-- <input name="banner" class="form-control" id="banner" value="{{isset($page_details->banner) ? $page_details->banner  : ''}}" /> -->
                            <input type="file" name="photo" id="photo" multiple="">
                        </div>
                        @if (isset($doctors->photo))
                        <div class="col-md-2">
                            <img height="100%" width="100%" src="../uploads/{{$doctors->photo}}">
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12">

                    <div class="form-group">
                        <label >Basic Summary: </label>
                        <!--<div class="col-md-12">-->
                            <input name="summary" class="form-control" id="summary" value="{{isset($doctors->summary) ? $doctors->summary : ''}}" />
                        <!--</div>-->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label >Address Line1: </label>
                        <input name="address_line1" class="form-control @error('address_line1') is-invalid @enderror" id="address_line1" value="{{isset($doctors->address_line1) ? $doctors->address_line1 : old('address_line1')}}" />
                        @error('address_line1')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Address Line2: </label>
                        <input name="address_line2" class="form-control" id="address_line2" value="{{isset($doctors->address_line2) ? $doctors->address_line2 : old('address_line2')}}" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label >Address Line3: </label>
                        <input name="address_line3" class="form-control" id="address_line3" value="{{isset($doctors->address_line3) ? $doctors->address_line3 : old('address_line3')}}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">

                    <div class="form-group">
                        <label>Country:</label>
                        <!--<div class="col-md-9">-->
                        <select class="form-control countries @error('address_country') is-invalid @enderror" id="countryId" aria-describedby="address_country" placeholder="Country" name="address_country" data-value="{{isset($doctors) && !empty($doctors) ? $doctors->address_country : old('address_country')}}">
                            <option value="" >Select Country</option>
                        </select>
                        @error('address_country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror  
                        <!--</div>-->
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>State:</label>
                        <!--<div class="col-md-9">-->
                        <select class="form-control states @error('address_state') is-invalid @enderror" name="address_state" class="states" id="stateId" data-value="{{isset($doctors) && !empty($doctors) ? $doctors->address_state : old('address_state')}}">
                            <option value="">Select State</option>
                        </select>
                        @error('address_state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <!--</div>-->
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>City:</label>
                        <!--<div class="col-md-9">-->
                        <select class="form-control cities @error('address_city') is-invalid @enderror" name="address_city" class="cities" id="cityId" data-value="{{isset($doctors) && !empty($doctors) ? $doctors->address_city : old('address_city')}}">
                            <option value="">Select City</option>
                        </select>
                        @error('address_city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <!--</div>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group ">
                        <label class="col-md-6">Time Zone: </label>
                        <div class="col-md-12">
                            <select class="form-control timezones @error('timezone') is-invalid @enderror" name="timezone" id="timezones" data-value="{{isset($doctors) && !empty($doctors) ? $doctors->timezone : old('timezone')}}">
                                <option value="">Select Timezone</option>
                            </select>
                            @error('timezone')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-md-6">Postal Code: </label>
                        <div class="col-md-12">
                            <input name="address_postcode" class="form-control  @error('address_postcode') is-invalid @enderror" id="address_postcode" value="{{isset($doctors->address_postcode) && !empty($doctors) ? $doctors->address_postcode : old('address_postcard')}}" />
                            @error('address_postcode')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
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
            <h3>Know Languages</h3>
            <hr/>
            <br/>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Languages:  </strong></label>
                <div class="col-md-9">
                    <div class="select2-primary">
                        <select class="form-control" multiple="multiple" data-plugin="select2" data-placeholder="Select Known Language" name="languages[]">
                            @foreach($languageData as $lang)
                            <option value="{{$lang->id}}" @if(isset($selected_langs) && in_array($lang->id, $selected_langs)) selected @endif>{{$lang->value}}</option>
                            @endforeach    
                        </select>
                    </div>
                </div>
            </div>
            <h3>Mata Types</h3>
            <hr/>
            <br/>
            @foreach($doctorMetaTypes as $docMeta)
            <div class="form-group  row">
                <label class="col-md-2"><strong> {{ucwords($docMeta->dmetaname)}}:  </strong></label>
                <div class="col-md-9">
                    <textarea class="form-control" id="{{$docMeta->dmetaname}}" data-plugin="summernote" name="{{$docMeta->dmetaname}}" rows="5" cols="5">
                        {{isset($docMetaList[$docMeta->dmeta_id]) ? $docMetaList[$docMeta->dmeta_id] : '' }}
                    </textarea>
<!--                    <input name="{{$docMeta->dmetaname}}" id="{{$docMeta->dmetaname}}" class="form-control" 
                           value="{{isset($docMetaList[$docMeta->dmeta_id]) ? $docMetaList[$docMeta->dmeta_id] : '' }}" />-->
                    @error($docMeta->dmetaname)
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            @endforeach
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group form-material row">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                            <button type="button" onclick="window.location.href = '/admin/doctors/'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection