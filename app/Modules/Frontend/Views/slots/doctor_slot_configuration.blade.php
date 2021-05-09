@extends('Frontend::layouts.auth')
@section('content')
<link href="smartWizard/css/smart_wizard_arrows.css" rel="stylesheet" type="text/css" />

    <div class="row cont_sec2 mrg-bot-10">
       <div class="col-lg-4 col-12">
            @include("Frontend::doctor_dashboard_sidemenu")
        </div>

        <div class="col-lg-8 col-12">
            <div class="cont_box2  custom-mt2-10">
                <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 cont_box">
                <!---- CODE --->
                <!-- SmartWizard html -->
                @if(count($hospitals_list)>0)
    <div id="smartwizard">
 
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link text-green" href="#hosptial">
        <strong>Hosptial <br/> Selection</strong> 
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-green" href="#dates">
        <strong>Dates <br /> Selection </strong> 
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-green" href="#times">
        <strong>Times <br/> Selection</strong>  
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-green" href="#review">
        <strong>
        Review & <br/> submit
        </strong> 
      </a>
    </li>
</ul>
<?php //echo date('Y-m-d h:i:s a')
 ?>
 
<div class="tab-content">
    <div id="hosptial" class="tab-pane" role="tabpanel" aria-labelledby="hosptial">

            <!-- hospital selection -->
   <form name="slot_management" id="slot_management" method="POST" >    
<input type="hidden" value="" name="screen_id" id="screen_id" >    
            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 doc_sec">
                                  
                                    <input type="hidden" value="<?php echo csrf_token() ?>" id="token" name="_token" >
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="appointmentTime">Hospital Name</label>
                                                <!-- <a href="#" id="username" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">superuser</a>-->

                                                     <select  class="form-control" id="exampleFormControlSelect1" name="hospital_name">
                                                     <option value="">Select</option>
                                                     @foreach ($hospitals_list as $hp)
                                                     <option value="{{$hp['hospital_id']}}">{{$hp['hospital_name']}} </option>
                                                    @endforeach
                                                       
                                                      </select>
                                                </div>
                                                <div class="slot_error"></div>
                                            </div>                                            
                                        </div>
                                   

                                </div>

                            </div>
            <!--- end --->
		
    </div>
    <div id="dates" class="tab-pane" role="tabpanel" aria-labelledby="dates">
        <!-- Dates -->        
        
                        <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 cont_box">
                        <div class="row" class="slot_details">
                Hospital Name <div class="slot_hospital"></div>  
               
                

            </div>
            <div class="slot_error"></div>
            <hr/>
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 doc_sec">

                             
                              
                                            <div class="form-group">
               
                <div class="col-md-12">
                <label> Consultation Type   </label>
                    <div class="select2-primary">
                      <!--  <select class="form-control" multiple="multiple" data-plugin="select2" data-placeholder="Select Specilization" name="specialization[]">
                            @foreach($consultation_types as $consultations)
                                <option value="{{$consultations->ctype_id}}" @if(in_array($consultations->ctype_id, $consultation_types_list)) selected @endif>{{$consultations->ctype_name}}</option>
                            @endforeach    
                        </select> -->
                        <select class="js-example-basic-multiple" id="consulations" name="consultaions[]" multiple="multiple">
                        @foreach($consultation_types as $consultations)
                        <option value="{{$consultations->ctype_id}}" @if(in_array($consultations->ctype_id, $consultation_types_list)) selected @endif>{{$consultations->ctype_name}}</option>
                        @endforeach    
</select>
                   
            </div>
                                            </div>       
</div>
<hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="appointmentTime">Schedule For</label>
                                                    <select class="form-control slot_days" id="exampleFormControlSelect1">
                                                        <option value="week">Week</option>
                                                        <option value="month">Month</option>
                                                        <option value="custom">Custom</option>
                                                      </select>
                                                </div>
                                            </div>
              
                                        </div>
                                        <hr>
                                        <div class="row" id="cus_slot" >
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="slot_startdate">Start Date</label>
                                                    <input type="date" class="form-control" id="slot_startdate" value=""    min="<?php echo date("Y-m-d"); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"   name="slot_startdate">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="slot_enddate">End Date</label>
                                                    <input type="date" class="form-control" id="slot_enddate" 
                                                    name="slot_enddate" value=""   
                                                     min="<?php echo date("Y-m-d", strtotime('+1 day')); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"  >
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">  
                                            <strong>Selected Dates (MM-DD-YYYY) </strong>
                                            <span class="selected_dates">
                                                
                                            </span>
                                            </div>
                                            <div class="row">
                                            <input type="hidden" name="selected_date_values" id="selected_date_values" value="">
                                            <div id="selected_dates_list" style="font-size:12px;font-weight:bold;color:#ccc">

                                            </div>
                                            </div>
                                            <hr>
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
                                                <div class="form-group" id="custom_extention_date_block" >
                                                    <label for="custom_extention_date">&nbsp;</label>
                                                    <input type="date" class="form-control" style="display:none"
                                                     value="<?php echo date("Y-m-d"); ?>"    min="<?php echo date("Y-m-d"); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"  
                                                    id="custom_extention_date" name="custom_extention_date"  placeholder="please enter">
                                                </div>
                                            </div>
                                        </div>
										 <input type="hidden" name="ready_date_values"  value="" id="ready_date_values">
                                        <div class="row" style="font-size:12px;font-weight:bold; margin-right:8px">
                                        Dates after  excluding  </span>  &nbsp;&nbsp;(<span id="excluded_what"></span>)&nbsp;&nbsp;
                                        <br/> <div class="excluded_dates_list" style="font-size:12px;font-weight:bold;color:#ccc"></div>
										
                                           
                                        </div>
                                       
                                        
                                  

                                </div>

                            </div>

                        </div>
                
        <!--- end -->
</div>
    <div id="times" class="tab-pane" role="tabpanel" aria-labelledby="times">
    <!-- times -->

    <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 cont_box">
    <div class="row" class="slot_details">
       
        
                Hospital Name <div class="slot_hospital"></div>  
               
               
            </div>
            <div class="row" class="slot_details">
            selected Dates<div class="excluded_dates_list"></div>
            </div>
             
                                                     <center>    <span style="font-size:14px;font-weight:bold"> ** Minimum 1 Slot required</span> </center>
      
            <hr/>
	 
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 doc_sec">
 
                                   
                                        
                                   

                                                <div class="fullday-block">
		<input type="hidden" name="cons_duration" id="cons_duration" value="<?php echo($doctorInfo['duration']);?>" >
           <input type="hidden" name="timeval_status" id="timeval_status" value="fail" >
            <?php //******************************************************* */
 
         
foreach ($fetch_durations as $fetch_key => $fetch_val)
{ 
     

    unset($fetch_val['complete']);   unset($fetch_val['start']);unset($fetch_val['end']);
    ?>
   <?php $fetch_key = str_replace(" ","",$fetch_key); ?>
     <div class="row" class="shift-partial {{strtolower($fetch_key)}}_time">
          <div class="col-sm-3 pt-2">
              <label for="appointmentDate">{{$fetch_key}}</label>
          </div>
          <div class="col-sm-4">
              <div class="form-group">
               <select class="form-control" id="{{strtolower($fetch_key)}}_time_start" name="{{strtolower($fetch_key)}}_time_start" >
               <option value="">Select</option>
              @foreach($fetch_val['minutes_start'] as $fetch_sub_key=>$fetch_sub_val)
              <option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option>
              @endforeach
              </select>

              
               </div>
          </div>
          <div class="col-sm-1 text-center pl-0 pr-0 mt-2">To</div>
          <div class="col-sm-4">
              <div class="form-group">
              <select class="form-control"id="{{strtolower($fetch_key)}}_time_end" name="{{strtolower($fetch_key)}}_time_end"  >
              <option value="">Select</option>
              @foreach($fetch_val['minutes_end'] as $fetch_sub_key=>$fetch_sub_val)
              <option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option>
              @endforeach
              </select>
              </div>
          </div>
          </div>

      <div class="row" class="shift-partial {{strtolower($fetch_key)}}_break">
          <div class="col-sm-3 pt-2">
              <label for="appointmentDate">Break if any</label>
          </div>
          <div class="col-sm-4">
              <div class="form-group">
                  <select class="form-control" id="{{strtolower($fetch_key)}}_break_start" name="{{strtolower($fetch_key)}}_break_start">
                  <option value="">Select</option>
                  @foreach($fetch_val['minutes_start'] as $fetch_sub_key=>$fetch_sub_val)
              <option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option>
              @endforeach
                  </select>
              </div>
          </div>
          <div class="col-sm-1 text-center pl-0 pr-0 mt-2">To</div>
          <div class="col-sm-4">
              <div class="form-group">
                  <select class="form-control" id="{{strtolower($fetch_key)}}_break_end" name="{{strtolower($fetch_key)}}_break_end">
                  <option value="">Select</option>
              @foreach($fetch_val['minutes_end'] as $fetch_sub_key=>$fetch_sub_val)
              <option value="{{$fetch_sub_key}}">{{$fetch_sub_val}}</option>
              @endforeach
                  </select>
              </div>
          </div>
          </div>

        <span class="{{strtolower($fetch_key)}}_error_msg" style="font-size:14px;color:red"></span>

          <hr />

            <?php
} ?>
         
                                                    

                                                    </div>
                                                      
                                                       
  
          

    
                                        
                                 

                                </div>

                            </div>

                        </div>
    <!-- end  --->
	</form>
</div>
    <div id="review" class="tab-pane" role="tabpanel" aria-labelledby="review">
                <div id="review_content">
				
				</div>

</div>
</div>
</div>
@else 
<center><h3>  No associated Hospital found ...!</h3></center>
@endif
                <!---- END OF CODE --->
                </div>
            </div>
        </div>

</div>




<!-- Include SmartWizard JavaScript source -->


    <script type="text/javascript" src="https://unpkg.com/smartwizard@5.1.1/dist/js/jquery.smartWizard.min.js"></script>

    <script type="text/javascript">
	
        $(document).ready(function(){
           
            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               //alert("You are on step "+stepNumber+" now");
               if(stepPosition != 'final'){
                   $('.finishProcess').hide();
               }else{
                $('.finishProcess').show();
               }

               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');

               }else if(stepPosition === 'final'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
               }
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info finishProcess')
                                             .on('click', function(){ 
											  if(!confirm("Please verify details before submitting")) {
													return false;
												  }
												 // this.form.submit();
                                                generateSlots();
                                                
                                                });
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });


            // Smart Wizard
            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'default',
                    transitionEffect:'fade',
                    showStepURLhash: true,
                    toolbarSettings: {toolbarPosition: 'bottom',
                                      toolbarButtonPosition: 'end',
                                      toolbarExtraButtons: [btnFinish, btnCancel]
                                    }
                                    
                                
            });
            $('#current_step').val(0);
            
            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber,stepDirection) {
                 if(stepDirection=='forward'){
                //$('#current_step').val(stepNumber);
                var formElms = $(anchorObject.attr('href')).find("input, select");
                var hasError = false;
                //Custom method to validate data
                if(validateStepData(stepNumber)==true){    hasError = true;
                }else{   hasError = false;        }
               
                return !hasError;
                    }else{
                        $('.slot_error').html('');
                    }
            });

            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });

            // Set selected theme on page refresh
            $("#theme_selector").change();
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script  type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

    </script>
    <script type="text/javascript">
  $.fn.select2.amd.require([
    "select2/core",
    "select2/utils"
  ], function (Select2, Utils, oldMatcher) {
    var $basicSingle = $(".js-example-basic-single");
    var $basicMultiple = $(".js-example-basic-multiple");

    $.fn.select2.defaults.set("width", "100%");

    $basicSingle.select2();
    $basicMultiple.select2();

    function formatState (state) {
      if (!state.id) {
        return state.text;
      }
      var $state = $(
        '<span>' +
          '<img src="vendor/images/flags/' +
            state.element.value.toLowerCase() +
          '.png" class="img-flag" /> ' +
          state.text +
        '</span>'
      );
      return $state;
    };
  });

</script>
<script src="assets/jquery.validate.min.js"></script>
<script src="assets/jquery-ui.js"></script>

<!-- Note: not using validator currently -->
<script src="slots.js"></script>
<script src="editable/bootstrap-editable.js"></script>
<link href="editable/bootstrap-editable.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
    $('#username').editable();
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	var queryString = window.location.search;
  $('#screen_id').val(queryString.replace('?',''));
});
</script>
 
</p>
<style type="text/css">
.slot_hospital {
    margin-left:25px;
    font-weight:bold;
    font-size:12px;float:left;
}
.slot_final_dates{
    margin-left:25px;
    color:#ccc;
    font-weight:bold;
    font-size:12px;
}
   .excluded_dates_list{
    font-weight:bold;
    font-size:12px; 
    color:#ccc;
    margin-left:25px;
}
.slot_error{
   color:red;
   font-size:14px;
   
   
}
</style>
@endsection
