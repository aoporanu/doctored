@extends('Admin::layouts.admin')
@section('content')
<h3>View Members</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
                
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Patient Code: </strong></label>
                        <div class="col-md-9">
                        
                        
                          {{isset($patients->patientcode) ? $patients->patientcode : ''}}
                        </div>
                      </div>

                      
                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Title :</strong></label>
                        <div class="col-md-9">
                       {{isset($patients->title) ? $patients->title : ''}}
                        </div>
                      </div>
                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> First Name:</strong></label>
                        <div class="col-md-9">
                        {{isset($patients->firstname) ? $patients->firstname : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Last Name: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->lastname) ? $patients->lastname : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Gender: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->gender) ? $patients->gender : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Dob: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->dob) ? $patients->dob : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Photo: </strong></label>
                        <div class="col-md-9">
                        @if (isset($patients->photo))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../uploads/{{$patients->photo}}">
                        </div>
                        @endif
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Phone: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->phone) ? $patients->phone : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Email: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->email) ? $patients->email : ''}}
                        </div>
                      </div>

                      <!-- <div class="form-group  row">
                        <label class="col-md-2"><strong>Password: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->password) ? $patients->password : ''}}
                        </div>
                      </div> -->

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Address Line 1: </strong></label>
                        <div class="col-md-9">
                       {{isset($patients->address_line1) ? $patients->address_line1 : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Address Line 2: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->address_line2) ? $patients->address_line2 : ''}}
                      </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Address Line 3: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->address_line3) ? $patients->address_line3 : ''}}
                        </div>
                      </div>


                      <div class="form-group  row">
                        <label class="col-md-2"><strong>City: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->address_city) ? $patients->address_city : ''}}
                        </div>
                      </div>


                      <div class="form-group  row">
                        <label class="col-md-2"><strong>State: </strong></label>
                        <div class="col-md-9">
                   {{isset($patients->address_state) ? $patients->address_state : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Country: </strong></label>
                        <div class="col-md-9">
                      {{isset($patients->address_country) ? $patients->address_country : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Postal Code: </strong></label>
                        <div class="col-md-9">
                     {{isset($patients->address_postcode) ? $patients->address_postcode : ''}}
                        </div>
                      </div>

                      <!-- <div class="form-group  row">
                        <label class="col-md-2"><strong>Present Address: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->address_address) ? $patients->address_address : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Permanent Address: </strong></label>
                        <div class="col-md-9">
                       {{isset($patients->address_long) ? $patients->address_long : ''}}
                        </div>
                      </div> -->

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Last Screening: </strong></label>
                        <div class="col-md-9">
                      {{isset($patients->last_screening) ? $patients->last_screening : ''}}
                        </div>
                      </div>

                      <!-- <div class="form-group  row">
                        <label class="col-md-2"><strong>Last Screening Date: </strong></label>
                        <div class="col-md-9">
                       {{isset($patients->last_screening_date) ? $patients->last_screening_date : ''}}
                        </div>
                      </div> -->

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Emergency Contact First name: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->emer_firstname) ? $patients->emer_firstname : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Emergency Contact Last name: </strong></label>
                        <div class="col-md-9">
                        {{isset($patients->emer_lastname) ? $patients->emer_lastname : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Emergency Contact Phone: </strong></label>
                        <div class="col-md-9">
                      {{isset($patients->emer_phone) ? $patients->emer_phone : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Emergency Contact Email: </strong></label>
                        <div class="col-md-9">
                       {{isset($patients->emer_email) ? $patients->emer_email : ''}}
                        </div>
                      </div>

                      <!-- <div class="form-group  row">
                        <label class="col-md-2"><strong>Terms: </strong></label>
                        <div class="col-md-9">
                       {{isset($patients->terms) ? $patients->terms : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Visitor: </strong></label>
                        <div class="col-md-9">
                       {{isset($patients->visitor) ? $patients->visitor : ''}}
                        </div>
                      </div> -->
                      

                                       
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button" onclick="window.location.href='/admin/edit_member?patient_id={{$patients->id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/members'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                 
                  </div>

</div>

@endsection