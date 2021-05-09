@extends('Frontend::layouts.frontend')
@section('content')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9ZxHaV_cEegOJfb8FnF_qcNUPIMDQ0A&libraries=places"></script>
    <div class="row cont_sec2 mrg-bot-10">
        <div class="col-lg-4 col-12">
            @include("Frontend::doctor_dashboard_sidemenu")
        </div>
        @if(isset($doctorInfo['opt_clinic']) && $doctorInfo['opt_clinic']=='yes')
        
        <div class="col-lg-8 col-12">
            <div class="cont_box2  custom-mt2-10">
                <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 cont_box">


                @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                                   @endif
                    <form method="post" action="clinicsave">
                    <h4 class="text-green font-custom-bold" style="display: inline-block;">Clinic Information</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> 
                                <label for="name">Clinic Name<span class="mand">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" name="name" value="{{ isset($clinicInfo['hospital_name'])?$clinicInfo['hospital_name']: old('name')}}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="email">Email<span class="mand">*</span></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{isset($clinicInfo['email'])?$clinicInfo['email']: old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                            </div>
                        </div>
                        <div class="col-sm-3">
                        <div class="form-group">
                        <label for="phone"> &nbsp; </label>
                        <?php 
                        $phone = isset($clinicInfo['phone'])?$clinicInfo['phone']:'';
                        $phone = explode("-",$phone);
                        $phone_code = isset($phone[0])?trim($phone[0],"+"):'';
                        $phone_no = isset($phone[1])?$phone[1]:'';
                        ?>
                        <select class="phonecode form-control" name="phonecode" data-value="{{ isset($phone_code)?$phone_code:old('phonecode')}}">
                             
                             </select>
                        
                        </div>

                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="phone">Phone<span class="mand">*</span></label>
                                
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone" name="phone" value="{{ isset($phone_no)?$phone_no:old('phone')}}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                     <?php /*  <div class="col-sm-4">
                            <div class="form-group"> 
                                <label for="fax">Fax</label>
                                <input type="text" class="form-control @error('fax') is-invalid @enderror"  id="fax" placeholder="Fax" name="fax" value="{{ isset($clinicInfo['fax'])?$clinicInfo['fax']:old('fax')}}">
                                @error('fax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       */ ?>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="addr1">Address 1<span class="mand">*</span></label>
                                <input type="text" class="form-control @error('addr1') is-invalid @enderror" id="addr1" placeholder="Address 1" name="addr1" value="{{ isset($clinicInfo['address_line1'])?$clinicInfo['address_line1']:old('addr1')}}">
                                @error('addr1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="addr2">Address 2<span class="mand">*</span></label>
                                <input type="text" class="form-control @error('addr2') is-invalid @enderror" id="addr2" placeholder="Address 2" name="addr2" value="{{ isset($clinicInfo['address_line2'])?$clinicInfo['address_line2']:old('addr2')}}">
                                @error('addr2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="addr3">Address 3</label>
                                <input type="text" class="form-control @error('addr3') is-invalid @enderror" id="addr3" placeholder="Address 3" name="addr3" value="{{ isset($clinicInfo['address_line3'])?$clinicInfo['address_line3']:old('addr3')}}">
                                @error('addr3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label for="country">Country<span class="mand">*</span></label>
                                <!--<input type="text" class="form-control @error('country') is-invalid @enderror" id="country" aria-describedby="country" placeholder="Country" name="country" value="{{ old('country')}}">  -->
                           <select class="countries form-control @error('country') is-invalid @enderror " id="country" aria-describedby="country" placeholder="Country" name="country" value="{{ old('country')}}" data-value="{{ isset($clinicInfo['address_country'])?$clinicInfo['address_country']:old('country')}}">
                           
                           <option value="" >Select </option>
                           
                           </select>
                           
                                @error('country')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                                                   
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label for="state">State<span class="mand">*</span></label>
                                <!--<input type="text" class="form-control @error('country') is-invalid @enderror" id="country" aria-describedby="country" placeholder="Country" name="country" value="{{ old('country')}}">  -->
                           <select class="states form-control @error('state') is-invalid @enderror " id="state" aria-describedby="state" placeholder="state" name="state" value="{{ old('state')}}" data-value="{{ isset($clinicInfo['address_state'])?$clinicInfo['address_state']:old('state')}}">
                           
                           <option value="" >Select </option>
                           
                           </select>
                           
                                @error('state')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                            </div>
                          </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label for="city">Town/City<span class="mand">*</span></label>
                              <select class="cities form-control @error('city') is-invalid @enderror " id="city" aria-describedby="city" placeholder="state" name="city" value="{{ old('city')}}" data-value="{{ isset($clinicInfo['address_city'])?$clinicInfo['address_city']:old('state')}}">
                           
                           <option value="" >Select </option>
                           
                           </select>
                              @error('city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                          </div>                   
                            </div>
                        </div>
                    <div class="row">
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="postcode">Post Code<span class="mand">*</span></label>
                                <input type="text" class="form-control @error('postcode') is-invalid @enderror" id="postcode" placeholder="Post Code" name="postcode" value="{{ isset($clinicInfo['address_postcode'])?$clinicInfo['address_postcode']:old('postcode')}}">
                                @error('postcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label for="searchInMap"> Location <span class="mand">*</span></label>
                                  
                            <input type="text" id="searchInMap" class="form-control @error('postcode') is-invalid @enderror" style="width: 250px" placeholder="Enter a location" name="searchInMap" value="{{ isset($clinicInfo['address_place'])?$clinicInfo['address_place']:old('searchInMap')}}"/>

                            @error('searchInMap')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            <input type="hidden" id="latitude" name="latitude" />
                         <input type="hidden" id="longitude" name="longitude" /> 
                         <input type="hidden" id="placeName" name="placeName" />      
                             </div>
                        </div>
                      
                    </div>
                    <div class="row">                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="summary">Summary</label>
                                <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" placeholder="Summary" name="summary">{{isset($clinicInfo['summary'])?$clinicInfo['summary']:old('summary')}}</textarea>
                                @error('summary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" name="submit" value="Save">
                            </div>
                        </div>
                    </div>
        </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('searchInMap'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
               // var address = place.formatted_address;
            /*    var latitude = place.geometry.location.A;
                var longitude = place.geometry.location.F;*/
     //      document.getElementById('PlaceName').value = address;
        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
                
            });
        });
    </script>
    
        @endif    
</div>
@endsection