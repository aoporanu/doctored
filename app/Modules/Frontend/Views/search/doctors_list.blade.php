@extends('Frontend::layouts.frontend')
@section('content')

<!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mt-2">
              <ol>
                <li><a href="/">Home</a></li>
                <li>Doctors</li>
              </ol>
              </div>

            <div class="col-lg-9 col-md-9 col-12">
                <div class="row d-flex justify-content-end">
                  <div class="col-lg-3 col-md-3 col-12 form-group mb-0">
                  <select name="department" id="department" class="form-control">
                    <option value="">City</option>
                    <option value="">Hyderabad</option>
                    <option value="">Pune</option>
                    <option value="">Bengaluru</option>
                    <option value="">Mumbai</option>
                    <option value="">Delhi</option>
                  </select>
                  <div class="validate"></div>
                </div>
                <div class="col-lg-3 col-md-3 col-12 form-group mb-0">
                  <select name="doctor" id="doctor" class="form-control">
                    <option value="">Appointment Type</option>
                    <option value="Doctor 1">Video Call</option>
                    <option value="Doctor 2">Chat</option>
                    <option value="Doctor 3">In-Person</option>
                  </select>
                  <div class="validate"></div>
                </div>
                <div class="col-lg-3 col-md-3 col-12 form-group mb-0">
                  <select name="doctor" id="doctor" class="form-control">
                    <option value="">Select Language</option>
                    <option value="Doctor 1">English</option>
                    <option value="Doctor 2">Hindi</option>
                    <option value="Doctor 3">Telugu</option>
                  </select>
                  <div class="validate"></div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-12 form-group mb-0"><a href="#" class="appointment-btn scrollto ml-0"><i class="fa fa-search" aria-hidden="true"></i> Search</a></div>
              </div>
          </div>
          </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
<?php 
$lang = array();
$Languages = \App\Modules\Admin\Models\Languages::get()->toArray();
foreach($Languages as $Lank=>$lanv){
	$lang[$lanv['id']] = $lanv['value'];
}

$specializations = \App\Modules\Admin\Models\Specialization::get()->toArray();
$spec = array();
foreach($specializations as $sk=>$sv){
	$spec[$sv['id']] = $sv['specialization_name'];
}
$consulations = \App\Modules\Admin\Models\ConsultationTypes::get()->toArray();
$cons = array();
foreach($consulations as $cck=>$cv){
	$cons[$cv['ctype_id']]['name']=$cv['ctype_name'];
	$cons[$cv['ctype_id']]['icon']=$cv['ctype_icon'];
	
}
//echo "<pre>";print_r($cons); echo "</pre>"; exit;
?>
    <section class="inner-page">
      <div class="container">
        <section id="team" class="pb-1 pt-0">
          <div class="container pl-0 pr-0">
            <div class="row filters-box p-3">
              <div class="col-md-8 col-sm-8 col-12">
                <h3><?php echo count($results);?> Search Results for 
				
				 "{{$_GET['v'] ?? 'All Doctors' }}" in Doctors
				</h3>
              </div>
              <div class="col-md-4 col-sm-4 col-12">
                <div class="input-group custom-search">
                  <input type="text" class="form-control" placeholder="search for Doctor/Expert In">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
              <div class="row">
			  @foreach($results as $res_key=>$res_val)
           
                  <!-- Team member -->
                  <div class="col-lg-6 col-md-6 col-12">
                      <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                          <div class="mainflip">
                              <div class="frontside">
                                <div class="card p-3">
                                  <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-12">
                                      <div class="card-img-body">
	  <img class="card-img img-fluid radius-style" src="{{ $res_val['photo'] ? 'uploads/'.$res_val['photo']:'assets/img/doctor-pic.jpg' }}" alt="{{ucfirst($res_val['firstname'])}}">
									                                    
									</div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8 col-12">
                                        <h3 class="card-title mb-1">Dr .{{ucfirst($res_val['firstname']) ?? '' }} {{$res_val['lastname'] ?? '' }}</h3>
                                        <h6 class="sm-card-title">
										<?php 
										
										$specializationmappings = \App\Modules\Admin\Models\SpecializationMapping::select('specialization_id')->where('mapping_type','Doctor')->where('mapping_type_id',$res_val['id'])->get()->toArray();
										if(count($specializationmappings)>0){ echo "Expert In: ";
										$smaps = array();
										foreach($specializationmappings as $smkey=>$smval){
											$smaps[] = '<p class="badge" style="color:#000">'.ucfirst($spec[$smval['specialization_id']]).'</p>';
										}
										echo implode(',',$smaps);
										}
										?>
										<br/>
										
										 
										
										
										
										<!--| <i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 Kms</h6>-->
                                        <a href="#" class="colr-yelw"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i> <span>| 19 reviews</span></a>
									
									   <div class="col-12 pl-0 pr-0">
									   <?php 
									   $langs = \App\Modules\Admin\Models\LanguageMapping::where('module_mapping_type_id','=',$res_val['id'])->where('module_mapping_type','Doctor')->get()->toArray();
									   foreach($langs as $lk=>$lv){
											echo '<p class="badge badge-primary text-wrap">'.$lang[$lv['lang_mapping_id']].'</p>';
									   }
										?>
                                          
                                        </div>
                                      </div>
                                  </div>

                                  <div class="card-body pb-0">
								  @if(isset($res_val['summary']))
                                    <h4 class="card-title">About Me</h4>
                                    <p class="card-text">.{{ucfirst($res_val['summary']) ?? '' }}</p>
								@endif
                                    <div class="text-left"><a href="#" class="btn appointment-btn ml-0">Know More >></a></div>
                                  </div>
                                </div>
                              </div>
                              <div class="backside w-100">
                                <div class="card p-3">
                                  <div class="row">
                                    <div class="col-12">
                                      <div class="card-img-body mb-1">
                                      <!--<img class="card-img radius-style" src="assets/img/img-gmap.jpg" alt="gmap">-->
									  						<?php 	if($res_val['address_long']!='' && $res_val['address_lat']!='') {?>
				<iframe class="card-img radius-style" src="https://maps.google.com/maps?q={{$res_val['address_lat']}},{{$res_val['address_long']}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
   allowfullscreen>
  </iframe>  
  <?php }else {?>
  				<iframe class="card-img radius-style" src="https://maps.google.com/maps?q={{$res_val['address_place']}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
   allowfullscreen>
  </iframe>  
							<?php } ?>
				
                                      </div>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="card-title mb-1">Apollo Hospitals | Begumpet | Hyderabad</h4>
                                       <!-- <h5 class="txt-black">Appointment Availabilities</h5>-->
									  
                                        <div class="col-12 pl-0 pr-0">
										<?php 
										 $dcons = \App\Modules\Admin\Models\ConsultationMapping::where('mapping_type','Doctor')->where('mapping_type_id',$res_val['id'])->select('consultation_id')->get()->toArray();
									  foreach($dcons as $dckey=>$dcval){
										  echo '<p class="badge  text-wrap" style="color:#000"><img src="'.$cons[$dcval['consultation_id']]['icon'].'" style="height:15px"></i> '.$cons[$dcval['consultation_id']]['name'].'</p>';
                                      
										 
									  }
										?>
                                        </div>
                                      </div>
                                  </div>

                                  <div class="card-body pl-0 pr-0 pt-2 pb-0">
                                    <a href="#" class="btn btn-primary ml-0"><i class="fa fa-hospital-o" aria-hidden="true"></i> View Profile</a>
                                    <a href="#" class="btn btn-primary ml-0"><i class="fa fa-calendar" aria-hidden="true"></i> Book an Appointment</a>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- ./Team member -->
               @endforeach    
              </div>
              <!--<div class="row d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
            </div>-->
          </div>
      </section>
      </div>
    </section>


@endsection