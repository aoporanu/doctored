@extends('Admin::layouts.admin')
@section('content')
<h3>View Specializations</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
                
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specialization Name: </strong></label>
                        <div class="col-md-9">
                        <input type="hidden" name="id" value="{{isset($specializations->id) ? $specializations->id : 0}}" />
                         {{isset($specializations->specialization_name) ? $specializations->specialization_name : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Short Code :</strong></label>
                        <div class="col-md-9">
                       {{isset($specializations->specialization_shortcode) ? $specializations->specialization_shortcode : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specialization Description: </strong></label>
                        <div class="col-md-9">
                        {{isset($specializations->specialization_description) ? $specializations->specialization_description : ''}}
                        </div>
                      </div>

                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specialization Parent :</strong></label>
                        <div class="col-md-9">
                        {{isset($specializations->specialization_parent) ? $specializations->specialization_parent : ''}}
                        </div>
                      </div>

                   

                      
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button" onclick="window.location.href='/admin/edit_specialization?id={{$specializations->id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/specializations'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
             
                  </div>

</div>
@endsection