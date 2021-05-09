@extends('Frontend::layouts.frontend') @section('content')

<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-3 col-12 mt-2">
				<ol>
				 <li><a href="/">Home</a></li>
               <li><a href="/manage-slots">Manage Slots</a></li>
              	<li>Slot Configuration</li>
				</ol>
			</div>
			<div class="col-lg-6 col-md-9 col-12">
				<div class="row justify-content-end">
					<div class="col-lg-6 col-md-6 col-12">
					
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Breadcrumbs Section -->
<section class="inner-page">
	<div class="container">
		<ul class="nav nav-tabs nav-fill wizard" id="myTab" role="tablist">
			<li class="nav-item active"> <a href="#home" class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><span class="step"><i class="fa fa-user-md" aria-hidden="true"></i></span>Configuration</a> </li>
			<li class="nav-item"> <a href="#aboutme" class="nav-link" id="aboutme-tab" data-toggle="tab" role="tab" aria-controls="aboutme" aria-selected="false"><span class="step"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>Review</a> </li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show mbox active" id="home" role="tabpanel" aria-labelledby="home-tab"> @if(count($hospitals_list)>0)
				<div class="col-12" style="margin-top:25px">
					<form name="slot_management" action="" id="slot_management" method="POST"  > 
					<div class="slot_error"></div>
						<input type="hidden" value="" name="screen_id" id="screen_id">
						<div class="row">
							<div class="col-lg-3">
								<h4 class="mb-0">Dates Selection</h4>
							
								</div>
							<div class="col-lg-9" style="text-align:right;">Timezone &nbsp;&nbsp;&nbsp;
										 
								<select name="timezone" class="timezone" style="font-size:12px;font-family:'Open Sans', sans-serif">
									<option value=""></option>
								</select> <a href="/manage-slots"><i class="fas fa-long-arrow-alt-left"></i> &nbsp;&nbsp;&nbsp;Back</a>
         
							</div>
							<input type="hidden" name="timezone_value" class="timezone_value" value="" />
							<input type="hidden" name="userip" class="userip" value="" />
							</div>
							<div class="row">

	
							</div>
						<br/>
						<div class="row">
							<div class="col-lg-9 col-md-9 col-12 doc_sec">
								<!---left side block -->
								<input type="hidden" value="<?php echo csrf_token() ?>" id="token" name="_token">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-12" style="padding:3px;">
										<div class="form-group">

											<h6 class="mb-0">Hospital Name<span class="asterik">*</span></h6>
												<select class="form-control hospital_name" size="1" id="exampleFormControlSelect1" name="hospital_name" required>
												<option value="">Select</option> @foreach ($hospitals_list as $hp)
												<option value="{{$hp['hospital_id']}}">{{ucfirst($hp['hospital_name'])}} </option> @endforeach 
												</select>
												
 
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-12">
										<div class="form-group">
											<h6 class="mb-0">Consultation Type<span class="asterik">*</span></h6>
											<div class="select2-primary">
												<select class="js-example-basic-multiple" id="consulations" name="consultaions[]" multiple="multiple"> @foreach($consultation_types as $consultations)
													<option value="{{$consultations->ctype_id}}" @if(in_array($consultations->ctype_id, $consultation_types_list)) selected @endif>{{$consultations->ctype_name}}</option> @endforeach </select>
											</div>
											<label id="consulations-error" class="error" for="consulations" style="display: none;"></label>
										</div>
									</div>
									<div class="col-sm-4 col-sm-4 col-12">
										<div class="form-group">
											<h6 class="mb-0">Schedule For<span class="asterik">*</span></h6>
											<select class="form-control slot_days" name="slot_days" id="exampleFormControlSelect2">
												<!--previous:exampleFormControlSelect1-->
												<option value="week">Week</option>
												<option value="month">Month</option>
												<option value="custom">Custom</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row" id="cus_slot">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="slot_startdate">Start Date</label>
											<!--<input type="date" class="form-control" id="slot_startdate" value="" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" name="slot_startdate"> -->
											<input type="date" class="form-control" id="slot_startdate" value=""    min="<?php echo date(" Y-m-d "); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"   name="slot_startdate" disabled>
										</div>
                                          
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="slot_enddate">End Date</label>
											<!--<input type="date" class="form-control" id="slot_enddate" name="slot_enddate" value="" min="<?php echo date(" Y-m-d ", strtotime('+1 day')); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"> -->
											   <input type="date" class="form-control" id="slot_enddate" 
                                                    name="slot_enddate" value=""   
                                                     min="<?php echo date(" Y-m-d ", strtotime('+1 day')); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"  disabled>
											
											</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="appointmentTime"> Exclude Days</label>
											<select class="form-control" id="exclud_slotdate" name="exclud_slotdate">
												<option value="">None</option>
												<option value="weekends">Weekends</option>
												<option value="only-Monday">Monday's</option>
												<option value="only-Tuesday">Tuesday's</option>
												<option value="only-Wednesday">Wednesday's</option>
												<option value="only-Thursday">Thursday's</option>
												<option value="only-Friday">Friday's</option>
												<option value="only-Saturday">Saturday's</option>
												<option value="only-Sunday">Sunday's</option>
												<option value="customday">Custom</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group" id="custom_extention_date_block">
											<label for="custom_extention_date">&nbsp;</label>
											<input type="date" class="form-control" style="display:none" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" id="custom_extention_date" name="custom_extention_date"> </div>
									</div>
								</div>
								<hr />
								<div class="row">
									<h4 class="mb-0">Time Selection</h4> </div>
								<br/>
								<div class="row fullday-block" style="font-size:12px;">
									<input type="hidden" name="cons_duration" id="cons_duration" value="<?php echo($doctorInfo['duration']);?>">
									<input type="text"  style="border:none;color:#fff;" name="timeval_status" id="timeval_status" value="fail" readonly > <!-- Not using -->
									<span id="timeval_status-error" class="error"></span>
									<span id="ready_date_values-error" class="error"></span>
									
									<input type="hidden" name="failed" id="failed" value="0">
									
									
									<!---Breaks-->
									<?php 
	           
foreach ($fetch_durations as $fetch_key => $fetch_val)
{ 
    unset($fetch_val['complete']);   unset($fetch_val['start']);unset($fetch_val['end']);
	  $fetch_key = str_replace(" ","",$fetch_key); 
	  ?>
										<div class="col-sm-12">
											<div class="row">
												<!-- main time block-->
												<div class="col-sm-6 shift-partial {{strtolower($fetch_key)}}_time">
													<div class="row">
														<div class="col-sm-3 pt-2">
															<label for="appointmentDate">{{$fetch_key}}</label>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<select class="form-control" id="{{strtolower($fetch_key)}}_time_start" name="{{strtolower($fetch_key)}}_time_start">
																	<option value="">Select</option> @foreach($fetch_val['minutes_start'] as $fetch_sub_key=>$fetch_sub_val)
																	<option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option> @endforeach </select>
															</div>
														</div>
														<div class="col-sm-1 text-center pl-0 pr-0 mt-2">To</div>
														<div class="col-sm-4">
															<div class="form-group">
																<select class="form-control" id="{{strtolower($fetch_key)}}_time_end" name="{{strtolower($fetch_key)}}_time_end">
																	<option value="">Select</option> @foreach($fetch_val['minutes_end'] as $fetch_sub_key=>$fetch_sub_val)
																	<option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option> @endforeach </select>
															</div>
														</div>
													</div>
												</div>
												<!-- end of main time block -->
												<!-- break time block-->
												<div class="col-sm-6 shift-partial {{strtolower($fetch_key)}}_break">
													<div class="row">
														<div class="col-sm-3 pt-2">
															<label for="appointmentDate">Break's if any</label>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<select class="form-control" id="{{strtolower($fetch_key)}}_break_start" name="{{strtolower($fetch_key)}}_break_start">
																	<option value="">Select</option> @foreach($fetch_val['minutes_start'] as $fetch_sub_key=>$fetch_sub_val)
																	<option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option> @endforeach </select>
															</div>
														</div>
														<div class="col-sm-1 text-center pl-0 pr-0 mt-2">To</div>
														<div class="col-sm-4">
															<div class="form-group">
																<select class="form-control" id="{{strtolower($fetch_key)}}_break_end" name="{{strtolower($fetch_key)}}_break_end">
																	<option value="">Select</option> @foreach($fetch_val['minutes_end'] as $fetch_sub_key=>$fetch_sub_val)
																	<option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option> @endforeach </select>
															</div>
														</div>
													</div>
												</div>
												<!-- end break time block -->
												<span class="{{strtolower($fetch_key)}}_error_msg error" ></span>
											</div>
										</div>
										<?php 
}
	  ?>
											<!-- end of Breaks-->
											 </div>
								<br/>
							 
								<div class="row">
									<div class="form-group col-3">
										<button type="submit" class="btn btn-success" onClick="validateForm()" > Save </button>
									</div>
									<!-- saveSlotConfiguration-->
									<div class="form-group col-3">
										<!--<button type="button" class="btn btn-success" onClick="javascript:completeSlotCreationProcess()">Review </button>         -->
									</div>
									<div class="form-group col-3">
										<button type="button" onClick="javascript:window.location.href='/manage-slots'" class="btn btn-danger"> Cancel </button>
									</div>
									<div class="col-3"></div>
								</div>
								<!-- end of left side block-->
							</div>
							<div class="col-lg-3 col-md-3 col-12" style="font-size:12px;color:#000;">
								<!--right side block -->
									<div class="row">
									<div class="card" style="width:100%">
										<div class="card-header" style="background:#edf9e9">Dates</div>
										<div class="card-body" id="selected_dates_list" style="display:block;font-size:12px;color:#000">
											<!--<input type="hidden" name="selected_date_values" id="selected_date_values" value="">--> </div>
									</div>
									<input type="hidden" name="ready_date_values" value="" id="ready_date_values">
									<input type="hidden" name="selected_date_values" id="selected_date_values" value="">
									<div class="card" style="width:100%;">
										<div class="card-header" style="background:#edf9e9"> Selected Dates after excluding </span> &nbsp;&nbsp;(<span id="excluded_what"></span>)&nbsp;&nbsp; </div>
										<div class="card-body" id="selected_dates_list" style="display:block;font-size:12px;color:#000">
											<div class="excluded_dates_list"></div>
											<div class="slot_hospital" style="display:none"></div>
										</div>
									</div>
									<div class="card slot_details" style="width:100%;display:none;background:#edf9e9">
										<div class="card-header">selected Dates</div>
										<div class="card-body">
											<div class="excluded_dates_list"></div>
										</div>
									</div>
									<!-- -->
								</div>
								<!-- end of right side block -->
							</div>
						</div>
					</form>
				</div>
				<!---- end first tab-->
			</div>
			<div class="tab-pane fade mbox" id="aboutme" role="tabpanel" aria-labelledby="aboutme-tab">
					<div class="col-12" style="margin-top:25px">
				<div class="row">
							<div class="col-lg-3">
								<h4 class="mb-0">Review & Submit</h4>
								</div>
				</div>
				<!--<div class="row">
				<div class="col-9">
				Please Review details and click on Complete 
				</div>
				<div class="col-3">
		<button type="button" class="btn btn-success" onClick="javascript:generateSlots()"> Complete Configuration </button>     
									
				</div>
				</div> -->
				<div class="row">
				<div id="review_content">
				<div class="row">
				<div class="col-12">
				
				Please complete Configuration 
				</div>
				</div>
				</div>
				</div>
				</div>
			</div>
		</div> @else
		<center>
			<h3>  No associated Hospital found ...!</h3></center> @endif </section>
			<script src="jquery.validate.min.js"></script> 
<script src="slotConfiguration.js"></script>

 
<script type="text/javascript">

function setZoneVal() {
	$('.timezone_value').val($(".timezone option:selected").text());
}
$(document).ready(function() {
	var queryString = window.location.search;
	$('#screen_id').val(queryString.replace('?', ''));
});
$(document).ready(function() {
	getTimezones();
	setTimeout(setTimezone, 3000);

	function setTimezone() {
		var usercountry = $('.usercountry').val();
		$('.timezone option').filter(function() {
			return $.trim($(this).val()) == usercountry;
		}).attr('selected', 'selected');
		setZoneVal();
	}
});
//Code for get geo location 
function getTimezones() {
	$('.timezone').find("option:eq(0)").html("Please wait..");
	var jqxhr = $.ajax("/getTimezones").done(function(data) {
		$('.timezone').find("option:eq(0)").html("Select Timezone");
		var countrySelectedId = 0;
		var data = JSON.parse(data);
		//console.log(data);
		$.each(data, function(key, val) {
			// console.log(val.name);
			var option = $('<option />');
			option.attr('value', val.countrycode).text(val.utc);
			$('.timezone').append(option);
			//customzied with another method only for screen
			//$('.timezone option')
			//.filter(function() {  return $.trim( $(this).val() ) == 'IN'; }).attr('selected','selected');
		});
	}).fail(function() {
		//  alert( "error" );
	}).always(function() {
		//  alert( "complete" );
	});
}
</script>
<script type="text/javasript"> $(document).ready(function(){ $('.timezone').change(function(){ setZoneVal(); }); }) setZoneVal(); </script> 
<style type="text/css">
.mbox{
	
	 margin-top:-25px;
	
	padding:1px;
}
.error,.slot_error, #consulations-error,#exampleFormControlSelect1-error {
	color:red;
	font-size:normal;
	font-weight:9px;
}
</style>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>

  <script type="text/javascript">
 
    $('.wizard li').click(function() {
    $(this).prevAll().removeClass('active').addClass('completed');
    $(this).removeClass('completed').addClass('active');
    $(this).nextAll().removeClass('completed active');
    });

    jQuery(document).ready(function ($) {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    
  </script>

@endsection