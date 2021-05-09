@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Consultation Types</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
                <form action="/admin/add_consultation" method="post">
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Consultation Type Name: </strong></label>
                        <div class="col-md-9">
                        <input type="hidden" name="ctype_id" value="{{isset($consultationtypes->ctype_id) ? $consultationtypes->ctype_id : 0}}" />
                          <input name="ctype_name" class="form-control @error('ctype_name') is-invalid @enderror" id="ctype_name" value="{{isset($consultationtypes->ctype_name) ? $consultationtypes->ctype_name : ''}}" />
                          @error('ctype_name')
                          <span class="invalid-feedback" role="alert">
                          {{ $message }}
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Consultation Type Icon :</strong></label>
                        <div class="col-md-9">
                        <input name="ctype_icon" class="form-control" id="ctype_icon" value="{{isset($consultationtypes->ctype_icon) ? $consultationtypes->ctype_icon : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Consultation Type Description: </strong></label>
                        <div class="col-md-9">
                        <textarea class="form-control" name="ctype_descrption">{{isset($consultationtypes->ctype_descrption) ? $consultationtypes->ctype_descrption : ''}}</textarea>
                        </div>
                      </div>
                      
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                          <button type="button" onclick="window.location.href='/admin/consultationtypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                    </form>
                  </div>

</div>
@endsection