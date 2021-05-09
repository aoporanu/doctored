@extends('Admin::layouts.admin')
@section('content')

<h3 class="page-title">Profile</h3><br/>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
    @if($msg)
    <div class="alert dark alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                    {{$msg}}
                  </div>
   @endif
        <form action="/admin/profile" method="post" enctype="multipart/form-data">
            <div class="form-group  row">
                <label class="col-md-2"><strong> User Name:  </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="user_id" value="{{isset($userDetails) ? $userDetails->user_id : 0}}" />
                    <input name="user_name" id="user_name" class="form-control  @error('user_name') is-invalid @enderror" value="{{isset($userDetails) ? $userDetails->user_name : ''}}" readonly/>
					 @error('user_name')
                  <span class="invalid-feedback" role="alert">
                  {{ $message }}
                  </span>
                  @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Email:  </strong></label>
                <div class="col-md-9">

                    <input name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{isset($userDetails) ? $userDetails->email : ''}}" readonly/>
					 @error('email')
                  <span class="invalid-feedback" role="alert">
                  {{ $message }}
                  </span>
                  @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Old Password:  </strong></label>
                <div class="col-md-9">

                    <input type="password" name="old_password" id="old_password" class="form-control  @if($error) is-invalid  @endif" value="" />
					 @if($error)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $error }}</strong>
                                                    </span>
                                                @endif
                </div>
            </div>
			
			<div class="form-group  row">
                <label class="col-md-2"><strong> New Password:  </strong></label>
                <div class="col-md-9">

                    <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" value="" />
					 @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                </div>
            </div>
			
			 <div class="form-group row">
                              <label class="col-md-2" for="password_confirmation"><strong>Confirm New Password</strong></label>
							   <div class="col-md-9">
                              <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="">
                              @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                          </div>
                        </div>
                 

           
                <div class="form-group row">
                    <label class="col-md-2"><strong>Photo: </strong></label>
                     <div class="col-md-3">
                        <input type="file" name="photo" id="photo" multiple="">
                     </div>
                    @if(isset($userDetails->photo))
                    <div class="col-md-2">
                        <img height="100%" width="100%" src="../../uploads/{{$userDetails->photo}}">
                    </div>
                    @endif
                </div>
            
            
         

               <div class="form-group row">
                  <label class="col-md-2"><strong>Gender:</strong> </label>
                  <div class="col-md-9">
                     <input type="radio" id="male" name="gender" value="Male" {{ (isset($userDetails->gender) && $userDetails->gender=="Male")? "checked" : "" }} >
                     Male
                     <input type="radio" id="female" name="gender" value="Female" {{ (isset($userDetails->gender) && $userDetails->gender=="Female")? "checked" : "" }}>
                     Female
                  </div>
               </div>
         

           
               <div class="form-group row">
                  <label for="dob"  class="col-md-2"><strong>Date of Birth: </strong><span class="mand">*</span></label>
                  <div class="col-md-9">
                  <input type="date" min="1950-01-01" max="<?php echo date('Y-m-d')?>"  class="form-control @error('dob') is-invalid @enderror" id="dob" placeholder="" name="dob" value="{{isset($userDetails->dob) ? $userDetails->dob : ''}}">
                 @error('dob')
                  <span class="invalid-feedback" role="alert">
                  {{ $message }}
                  </span>
                  @enderror 
               </div>
               </div>
            
            
        
            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/dashboard'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


