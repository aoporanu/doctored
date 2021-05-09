@extends('Frontend::layouts.frontend')
@section('content')
<section class="inner-page">
      <div class="container">
	      <div class="user-ragistration">
          <div class="container register">
                        <div class="row">
                            <div class="col-md-3 register-left">
                                <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                                <h3>We're here with you</h3>
                                <p>Happily  reset your password and enjoy the journey</p>
                            </div>
                            <div class="col-md-9 register-right ">
                              <div class="reset-pwd register-form justify-content-center" >
                                  <h3 class="card-title text-center txt-green">Reset Password</h3>
												  @if (session('status'))
									<div class="alert alert-success" role="alert">
										{{ session('status') }}
									</div>
									@endif
									 @if(Session::has('error'))
											<div class="alert alert-danger">{{ Session::get('error') }}</div>
												@endif
                                  
                                  <div class="card-text">
								   
                                     <form action="{{ route('doctor.password.email') }}" method="POST" id="emailForm">
  @csrf
  
											<div class="form-group">
											  
                                                <div class="radiobuttons">
                                                  <div class="rdio rdio-primary radio-inline"> 
												   
                                    <input type="radio" name="type" value="patient" id="Consultation" checked>
                                    
                                                    <label for="Consultation">Consultation</label>
                                                  </div>
                                                  <div class="rdio rdio-primary radio-inline">
                                                  	<input type="radio" name="type" value="doctor" id="Doctor">
												     <label for="Doctor">Doctor</label>
                                                  </div>
                                                </div>
                                              </div>
                                      <div class="form-group">
                                     
										<input type="hidden" name="type" value="1"/>
                                <input type="text" id="email" class="form-control" name="email" placeholder="Email Address *" value="" required  value="{{ old('email') }}" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                   
                              
                                      <button type="submit" class="btn btn-primary btn-block">  {{ __('Send Reset Link') }}</button>
                                    </form>
                                  </div>
                                
                              </div>
                            </div>
                        </div>
        
                    </div>
        </div>
	  </div>
</section>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
    $(document).ready(function(){

        $("#Doctor").click(function(){
            var baseUrl = "{{  route('doctor.password.email') }}";
            $("#emailForm").attr("action",baseUrl);
        });
        $("#Consultation").click(function(){
            var baseUrl = "{{  route('member.password.email') }}";
            $("#emailForm").attr("action",baseUrl);
        });
    });
</script>
@endsection
