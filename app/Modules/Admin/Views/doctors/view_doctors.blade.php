@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Doctors</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
               
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Doctor Code: </strong></label>
                        <div class="col-md-9">
                      
                        
                        {{isset($doctors->doctorcode) ? $doctors->doctorcode : ''}}
                        </div>
                      </div>

                      
                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Title :</strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->title) ? $doctors->title : ''}}
                        </div>
                      </div>
                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>First Name:</strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->firstname) ? $doctors->firstname : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Last Name: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->lastname) ? $doctors->lastname : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Phone: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->phone) ? $doctors->phone : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Email: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->email) ? $doctors->email : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Licence: </strong></label>
                        <div class="col-md-9">
               {{isset($doctors->licence) ? $doctors->licence : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Is Clinic: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->opt_clinic) ? $doctors->opt_clinic : ''}}
                        </div>
                      </div>

                      

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Terms: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->terms) ? $doctors->terms : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Gender: </strong></label>
                        <div class="col-md-9">
                      {{isset($doctors->gender) ? $doctors->gender : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Dob: </strong></label>
                        <div class="col-md-9">
                      {{isset($doctors->dob) ? $doctors->dob : ''}}
                      </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Photo: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->photo) ? $doctors->photo : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Summary: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->summary) ? $doctors->summary : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Address Line1: </strong></label>
                        <div class="col-md-9">
                  {{isset($doctors->address_line1) ? $doctors->address_line1 : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Address Line2: </strong></label>
                        <div class="col-md-9">
                    {{isset($doctors->address_line2) ? $doctors->address_line2 : ''}}
                        </div>
                      </div>

                      
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Address Line3: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->address_line3) ? $doctors->address_line3 : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>City: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->address_city) ? $doctors->address_city : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>State: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->address_state) ? $doctors->address_state : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Country: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->address_country) ? $doctors->address_country : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Postal Code: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->address_postcode) ? $doctors->address_postcode : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Present Address: </strong></label>
                        <div class="col-md-9">
                       {{isset($doctors->address_address) ? $doctors->address_address : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Permanent Address: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->address_long) ? $doctors->address_long : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Activation Key: </strong></label>
                        <div class="col-md-9">
                      {{isset($doctors->activation_key) ? $doctors->activation_key : ''}}
                      </div>
                      </div>
                    
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specilizations: </strong></label>
                        <div class="col-md-9">
                      {{isset($specializationList) ? implode(',', $specializationList) : ''}}
                      </div>
                      </div>
                    
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Consultation Types: </strong></label>
                        <div class="col-md-9">
                      {{isset($consultationList) ? implode(',', $consultationList) : ''}}
                      </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Visitor: </strong></label>
                        <div class="col-md-9">
                        {{isset($doctors->visitor) ? $doctors->visitor : ''}}
                        </div>
                      </div>


                                       
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button" onclick="window.location.href='/admin/edit_doctors?id={{$doctors->id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/doctors/'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                  
                  </div>

</div>

@endsection