@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Doctor Meta Types</h3>
<div class="panel">

<br/>
                <div class="example-wrap panel-body container-fluid">
                <form action="/admin/add_doctormetatype" method="post">
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Doctor Meta Name: </strong></label>
                        <div class="col-md-9">
                        <input type="hidden" name="dmeta_id" value="{{isset($metatypes->dmeta_id) ? $metatypes->dmeta_id : 0}}" />
                        
                          <input name="dmetaname" class="form-control @error('dmetaname') is-invalid @enderror" id="dmetaname" value="{{isset($metatypes->dmetaname) ? $metatypes->dmetaname : ''}}" onKeyup ="setMetakey()" required/>
						  @error('dmetaname')
                  <span class="invalid-feedback" role="alert">
                  {{ $message }}
                  </span>
                  @enderror
                        </div>
                      </div>

                      
                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Doctor Meta key :</strong></label>
                        <div class="col-md-9">
                        <input name="dmetakey" class="form-control @error('dmetakey') is-invalid @enderror" id="dmetakey" value="{{isset($metatypes->dmetakey) ? $metatypes->dmetakey : ''}}" readonly required/>
						  @error('dmetakey')
                  <span class="invalid-feedback" role="alert">
                  {{ $message }}
                  </span>
                  @enderror
                        </div>
                      </div>
                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Doctor Meta Lang Code:</strong></label>
                        <div class="col-md-9">
                        <input name="dmeta_lang_code" class="form-control" id="dmeta_lang_code" value="{{isset($metatypes->dmeta_lang_code) ? $metatypes->dmeta_lang_code : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Doctor Meta Icon: </strong></label>
                        <div class="col-md-9">
                         
                        <input name="dmeta_icon" class="form-control" id="dmeta_icon" value="{{isset($metatypes->dmeta_icon) ? $metatypes->dmeta_icon : ''}}" />
                        </div>
                      </div>

                                       
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                          <button type="button" onclick="window.location.href='/admin/settings/doctorsmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                    </form>
                  </div>

</div>
<script>
function setMetakey(){
    var title = $('#dmetaname').val();
    title = title.replace(/\s+/g, '-').toLowerCase();
    $('#dmetakey').val(title);
  }
</script>
@endsection