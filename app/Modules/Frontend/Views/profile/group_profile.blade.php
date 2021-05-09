@extends('Frontend::layouts.frontend')
@section('content')
<!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

          <div class="row">
            <div class="col-lg-9 col-md-9 col-12 mt-2">
              <ol>
                <li><a href="index.html">Home</a></li>
                <li>Group</li>
				 <li>{{ucfirst($groupdata['group_name']) ?? ''}}</li>
              </ol>
              </div>

           
          </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
 
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
                              <div class="profile mr-3"><img src="{{$groupdata['glogo'] ?? '/assets/img/img-group.png'}}" alt="{{ucfirst($groupdata['group_name']) ?? ''}}" height="130" width="130" class="rounded mb-2 img-thumbnail"></div>
                              <div class="media-body mb-4 text-white">
                                  <h4 class="mt-0 mb-0 txt-white">{{ucfirst($groupdata['group_name']) ?? ''}}</h4>
                                  <p class="small mb-2"> {{ucfirst($groupdata['gaddress']) ?? ''}}</p>
                                  <p class="small mb-2"><i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 kms</p>
                                  <a href="#" class="colr-yelw"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
                                </div>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 d-flex justify-content-end text-center">
                      
                      </div>
                    </div>
                  </div>
                 
                  <div class="py-4 px-4">
                      <div class="row ml-0 mr-0 doctor-navtab">
                        <div class="card">
                          <div class="card-header">
                            
                            <!-- START TABS DIV -->
                            <div class="tabbable-responsive">
                              <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
								
								<!---- ************************Hospital tab ************* -->
							
								<?php if(isset($groupdata['hospitals'][0])&&$groupdata['hospitals'][0]['hospital_id']!='' ){ ?>
                                  <li class="nav-item">
                                    <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Hospitals</a>
                                  </li>
                                <?php }?>
								<!---- ************************End Hospital tab *************-->
							  <li class="nav-item">
                                    <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Description</a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="card-body">
                            
                            <div class="tab-content" >
							
							<!---- ************************Hospitaldata *************-->
								<?php if(isset($groupdata['hospitals'][0])&&$groupdata['hospitals'][0]['hospital_id']!='' ){ ?>
                             
                              <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                                <div class="card-text" >
								<div class="row">
									<?php 
								//	print_r($groupdata['hospitals']);
									?>
									@foreach($groupdata['hospitals'] as $res_key=>$res_val)
           
									    <div class="col-xs-6 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                     <div class="card-body text-center">
									  
                                          <p>
										  
										  <img class=" img-fluid" src="{{ $res_val['logo'] ? 'uploads/'.$res_val['logo']:'/assets/img/img-hospital.png' }}" alt="{{ucfirst($res_val['hospital_name']) ?? '' }}">
										  
										  </p>
                                          <h4 class="card-title mb-1">{{ucfirst($res_val['hospital_name']) ?? '' }}</h4>
                                          <h6 class="sm-card-title">{{ucfirst($res_val['hospital_business_name']) ?? '' }}<!--| <i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 Kms--></h6>
                                          <!-- <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 Kms</p> -->
                                          <p class="card-text">{{ucfirst($res_val['summary']) ?? '' }}</p>
                                         <!-- <a href="#" class="colr-yelw"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i> <span>| 19 reviews</span></a>-->
                                      </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center">
                                          <h4 class="card-title">Location</h4>
                                        <p class="gmap">
										<?php 	if($res_val['address_long']!='' && $res_val['address_lat']!='') {?>
				<iframe src="https://maps.google.com/maps?q={{$res_val['address_lat']}},{{$res_val['address_long']}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
   allowfullscreen>
  </iframe>  
  <?php }else {?>
  				<iframe src="https://maps.google.com/maps?q={{$res_val['address_place']}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
   allowfullscreen>
  </iframe>  
							<?php } ?>
										</p>
                                          <p class="card-text">
										  <?php 
										  $complete_address = array($res_val['address_line1'],$res_val['address_line2'],$res_val['address_city']
										  ,$res_val['address_state'],$res_val['address_country'],$res_val['address_postcode']
										  );
										  echo implode(',',$complete_address);
										  ?>
										   </p>
                                          <div class="col-12 mt-5">
                                            <!--<a href="/hospital/{{$res_val['hospitalcode']}}" class="btn btn-primary ml-0"><i class="fa fa-hospital-o" aria-hidden="true"></i> View Profile</a>-->
                                            <a href="/hospital/{{$res_val['hospitalcode']}}" class="btn btn-primary ml-0"><i class="fa fa-user-md" aria-hidden="true"></i> View Doctors</a> 
                                          </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				@endforeach
									
	</div>
								</div>
                              </div>
								<?php } ?>
								<!---- ************************Hospitaldata *************-->
							 <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                <p class="card-text">{{ucfirst($groupdata['group_description']) ?? ''}}</p>
                              </div>
                             

                             

                            </div>
                            <!-- END TABS DIV -->
                            
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      </div>
    </section>
<style type="text/css">
.frontside  .card
{
	width:312px; 
}
 
</style>



@endsection