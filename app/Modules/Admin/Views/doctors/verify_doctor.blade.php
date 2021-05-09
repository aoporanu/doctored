@extends('Admin::layouts.admin')
@section('content')
<h3>Doctor verification</h3>
<div class="panel">

         
<br/>
                <div class="example-wrap panel-body container-fluid">
                
                <form action="/admin/doctor/verify/{{\App\Http\Middleware\EncryptUrlParams::encrypt($doc->id)}} " method="post">
                      <div class="form-group row">
                      <div class="media">
				  <div class="pr-20">
          @if($doc->is_verified!=1) 
          <a class="avatar  avatar-away" href="javascript:void(0)">
          @else
          <a class="avatar  avatar-online" href="javascript:void(0)">
          @endif
                          <img src="/material/global/portraits/5.jpg" alt=""><i></i></a>
                      </div>
				  <div class="media-body">
                        <h5 class="mt-0 mb-5">
                          <span class="name">{{$doc->title}}.{{ucfirst($doc->firstname)}}  {{$doc->lastname}}
                           ( {{$doc->doctorcode}} )
                         
						   @if($doc->is_verified!=1)
						    <small class="badge badge-round badge-warning" >Pending verification</small>
						@else
							<small class="badge badge-round badge-info">Verified</small>
						
							@endif

              @if($doc->is_rejected==1)
              <small class="badge badge-round badge-danger">Rejected</small>
              @endif
              </span>
                          </h5>
			
                       
                       
                      </div>
				  </div>
                      </div>
             
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Licence Number :</strong></label>
                        <div class="col-md-9"> {{$doc->licence}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Status </strong></label>
                        <div class="col-md-9">
                        <select id="status" name="status"  class="form-control">
                        <option value="approved" style="color:green">Approved</option>
                        <option value="rejected" style="color:red">Rejected</option>
                       
                        </select>
                        
                       </div>

                      </div>
                      <div class="form-group  row">
                        <label class="col-md-2">   <label for="verification_summary"><strong>Summary</strong><span style="color:red ">*</span></label>
                     </label>
                        <div class="col-md-9">
                                        
                                        <input type="text" class="form-control @error('verification_summary') is-invalid @enderror"  id="verification_summary"  name="verification_summary" value="{{ old('verification_summary')}}">
                                            @error('verification_summary')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    
                       
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Verified By </strong></label>
                        <div class="col-md-9">
                        {{Session::get('user_name') ? ucwords(Session::get('user_name')): 'Test'}}
                        <input readonly type= "hidden" name="verified_user" class="form-control" id="verified_user" value="<?php echo Session::get('user_id');?>" />
                        </div>
                      </div>

                    @if($doc->is_rejected=='1')

                    <div class="form-group  row">
                        <label class="col-md-2"><strong>Last Verified By </strong></label>
                        <div class="col-md-9">
                      <strong> ID:</strong> {{$doc->verified_user}} <strong>Reason :</strong> {{$doc->verification_summary}}</strong>
                        </div>
                      </div>
                    @endif
                                       
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit  </button>
                          
                          <button type="button" onclick="window.location.href='/admin/doctors'" class="btn btn-default btn-outline waves-effect waves-classic">Cancel</button>
                      
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