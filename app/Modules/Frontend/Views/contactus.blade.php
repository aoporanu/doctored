@extends('Frontend::layouts.frontend')
@section('content')
 <!--Contact Us Section-->
 <section class="fullcont_sec">
                <div class="container p-1 p-sm-3 bg_grey">
                    <div class="row">
                        <div class="col-12 col-lg-8 col-md-6">
                            <div class="card">
                                <div class="card-header  text-white bg-green"><i class="fa fa-envelope"></i> Contact us.
                                </div>
                                <div class="card-body bg-grey">
                                @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                                   @endif

                                    <form method="post" action="contact-us">
                                  

                                         <div class="form-group"> 
                                            <label for="firstname">First Name<span class="mand">*</span></label>
                                        
                                            <input type="text" class="form-control @error('firstname') is-invalid @enderror"  id="firstname" placeholder="First Name" name="firstname" value="{{ old('firstname')}}">
                                                @error('firstname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group"> 
                                            <label for="lastname">Last Name</label>
                                        
                                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"  id="lastname" placeholder="Last Name" name="lastname" value="{{ old('lastname')}}">
                                                @error('lastname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone Number<span class="mand">*</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone Number" name="phone" value="{{ old('phone')}}">
                                            
                                                      @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address<span class="mand">*</span></label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email')}}">
                                            
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                        </div>
                                     
                                        <div class="form-group">
                                            <label for="description">Message<span class="mand">*</span></label>
                                            <textarea  class="form-control @error('description') is-invalid @enderror"  id="description" rows="6" name="description"></textarea>
                                            @error('description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                        </div>
                                        <div class="mx-auto">
                                        <button type="submit" class="btn btn-signup text-right">Submit</button>
                                        
                                        
                                        </div>
                                        {{csrf_field()}}
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <div class="card mb-3">
                                <div class="card-header text-white   bg-green"><i class="fa fa-home"></i> Address</div>
                                <div class="card-body bg-grey">
                                    <p class="p-3"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span>10-12-122/A </p>
                                    <p class="p-3">33003 New York</p>
                                    <p class="p-3">United States of America</p>
                                    <p class="p-3"><span><i class="fa fa-envelope" aria-hidden="true"></i></span> doctered@example.com</p>
                                    <p class="p-3"><span><i class="fa fa-phone-square fa-lg" aria-hidden="true"></i> +33 33 33 33 33 33</p>
                
                                </div>
                
                            </div>
                        </div>
                    </div>
                </div>
              </section>
             <!--Contact Us Section-->
           
             @endsection
