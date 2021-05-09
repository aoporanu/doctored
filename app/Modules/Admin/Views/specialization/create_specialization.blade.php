@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Specializations</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
                <form action="/admin/add_specialization" method="post">
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specialization Name: </strong></label>
                        <div class="col-md-9">
                        <input type="hidden" name="id" value="{{isset($specializations->id) ? $specializations->id : 0}}" />
                          <input name="specialization_name" class="form-control" id="specialization_name" value="{{isset($specializations->specialization_name) ? $specializations->specialization_name : ''}}" required />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Short Code :</strong></label>
                        <div class="col-md-9">
                        <input name="specialization_shortcode" class="form-control" id="specialization_shortcode" value="{{isset($specializations->specialization_shortcode) ? $specializations->specialization_shortcode : ''}}" required />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specialization Description: </strong></label>
                        <div class="col-md-9">
                        <textarea class="form-control" name="specialization_description">{{isset($specializations->specialization_description) ? $specializations->specialization_description : ''}}</textarea>
                        </div>
                      </div>

                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Specialization Parent :</strong></label>
                        <div class="col-md-9">
                        <input name="specialization_parent" class="form-control" id="specialization_parent" value="{{isset($specializations->specialization_parent) ? $specializations->specialization_parent : ''}}" />
                        </div>
                      </div>

                   

                      
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                          <button type="button" onclick="window.location.href='/admin/specializations'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                    </form>
                  </div>

</div>
@endsection