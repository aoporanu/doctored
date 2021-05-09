@extends('Frontend::layouts.frontend')
@section('content')
 <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mt-2">
              <ol>
                <li><a href="index.html">Home</a></li>
                <li>Groups</li>
              </ol>
              </div>

            <div class="col-lg-9 col-md-9 col-12">
                <div class="row d-flex justify-content-end">
                  <div class="col-lg-3 col-md-3 col-12 form-group mb-0">
                  <select name="department" id="department" class="form-control">
                    <option value="">Choose Distance</option>
                    <option value="">Within 50 kms</option>
                    <option value="">Within 75 kms</option>
                    <option value="">Within 100 kms</option>
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
	
    <section class="inner-page">
      <div class="container">
        <section id="team" class="pb-1 pt-0">
          <div class="container pl-0 pr-0">
            <div class="row filters-box p-3">
              <div class="col-md-8 col-sm-8 col-12">
                <h3><?php echo count($results);?> Search Results for 
				
				 "{{$_GET['v'] ?? 'All Groups' }}" in Groups
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
			<pre>			<?php 				//print_r($results);			?>			</pre>
			 <div class="row">
			@foreach($results as $res_key=>$res_val)
             
                  <!-- Team member -->
                  <div class="col-xs-12 col-sm-6 col-md-4">
                      <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                          <div class="mainflip">
                              <div class="frontside">
                                  <div class="card">
                                      <div class="card-body text-center">
									  
                                          <p>
										  
										  <img class=" img-fluid" src="{{ $res_val['logo'] ? 'uploads/'.$res_val['logo']:'assets/img/img-hospital.png' }}" alt="card image">
										  
										  </p>
                                          <h4 class="card-title mb-1">{{ucfirst($res_val['group_name']) ?? '' }}</h4>
                                          <h6 class="sm-card-title">{{ucfirst($res_val['group_business_name']) ?? '' }}<!--| <i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 Kms--></h6>
                                          <!-- <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 Kms</p> -->
                                          <p class="card-text">{{ucfirst($res_val['group_description']) ?? '' }}</p>
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
  				<iframe src="https://maps.google.com/maps?q={{$res_val['address']}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
   allowfullscreen>
  </iframe>  
							<?php } ?>
										</p>
                                          <p class="card-text">{{ucfirst($res_val['address']) ?? '' }}</p>
                                          <div class="col-12 mt-5">
                                            <a href="#" class="btn btn-primary ml-0"><i class="fa fa-hospital-o" aria-hidden="true"></i> View Profile</a>
                                            <a href="#" class="btn btn-primary ml-0"><i class="fa fa-user-md" aria-hidden="true"></i> View Doctors</a> 
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- ./Team member -->
               
				 @endforeach  </div>
          <!--    <div class="row d-flex justify-content-center">
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