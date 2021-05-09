@extends('Frontend::layouts.frontend')
@section('content')

     <section class="breadcrumbs">
      <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mt-2">
              <ol>
                <li><a href="/doctor-dashboard">Home</a></li>
                <li>Bookings</li>
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
				<div class="pb-3">
					<div class="row">
						<div class="col-lg-8 col-md-12 col-sm-12 col-12">
							
							<?php 
							if(isset($_REQUEST['msg'])){
								echo "<h3 style='color:red'>Booking Successful</h3>";
							}
							?>
					
						</div>

					
					</div>	
        		</div><!-- End / page-title -->
				</div>
				</section>
@endsection
