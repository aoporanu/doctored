@extends('Frontend::layouts.frontend') @section('content')
<section class="inner-page">
	<div class="container">
		<div class="user-ragistration">
			<div class="container register">
				<div class="row">
					<div class="col-md-3 register-left"> <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt="" />
						<h3>Welcome</h3>
						<p>You are 30 seconds away to start your journey with us!</p>
					</div>
					<div class="col-md-9 register-right">
						<input type="hidden" name="save_opt" id="save_opt" value="{{$e = session()->get('tab_name')}}" />
						<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
							<li class="nav-item"> <a class="nav-link " id="home-tab" data-toggle="tab" onClick="window.location='login'" role="tab" aria-controls="home" aria-selected="false">Login</a> </li>
							<li class="nav-item"> <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Register</a> </li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show" id="home" role="tabpanel" aria-labelledby="home-tab"> </div>
							<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
								<h3 class="register-heading">Not a Member, Please Register</h3>
								<form method="post" action="register" autocomplete="off" name="reg_form" class="reg_form">
									<div class="row register-form">
										<div class="col-12 d-flex justify-content-center"> @if(Session::has('success'))
											<div class="alert alert-success"> {{ Session::get('success') }} </div> @endif </div>
										<div class="col-12 d-flex justify-content-center">
											<div class="form-group">
												<div class="radiobuttons">
													<div class="rdio rdio-primary radio-inline">
														<input name="screen_opt" value="patient" class="screen_opt" id="radio1" type="radio" checked>
														<label for="radio1">Consultation</label>
													</div>
													<div class="rdio rdio-primary radio-inline">
														<input name="screen_opt" value="doctor" class="screen_opt" id="radio2" type="radio">
														<label for="radio2">Doctor</label>
													</div>
												</div>
											</div>
										</div>
										<!--<div class="row">
                                 <div class="col-md-6">test
                                 </div>
                                 <div class="col-md-6">test
                                 </div>

                                 </div>-->
										<!------ LEFT ----->
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" placeholder="First Name *" name="firstname" value="{{ old('firstname')}}"> @error('firstname') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
											<div class="form-group">
												<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email Address" name="email" value="{{ old('email')}}"> @error('email') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span> @enderror
												<!--  <span  style="margin:1px;">&nbsp;</span>--></div>
											<div class="form-group">
												<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" aria-describedby="password" placeholder="password" name="password" value="{{old('password')}}"> @error('password') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
											<div class="form-group clinic">
												<input type="text" class="form-control @error('licence') is-invalid @enderror" id="licence" placeholder="licence" name="licence" value="{{ old('licence')}}"> @error('licence') <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                               </span> @enderror
												<!--for licence and dob -->
											</div>
										</div>
										<!------ END OF LEFT ---- ->
										<!------ RIGHT ----->
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" placeholder="Last Name *" name="lastname" value="{{ old('lastname')}}"> @error('lastname') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
											<div class="form-group">
												<div class="row">
													<div class="col-sm-4">
														<select class="phonecode pc form-control" name="phonecode">
                                                            @foreach($phoneCodes as $phoneCode)
                                                                <option value="{{$phoneCode->id}}"{{ old('phonecode') == $phoneCode->id ? ' selected="selected' : '' }}>{{$phoneCode->name}}</option>
                                                                @endforeach
                                                        </select>
													</div>
													<div class="col-sm-8">
														<input type="text" class="form-control pc @error('phonenumber') is-invalid @enderror" id="phonenumber" aria-describedby="phonenumber" placeholder="Phone Number" name="phonenumber" value="{{ old('phonenumber')}}"> @error('phonenumber') <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span> @enderror </div>
													<!--<span class="phonetext" style="margin:1px;font-size:8px">&nbsp;</span>-->
													<input type="hidden" name="phone" id="phone" class="phone form-control pc @error('phone') is-invalid @enderror" /> @error('phone') <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span> @enderror </div>
											</div>
											<div class="form-group">
												<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm password" name="password_confirmation" value="{{old('password_confirmation')}}"> @error('password_confirmation') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
											<div class="form-group clinic">
												<div class="row" style="padding-top:3px">
													<div class="col-sm-4">
														<div style="margin-right: 30px;">
															<label for="is_clinic">Clinic</label>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-radio" style="margin-left: 5px;">
															<input class="form-check-input" type="radio" name="is_clinic" class="is_clinic" value="yes">
															<label class="form-check-label" for="no"> Yes </label>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-check" style="margin-left: 5px;">
															<input class="form-check-input" type="radio" name="is_clinic" class="is_clinic" value="no" checked>
															<label class="form-check-label" for="no"> No </label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<button type="submit" class="btn btn-signup btnRegister" style="margin-top: 15px;">Join Me</button>
											</div>
										</div>
									</div>
									<!------END OF RIGHT ----->
							</div>
						</div> {{csrf_field()}} </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
</section>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="/frontend/locate.js"></script>
<script src="/assets/js/purl.js"></script>
<script type="text/javascript">
function enablePatient() {
	$('.clinic input').attr("disabled", "disabled");
	$('.reg_form').attr('action', 'register');
	$('.clinic').hide();
	// $('#save_opt').val('mem_link');
}

function enableDoctor() {
	$('.clinic input').removeAttr("disabled");
	$('.reg_form').attr('action', 'register_doctor');
	$('.clinic').show();
	// $('#save_opt').val('doc_link');
}

function changeurlparam() {
	//var currentUrl = window.location.href;
	//   var parsedUrl =  purl(currentUrl);
	// var currentPageNum = parsedUrl.param('tab');
}
$(document).ready(function() {
	if($('#save_opt').val() == 'mem_link') {
		$('#radio1').click();
		enablePatient();
	} else {
		if($('#save_opt').val() == '') { //first time load
			$('#radio1').click();
			enablePatient();
		} else {
			$('#radio2').click();
			enableDoctor();
		}
	}
	//default
	$('.screen_opt').change(function() {
		if($(this).val() == 'patient') {
			enablePatient();
		} else {
			enableDoctor();
		}
	});
});
$(document).ready(function() {
	$('.phone').val("+" + $('.phonecode').val() + "-" + $('#phonenumber').val());
	$(".pc").on("change keyup paste blur", function() {
		let phoneNumbers = "+" + $('.phonecode').val() + "-" + $('#phonenumber').val();
		$('.phone').val(phoneNumbers);
		$('.phonetext').html(phoneNumbers);
	});
});
</script> @endsection
