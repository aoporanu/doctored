@extends('Frontend::layouts.frontend')
@section('content')
<!-- =======  CODE SIMILAR TO DOCTOR PROFILE FOR MAIN BLOCKS ======= -->
<!-- ======= Breadcrumbs Section ======= -->

 <meta name="csrf-token" content="{{ csrf_token() }}">
<input type="hidden" name="patient_phone" class="patient_phone" value="{{$info['phone']}}" />
<section class="breadcrumbs">
<pre>
<?php 
//print_r($info);exit;
if(isset($requestParams['fullpath'])){
$fullpath = $requestParams['fullpath'];
$clean_fullpath = str_replace('HYPHEN','-',str_replace('SPACE',' ',str_replace('COLON',':',str_replace('COMMA',',',$fullpath))));
$cleandata = explode('_',$clean_fullpath);
$hid = $cleandata[5]; 
}else{
	//dummy for direct calling
	$hid ='';$cleandata[1]='';$cleandata[2]='';$cleandata[4]='';$cleandata[4]='';$cleandata[5]='';
	$requestParams['selectedtype'] ='';
}
//print_r($cleandata);
?>

</pre>

   <div class="container">
   <input type="hidden" name="hid" id="hid" value="{{$hid}}" />
<input type="hidden" name="app_date" id="app_date" value="{{$cleandata[4]}}" />
<input type="hidden" name="app_time" id="app_time" value="{{$cleandata[2]}}" />
<input type="hidden" name="app_type" id="app_type" value="{{$cleandata[1]}}" />
<input type="hidden" name="selectedtype" id="selectedtype" value="{{$requestParams['selectedtype']}}" />

      <?php
         
           $doctordata = (array)$doctordata[0];
           
           ?>
      <div class="row">
         <div class="col-lg-9 col-md-9 col-12 mt-2">
            <ol>
               <li><a href="/doctor-dashboard">Home</a></li>
               <li>Doctor</li>
               <li>Dr. {{ucfirst($doctordata['dname']) ?? ''}}</li>
			     <input type="hidden" name="docid" id="docid" value="{{$doctordata['id']}}" />
            </ol>
         </div>
      </div>
   </div>
</section>
<!-- End Breadcrumbs Section -->
<section class="inner-page">
   <div class="container">
      <div class="row">
         <div class="col-12 mx-auto">
            <!-- Profile widget -->
            <div class="bg-white shadow rounded overflow-hidden">
               <div class="p-3 cover pos-rel">
                  <div class="row">
                     <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <div class="media align-items-end profile-head">
                           <div class="profile mr-3"><img src="{{$groupdata['photo'] ?? '/assets/img/doc.png'}}" alt="..."  style="border-radius:35px" width="120" class="rounded mb-2 img-thumbnail"></div>
                           <div class="media-body mb-4 text-white">
                              <h4 class="mt-0 mb-0 txt-white">Dr. {{ucfirst($doctordata['dname']) ?? ''}}</h4>
                              <?php 
                                 $specs = array();
                                 foreach($specialization as $skey=>$sval){
                                 $specs[] = ucfirst($sval->specialization_shortcode);
                                 }
                                 if(count($specs)>0){
                                 echo '<p class="small mb-2">Expert In: <!-- |Exp: 30 years -->'.implode(',',$specs).'</p>';
                                 
                                 }
                                 
                                 ?>
                              <p class="small mb-2">
                                 {{ucfirst($doctordata['address_line1']) ?? ''}} {{ucfirst($doctordata['address_line2']) ?? ''}}<br/>  {{ucfirst($doctordata['cityname']) ?? ''}}, {{ucfirst($doctordata['statename']) ?? ''}} {{ucfirst($doctordata['address_postcode']) ?? ''}}  <!--<i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 kms</p>-->
                                 <a href="#" class="colr-yelw"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 col-12 d-flex justify-content-end text-center">
                        <div class="row mb-3">
                           <div class="col-12 pl-0 pr-0 mt-3">
                              <?php 
                                 //print_r($consultations);
                                 foreach($consultations as $ckey=>$cval){
                                 echo '<p class="badge badge-primary text-wrap"><img height="15" src="/'.$cval->ctype_icon.'"> '.ucfirst($cval->ctype_name).' </p>';  
                                 
                                 }
                                 
                                 ?> 
                           </div>
                           <div class="col-12 pl-0 pr-0">
                              <?php 
                                 if(isset($languages[0])){
                                 foreach($languages[0] as $lkey=>$lval){
                                  echo  '<p class="badge badge-primary text-wrap">'.ucfirst($lval).'</p>&nbsp;';
                                 }
                                 }
                                 
                                 ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
      <form  class="p-4"  id="booking-form" name="booking-form" method="post" action="javascript:void(0)">
                     @csrf
     <input type="hidden" name="doctor_id" id="doctor_id" value="{{$doctordata['id']}}" />
      <input type="hidden" name="patient_id" id="patient_id" value="{{$info['id']}}" />
            			    
				<div class="col-12 mt-1">
                                          <?php
                                             $structure = array();
                                             if(count($slots)==0){
                                             	echo "<h5>No Slots available</h5>";
                                             }
											 $hospitals = array(); $booking_dates = array(); $hospitals_ids=array();
                                             foreach($slots as $skey=>$sval){
                                             	
                                             //if(($sval->booking_date>=date('d-m-Y')) && ($sval->booking_start_time > date('H:i'))){
                                             if(($sval->booking_date==date('d-m-Y'))&& ($sval->booking_start_time <= date('H:i'))){
                                             	//should not be add
                                             }else{
                                             
                                             $structure[$sval->hospital_id]['hospital']= $sval->hospital_name;
											 $hospitals[] =  $sval->hospital_name;
											 $hospitals_ids[$sval->hospital_id] =  $sval->hospital_name;
											 $booking_dates[] =$sval->booking_date;
                                             $structure[$sval->hospital_id]['values'][$sval->screen_id][$sval->booking_date][$sval->shift][] = 	array(
                                             'time'=>$sval->booking_time_long,
                                             'type'=>$sval->available_types,
                                             'slotid'=>$sval->slotid,
                                             'time_start'=>$sval->booking_start_time
                                             );
                                             }
                                             
                                             }
                                             //print_r($structure);
											  $booking_dates = array_unique($booking_dates);
                                             ?>
                                       </div>
                  <div class="form-row">
				  <div class="col-12">
                                 <h4 class="txt-green">Book a Appointment</h4>
                              </div>
                     <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="row">
                             <!-- INCASE NO NEED TO SHOW HOSPITAAL  HIDE BELO DIV GROUP -->
							  <div class="form-group col-lg-6 col-md-6 col-12">
                                 <label for="inputState">Hospital</label>
                                 <select id="inputStatehospital" name="inputStatehospital" class="form-control">
                                    <option selected>Choose...</option>
									<?php $sel1= '';
									//print_r($hospitals_ids);
									?>
									
										@foreach( $hospitals_ids as $hk=>$hv)
										<?php if(isset($hid)&&$hid!=''){
										// echo trim($cleandata[5]);
												if($hk==$hid){
													$sel1 = " selected ";
												}else{
													$sel1 = '';
												}
											}										
											?>
										   <option  {{$sel1}} value="{{$hk}}">{{ucfirst($hv)}}</option>
										@endforeach
                                 </select>
                              </div>
							 
							 
                              <div class="form-group col-lg-6 col-md-6 col-12">
                                 <label for="inputStateDates">Appointment Date</label>
                                 <select id="inputStateDates" name="inputStateDates" class="form-control">
                                    <option selected>Choose...</option>
								 
                                 </select>
                              </div>
							   <div class="form-group col-lg-6 col-md-6 col-12">
                                 <label for="inputStateAppTime">Appointment Time</label>
                                 <select id="inputStateAppTime" name="inputStateAppTime"  class="form-control">
                                    <option selected>Choose...</option>
                                   
                                 </select>
                              </div>
							   <div class="form-group col-lg-6 col-md-6 col-12">
                                 <label for="inputStateCtype">Consultation Type</label>
                                 <select id="inputStateCtype" name="inputStateCtype" class="form-control">
                                    <option selected>Choose...</option>
                                    
                                 </select>
                              </div>
                             <input type="hidden" id="screen_id" name="screen_id" value="" />
							       <input type="hidden" id="slotid" name="slotid"   value="" />
                              <div class="form-group col-lg-6 col-md-6 col-12">
                                 <label for="inputPassword4">Appointment Title</label>
                                 <input type="text" class="form-control" id="atitle" class="atitle" name="atitle">
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-12">
                                 <label for="inputEmail4">Email</label>
                                 <input type="email" name="email" class="form-control" id="email" value="{{$info['email'] ?? ''}}">
                              </div>
                              <div class="form-group col-12">
							   <label for="inputEmail4">Phone number</label>
							  <div class="row">
                                 <div class="col-md-3  form-group"> 
		 		<select class="phonecode pc form-control" name="phonecode"> </select>
				
												
		 </div>
		 <input type="hidden" name="country" class="country" value="" />
		 <input type="hidden" name="sysip" class="sysip" value="" />
		  <div class="col-md-6  form-group"> 
		  		<input type="text" name="phonenumber" id="phonenumber" class="form-control pc" placeholder="Phone number" > 
		  		<input type="hidden" name="phone" class="phone" class="form-control" placeholder="Phone number" value="{{$info['phone']}}" > 
		
		  </div>  </div>
                              </div>
                              <div class="form-group col-12">
                                 <label for="inputPassword4">Appointment Details</label>
                                 <textarea class="form-control description" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                              </div>
                              <div class="row ml-0 mr-0">
                                 <div class="form-check col-12 ml-4">
                                    <input type="checkbox" class="form-check-input" name="doctor_concent" id="doctor_concent">
                                    <label class="form-check-label" for="doctor_concent">Give consent to
                                    doctor for Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                    </label>
                                 </div>
                                 <div class="form-check col-12 ml-4 mb-4">
                                    <input type="checkbox" class="form-check-input" name="patien_concent" id="patien_concent">
                                    <label class="form-check-label" for="patien_concent">Give consent amet
                                    consectetur adipisicing elit.
                                    </label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
						   <div class="spinner-border text-warning" role="status">
  <span class="sr-only">Loading...</span>
</div>
                              <div class="col-12 mb-0 mt-3 ">    
<button class="btn btn-primary ml-0" id="send_form" type="submit">Book an Appointment</button>
	                            </div>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           <div class="row d-flex justify-content-between sldr-slot circle-1">
                              
                              <div class="col-12">
                                 <div id="demo" class="carousel slide position-relative" data-ride="carousel">
                                    <div class="row">
                                       <div class="col-2 offset-6">
                                         
                                          <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                          <i class="fa fa-chevron-left"></i>
                                          </a>
                                             <a class="carousel-control-next" href="#demo" data-slide="next">
                                          <i class="fa fa-chevron-right"></i> 
                                          </a>
                                       </div>
                                    </div>
                                    <!-- The slideshow -->
                                    <div class="carousel-inner" id="customdategrid">
                                    
                          
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="/assets/bookappointment.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
	   $('.spinner-border').hide();
	   loadHospitalData();
	
   });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  

<script type="text/javascript">

      jQuery.validator.addMethod("lettersandnumbersonly", function(value, element) 
{
return this.optional(element) || /^([a-zA-Z ]{3,16})+$/i.test(value);
}, "Only letters,numbers and  spaces are allowed");
jQuery.validator.addMethod("lettersonly", function(value, element) 
{
return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
}, "Only letters and spaces are allowed");
jQuery.validator.addMethod("numbersonly", function(value, element) 
{
return this.optional(element) || /^([0-9])+$/i.test(value);
}, "Only letters and spaces are allowed");
 
     if ($("#booking-form").length > 0) {
    $("#booking-form").validate({
      
    rules: {
         inputStateDates: {
		 required: true,
		 
      },
	  inputStateAppTime: {
		 required: true,
      },
	  inputStateCtype: {
		 required: true,
      },
      description: {
        required: true,
		lettersandnumbersonly:true,
        maxlength: 250
      },
	  atitle:{
		  required: true,
		  lettersonly:true
	  },
	  email: {
        required: true,
        email: true
      },
	  phonenumber:{
		  required: true,
		  numbersonly:true,
		  minlength:10,
		  maxlength:12
	  },
	  doctor_concent:{
		  required:true
	  },
	  patien_concent:{
		  required:true
	  }
    },
	 messages: {
      inputStatehospital: {
        required: "Please select Hospital",
      },
	  inputStateDates: {
        required: "Please select Dates",
      },
	  inputStateAppTime: {
        required: "Please select Time",
      },
	  inputStateCtype: {
        required: "Please select Consultation time",
      },
      description: {
        required: "Please Enter description",
		lettersandnumbersonly:"only numbers and letters",
        maxlength: "Your last description maxlength should be 250 characters long."
      },
	   atitle: {
        required: "Please enter title",
		lettersonly:"Only Letters allowed "
      },
	   email: {
        required: "Please Enter Email",
        email: "Your email format is invalid"
      },
	   phonenumber: {
        required: "Please Enter Phone numner",
        numbersonly: "Phone number format is invalid",
		minlength:"Phone number should be 10 numbers",
		  maxlength:"Phone number should be less than 12"
      },
    },
    submitHandler: function(form) {
     $.ajaxSetup({
          headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }
      });
   //   $('#send_form').html('Sending..');
      $.ajax({
        url: '/initiateBooking' ,
        type: "POST",
		beforeSend: function() {
              $("#send_form").hide();
			  $('.spinner-border').show();
           },
        data: $('#booking-form').serialize(),
        success: function( response ) { 
		
		 if(response=='success'){
			 window.location = "/managebookings?msg=successfull";
		 //$("#send_form").show();$('.spinner-border').hide();
			 	 

		 }else{
			  $("#send_form").show();$('.spinner-border').hide();
		 }
        }
      });
    }
  })
} 
	 
	
   

</script>
<script type="text/javascript">
$(document).ready(function() {
	$('.phone').val("+" + $('.phonecode').val() + "-" + $('#phonenumber').val());
	$(".pc").on("change keyup paste blur", function() {
		var phonenumbess = "+" + $('.phonecode').val() + "-" + $('#phonenumber').val();
		$('.phone').val(phonenumbess);
		//$('.phonetext').html(phonenumbess);
	});
});

</script>

<style type="text/css">
  .error{ color:red; font-size:12px;font-family:"Open Sans", sans-serif;
	   text-transform: capitalize;} 
</style>
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(
    function() {
     pphone  = $('.patient_phone').val();
pphone = pphone.split('-');
console.log(pphone.length);
if(pphone.length==2){
$('.phonecode option[value="'+pphone[0].replace('+','')+'"]').prop('selected', 'selected').change();
$('#phonenumber').val(pphone[1]);
     	$('.phone').val("+" + $('.phonecode').val() + "-" + $('#phonenumber').val());
 
  
}
$('.country').val($('.usercountry').val());
$('.sysip').val($('.userip').val());
    }, 5000);
	 
});

</script>
@endsection

   