@extends('Admin::layouts.admin')
@section('content')
<h3>View Doctor Meta Types</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
               
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Doctor Meta Name: </strong></label>
                        <div class="col-md-9">
                       
                        
                          {{isset($metatypes->dmetaname) ? $metatypes->dmetaname : ''}}
                        </div>
                      </div>

                      
                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Doctor Meta key :</strong></label>
                        <div class="col-md-9">
                       {{isset($metatypes->dmetakey) ? $metatypes->dmetakey : ''}}
                        </div>
                      </div>
                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Doctor Meta Lang Code:</strong></label>
                        <div class="col-md-9">
                       {{isset($metatypes->dmeta_lang_code) ? $metatypes->dmeta_lang_code : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Doctor Meta Icon: </strong></label>
                        <div class="col-md-9">
                         
                       {{isset($metatypes->dmeta_icon) ? $metatypes->dmeta_icon : ''}}
                        </div>
                      </div>

                                       
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button" onclick="window.location.href='/admin/edit_doctormetatype/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$metatypes->dmeta_id)}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/settings/doctorsmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>

                  </div>

</div>
@endsection