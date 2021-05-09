@extends('Frontend::layouts.frontend')
@section('content')
  <?php 
 $con_types  = App\Modules\Admin\Models\ConsultationTypes::select('ctype_id','ctype_name','ctype_icon')->get()->toArray();
          $ready_consultiaton = array();
		   foreach($con_types as $con_id=>$con_v){
			    $ready_consultiaton[$con_v['ctype_id']]['id']  = $con_v['ctype_id'];
			
			 $ready_consultiaton[$con_v['ctype_id']]['name']  = $con_v['ctype_name'];
			  
			   $ready_consultiaton[$con_v['ctype_id']]['icon']  = $con_v['ctype_icon'];
		
			   
		   }
		//print_r($ready_consultiaton);   
 	   
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" " />
<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
   <div class="container">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-12 mt-2">
            <ol>
               <li><a href="/">Home</a></li>
               <li><a href="/manage-slots">Manage Slots</a></li>
               <li>Slot Detail</li>
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
</section>
<!-- End Breadcrumbs Section -->
<section class="inner-page">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="card man-con">
               <div class="card-body pb-3 mb-3 p-0">
					<div class="row"> <div class="col-6"><h5>Selected Dates & Times</h5></div><div class="col-4"><h5>Update/Delete</h5></div><div class="col-2">  <a href="/manage-slots"><i class="fas fa-long-arrow-alt-left"></i> &nbsp;&nbsp;&nbsp;Back</a></div></div>
                  <div class="row mt-3 ml-0 mr-0">
				 
				  <div class="col-6" id="reviewselection" style="height:150px;overflow-y:scroll">
                  	</div>
				 <div class="col-6 pageoption">
				 <!-- Form-->
				 <form action="/updateSlotConfiguration" method="POST">
                          @csrf
						   <input type="hidden" name="selectedvalues" class="selectedvalues" value="">
						
							   <input type="hidden" name="screen_id" class="screen_id" value="<?php echo $_GET['s'];?>">
					
                                              <div class="form-group">
																          <input type="radio" class="savetype"  name="savetype" value="delete" id="de" checked="">
                                  
                                                    <label for="update">Delete</label>
                                    <input type="radio" class="savetype"  name="savetype" value="update" id="up">
                                  
                                                    <label for="Consultation">Update</label><span class="type_msg error"></span>
                                                <div class="form-group up_opt" style="display:none" >
											  <?php  
											  foreach($ready_consultiaton as $rc_key=>$rc_val){ ?>
											 <input type="checkbox" name="typeopt[]" class="typeopt" value="{{$rc_val['id']}}">
											 <label for="Consultation"> <img src="/<?php echo ucfirst($rc_val['icon']); ?>" style="height:20px">{{ucfirst($rc_val['name'])}}</label>
											  <?php } ?>											
                                               </div>
                                                <div class="form-group">
                                                <input type="submit" class="btn btn-danger" value="Save">
                                              </div>
											   </form>
											    @if(Session::has('error'))
											<div class="alert alert-error error">{{ Session::get('error') }}</div>
												@endif
											      @if(Session::has('success'))
											<div class="alert alert-success">{{ Session::get('success') }}</div>
												@endif
				 <!-- end of Form -->
				 </div>
				  </div>
               </div> 
            </div>
         </div>
      </div>
      <div class="row cont_sec2 mrg-bot-10 filterme">
         <div class="col-3 " style="font-size:12px">
		 <div class="row" ><br></div>
            <div class="row" >			 <h5>Dates</h5></div>
			  <div class="row filterme" >
			<?php 
		
			foreach ($uniquedates as $sc_key => $s_complete) {
			 
                           $date_org = $_GET['s'] . "_" . $s_complete;
                           echo "<span class='main_filter_date' id='" . $date_org . "' style='font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px;padding:2px' class='badge badge-default'><input type='checkbox' multiselect='false' name='fd_date_select' class='fd_date_select' >" . $s_complete . "</span>";
                  }
			
			?></div>
			 <div class="row" ><br></div>
		<div class="row" >               <h5>Shifts & Times </h5>            </div>
		 
		 
	 <?php 
	foreach($clean_unique_shifts as $cus_key=>$cus_val){
		$shift_org = $_GET['s'] . "_" . $cus_key;
		$shift_org_sub = $_GET['s'] . "_" . $cus_key;
		    echo "<div class='row filterme' ><div class='col-10 main_filter_shift badge badge-primary' style='text-align:left;font-size:10px;' class='badge badge-default'>
			<input type='checkbox' multiselect='false' name='fd_shift_select' class='fd_shift_select' id='" . $shift_org . "' >" . ucfirst($cus_key) . "( Select All)</div></div>";
         echo "<div class='row filterme'>";
			foreach($cus_val as $cusk=>$cusv){
		             $time_org = $shift_org."_" . encodeTime($cusv);
                       echo "<span class='main_filter_time' style='font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px;padding:2px' class='badge badge-default'><input type='checkbox' class='" . $time_org . " fd_time_select_main'  multiselect='false' name='fd_time_select_main'  >" . $cusv . "</span>";
             		
			}
		    echo "</div>";

	}
	
      ?>  
			 <div class="row" ><br></div>
            <div class="row" >
               <h5>Other details </h5>
            </div>
            <?php
               foreach ($slotconfiguration as $s_key => $s_val) {
                   // print_r($s_val);
               	if ($s_val['conf_key'] == 'hospital_name') {
                       $s_val['conf_key'] = 'Hospital';
                   }
                   if ($s_val['conf_key'] == 'timezone_value') {
                       $s_val['conf_key'] = 'Timezone';
                   }
                   if ($s_val['conf_key'] == 'timezone') {
                       $s_val['conf_key'] = 'Location';
                   }
                   if ($s_val['conf_key'] == 'userip') {
                       $s_val['conf_key'] = 'User Ip';
                   }
                     if ($s_val['conf_key'] == 'Slot_days') {
					    $s_val['conf_key'] = 'Slots created for';
				   }
                   if ($s_val['conf_key'] == 'cons_duration') {
                       $s_val['conf_key'] = 'Min Duration';
                   }
                   if ($s_val['conf_key'] == 'Consultaions') {
                       $s_val['conf_key'] = 'Types';
                   }
                   if ($s_val['conf_key'] == 'selected_date_values') {
                       //$s_val['conf_value'] = (array)$s_val['conf_value'];
                       $s_val['conf_key'] = 'Dates';
                       //$s_val['conf_value']= explode(',',(array)($s_val['conf_value']));
                   }
                   if ($s_val['conf_key'] == 'ready_slots') {
                       $s_val['conf_key'] = 'Times';
                   }
				 
                   
                   
                   
                   echo "<div class='row '>";
                   
                   echo "<strong>" . ucfirst($s_val['conf_key']) . "</strong></div>";
                   echo "<div class='row filterme'>";
                   if ($s_val['conf_key'] == 'Dates') {
					   /* Not using as fetching from slots table
                       $s_val['conf_value'] = explode(',', $s_val['conf_value']);
                       foreach ($s_val['conf_value'] as $sc_key => $s_complete) {
                           $org      = str_replace(']', '', str_replace('[', '', str_replace('"', '', $s_complete)));
                           $date_org = $_GET['s'] . "_" . str_replace('-', '_', $org);
                           echo "<span class='filter_date' id='" . $date_org . "' style='font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px;padding:2px' class='badge badge-default'><input type='checkbox' multiselect='false' name='fd_date_select' class='fd_date_select' >" . $org . "</span>";
                       }
                       */
                       
                       
                       //$s_val['conf_value']= explode(',',(array)($s_val['conf_value']));
                   } elseif ($s_val['conf_key'] == 'Times') {
					   /* Not using as fetching from slots table
                       $torg = json_decode($s_val['conf_value']);
                       echo "<div class='card'>";
                       foreach ($torg as $t_key => $t_val) {
                           echo "<div class='card-header'  style='padding:2px'>" . ucfirst($t_key) . "</div>";
                           echo "<div class='card-body'  style='padding:2px'>";
                           foreach ((array) $t_val[0] as $tk => $tv) {
                               $ntv = $_GET['s'] . '_' . base64_encode(str_replace(' ', '', $tv));
                               echo "<span class='filter_time' id='" . $ntv . "' style='font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px;padding:2px' class='badge badge-default'><input type='checkbox' multiselect='false' name='fd_time_select' class='fd_date_select' >" . $tk . "</span>";
                               
                           }
                           echo "</div>";
                       }
                       echo "</div>";
					   */
                   } 
               	else if($s_val['conf_key'] == 'consultaions' || $s_val['conf_key'] == 'Types' ){
               	 /* old code
               		 $contype = (array)str_replace('"','',str_replace(']','',str_replace('[','',$s_val['conf_value'])));
               	 
               	 
               	$cdata  = App\Modules\Admin\Models\ConsultationTypes::select('ctype_id','ctype_name','ctype_icon')->whereIn('ctype_id', $contype)->get()->toArray();
               		 foreach($cdata as $ck=>$cv){
               			 echo "<span class='badge badge-primary' >".$cv['ctype_name']."</span>";
               		 }
					  */
					  $cons =  json_decode($s_val['conf_value']);
					   foreach($cons as $ckk=>$cvv){
						   //$ready_consultiaton
						 
						   echo "<span class='badge badge-primary' style='float:left;margin:2px' >".$ready_consultiaton[$cvv]['name']." <img height='16px' src=".$ready_consultiaton[$cvv]['icon']." ></span> ";
					   }
               	}		 
               	else if($s_val['conf_key'] == 'Hospital'){
               		$hid =$s_val['conf_value'];
               		//$data = DB::->where('hospital_id','=',$hid);
               		$data  = App\Modules\Admin\Models\Hospitals::select('hospital_name')->where(['hospital_id' => $hid])->get()->toArray();
               		echo ucfirst($data[0]['hospital_name']);
               	}
               	
               	else {
                       echo $s_val['conf_value'];
                       
                   }
                   
                   
                   echo "</div>";
                   
               }
               ?>
         </div>
         <div class="col-9 main-block">
            <div class="row" >
               <br>
            </div>
            <div class="row" >
               <div class="col-9">
                  <center>
                     <h5>Available Slots </h5>
					 <span style="color:#bbb;font-size:12px;font-weight:normal"><i>Please make selection Dates or shifts & Times and Available Slots (i.e Left Block Then Right Block)</i></span>
                  </center>
				
               </div>
			   <div class="col-3">
			  <a href="/manage-slots"><i class="fas fa-long-arrow-alt-left"></i> &nbsp;&nbsp;&nbsp;Back</a> </div>
            </div>
            <div class="row">
             
                  <?php //print_r($slots);
                     $structure = array();
                     foreach($slots as $str_key=>$str_val){
                     	$structure[$str_val['screen_id']][$str_val['booking_date']][$str_val['shift']][$str_val['booking_start_time']] = $str_val;
                     } ?>
                     @foreach($structure as  $sid=>$stval)
                     	@foreach($stval as $hkey=>$hval)
						<?php $sub_date_key = "sub_date_".$sid."_".$hkey;
						?>
						<?php //$sub_date_key = "sub_".$sid."_".base64_encode($hkey); ?>
						 <div class="card" class="sub_filter_date" id="{{$sub_date_key}}" style="margin:0px;border:1px solid #214214;width:50%">
						 <div class="card-header" style="background:#edf9e9;font-size:12px;font-weight:bold;border:1px;background:#214214;color:#fff">{{ $hkey}} ( {{ucfirst(date('l ', strtotime($hkey)))}} )</div>
						 <div class="card-body">
						 @foreach($hval as $shiftkey=>$shiftval)
						 <div class="row">
                           
						    <div class="col-sm-12  badge badge-secondary">
                              {{ ucfirst($shiftkey)}}
                           </div>
                           
                        </div>
						<div class="row">
                           <div class="col-sm-12">
                              @foreach($shiftval as $timekey=>$timeval)
                              <?php  
							  
							  $tval_rec = $timeval['booking_time_long'];
						$tval_types = $timeval['available_types'];
								$newtypes = explode(',',$tval_types);
								$ntimeid ='sub_time_'.$_GET['s']."_".encodeTime($tval_rec);
							  ?>
                              <span class='sub_filter_time {{$ntimeid}}' style='font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px;padding:2px' class='badge badge-default'><input type='checkbox' multiselect='false' name='fd_time_select' class='fd_time_select' >
							  {{$tval_rec}}<br>&nbsp;&nbsp;&nbsp;&nbsp;
							  <?php 
								foreach($newtypes as $nt_key=>$nt_val){  
										   echo "<img height='16px' src='".$ready_consultiaton[$nt_val]['icon']."' alt='".$ready_consultiaton[$nt_val]['name']."'>";
					
						 }
								
							  ?>
							  
							  </span>
                              @endforeach
                           </div>
                        </div>
						 @endforeach
						 </div>
						  
						</div>
						@endforeach
					@endforeach
            
            </div>
			<!--- -->
         </div>
      </div>
   </div>
</section>
<script type="text/javascript" src="slotDetails.js"></script>
<style type="text/css">
   .mn-head h6{
   font-weight:bold;
   }
   .hcard{
	 font-size:10px   
	float:left;   
	width:32%;
   }
   .hcard .card-header{
	   height:25px;
	   padding:1px;
   }
   .hcard .card-body{
	 	   padding:0px;
   }
   .htime{
	   font-size:10px
   }
   .error{color:red}
</style>
@endsection
<?php 
function encodeTime($str){
	$str =  str_replace(':','COLON',str_replace(' ','SPACE',str_replace('-','HYPHEN',$str)));
	return $str;
}
?>