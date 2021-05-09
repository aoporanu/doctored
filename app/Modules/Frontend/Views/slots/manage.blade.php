@extends('Frontend::layouts.frontend')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" " />
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mt-2">
              <ol>
                <li><a href="/">Home</a></li>
                <li>Manage Slots</li>
              </ol>
              </div>

            <div class="col-lg-9 col-md-9 col-12">
              <div class="row justify-content-end">
                <div class="col-lg-6 col-md-6 col-12">

                </div>
            </div>
            </div>
          </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
<section class="inner-page">
      <div class="container">
        <!-- page-title -->
				<div class="page-title-1 pb-3" style="display:none">
						<div class="row doc-block ml-0 mr-0">
							<div class="col-12">
								<div class="row">
									<!-- <div class="col-lg-2 col-md-2 col-sm-2 col-12 avatar-circle"><img src="assets/img/avatars/doctor.png" alt="doc-avatar" /></div> -->
										<div class="col-12">
											<ul class="doc-details">
												<li><span>8th</span> December, Tuesday</li>
												<li><span>09</span> Total Appointments</li>
												<li><span>02</span> Cancel Appointments</li>
											</ul>
										</div>
								</div>
							</div>
						</div>

        </div><!-- End / page-title -->

        <!-- Section -->
			<section class="md-section sldr-slot circle-1 pb-0 pt-2">

				<div class="container pb-3">

					<div class="row">
						<div class="col-12 pl-0 pr-0"><h4 class="txt-green">Manage Slots</h4></div>
						<div class="col-12 card">
							<div class="card-body pt-3 pb-3 pl-0 pr-0">
								<a href="{{ route('slot.configure', [generateRandomString()]) }}" class="text-white btn  btn-danger" > <i class="fas fa-calendar-day"></i> &nbsp;&nbsp;Configure</a>

							</div>
						</div>

					</div>
					<div class="row">

										<div class="col-12 d-flex justify-content-center"> @if(Session::has('success'))
											<div class="alert alert-success"> {{ Session::get('success') }} </div> @endif </div>
					</div>

			</div>
			</section>
      <!-- End / Section -->

      <!-- Section -->
			<section class="md-section pt-3 pb-3">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 xs-top">
						<div class="row">
						<div class="col-8">
							<h4 class="txt-green">Availble  Configuration</h4>
							</div>
								<div class="col-4">

								@if(isset($hospitals))
							Hospital Name
						<select name="hs" class="hs">
						<option value="">Select</option>
						 <?php
						 $sel = "";
						 foreach($hospitals as $hkey=>$hval){

							 if(isset($_GET['h']) && (base64_encode($hval->hospital_id)==$_GET['h'])){
							  $sel = "selected='selected'";
								}
							 else{
								 $sel = '';
							 }
							 echo "<option ". $sel." value='".base64_encode($hval->hospital_id)."'>".ucfirst($hval->hospital_name)."</option>";

						 }

						 ?>
						 </select>

						<!--<div class="row">
						<a href="#" class="text-white btn  btn-info" >Filter</a>
						</div>-->
						@endif
						&nbsp;&nbsp;&nbsp;
						<a href="/manage-slots"><i class="fas fa-refresh"></i></a>

						</div> </div>
								</div>
							</div>
							<div class="card man-con">
								<div class="card-body p-0">
									<div class="row brd-btm mt-3 mb-3 ml-0 mr-0 mn-head " >
							<!--<div class="col-2"><h6>		ConfID</div>-->
		<div class="col-3"><h6>Hospital Name</h6> </div>
		<div class="col-2"><h6>Start Date</h6></div>

		<div class="col-2"><h6>End Date</h6></div>
		<div class="col-2"><h6>Total</h6> </div>

		<div class="col-3"><h6>Action</h6></div>

								</div>
									@foreach($screen_data as $s_key=>$s_val)

								<div class="row brd-btm mt-3 mb-3 ml-0 mr-0 mn-head " >

									<!--<div class="col-2" style="font-size:12px"> {{$s_val['screen_id']['screen_id']}} </div>-->
									   <div class="col-3">{{ucfirst($s_val['hospital_name'])}}</div>
										<div class="col-2">{{$s_val['startdate']}}</div>
										<div class="col-2">{{$s_val['enddate']}} </div>
											<div class="col-2">{{$s_val['total']}} </div>
									 	 <div class="col-3">
										 <a href="/slotsdetails?s={{$s_val['screen_id']['screen_id']}}&h={{base64_encode($s_val['hospital_id'])}}"  >
 <i class="fas fa-clipboard-list"></i></a> &nbsp;&nbsp;
  <a onClick="return confirm('Deleted configuration cannot be rollback ,please review')" href="/deletedetails?s={{$s_val['screen_id']['screen_id']}}&h={{base64_encode($s_val['hospital_name'])}}"  >
 <i class="fas fa-trash-alt"></i></a>
										 </div>


                                </div>
									@endforeach

								</div>
							</div>
						</div>


					</div>
			</section>
			<!-- End / Section -->


      </div>
    </section>
	<style type="text/css">
	.mn-head h6{
		font-weight:bold;
	}
	</style>

<script type="text/javascript">
$(document).ready(function(){

	$('.hs').change(function(){
		console.log($('.hs').val());
	if($(this).val()!=''){
		//var uid = $("select.hs option").filter(":selected").val();
var uid = $(this).val();
		var url = "/manage-slots?h="+uid;
 window.location.href = url;
	}else{
window.location.href = "/manage-slots";
}
	});
});
</script>
@endsection


<?php
function generateRandomString($length = 15) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
?>
