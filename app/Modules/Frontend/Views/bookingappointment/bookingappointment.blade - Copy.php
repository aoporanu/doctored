@extends('Frontend::layouts.frontend')
@section('content')
<div class="row cont_sec2 mrg-bot-10">
    @include('Frontend::layouts.sidebar')
    <!--Contact Us Section-->    
    <div class="col-md-8 col-12">
        <div class="cont_box2  custom-mt2-10">
            <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 cont_box">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-xl-3 col-lg-3 doc_pic"><img
                            src="images/doctor_pic.jpg" class="img-responsive" style="max-width:50%"></div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-xl-9 col-lg-9 doc_sec">
                        <div class="row">
                            <div class="input-group mb-3 col-7 ml-sm-auto">
                                <input type="text" id="search" class="form-control  p-3"
                                       name="" placeholder="Patient name/ Mobile number/ ID">
                                <span class="input-group-addon searchBookAPT"><button class="btn btn-default "><i class="fa fa-search"></i></button></span>
                            </div>
                        </div>
                        <span class="text-grey-custom">{{$doctorDetails->title}} {{$doctorDetails->firstname}} {{$doctorDetails->lastname}}</span>|

                        <span class="doc_qual_text py-2">#{{$doctorDetails->doctorcode}}</span>|
                        <span class="doc_qual_text py-2">{{implode(', ', $doctorSpecilizationTypes)}}</span><br>
                        <span class="doc_qual_text py-2">DOB:{{$doctorDetails->dob}}</span>|
                        <span class="doc_qual_text py-2">Type Single</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="cont_box2 mt-4">
            <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 cont_box">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 doc_sec">
                        <h4 class="text-green font-custom-bold" style="display: inline-block;">Book your
                            Appointment</h4>

                        <form method="post" action="/create_appointment">
                            @csrf
                            <div class="row">
                                <label class="col-md-2"><strong> Consultation Types:  </strong></label>
                                <div class="col-md-9">
                                    <div class="select2-primary">
                                        <select class="form-control" data-placeholder="Select Consultation Types" name="consultation_type" onchange='fetch'>
                                            <option value=''>Select Consultation Type</option>
                                            @foreach($consultationTypes as $consultation)
                                            <option value="{{$consultation->ctype_id}}" @if(isset($consultationList) && in_array($consultation->ctype_id, $consultationList)) selected @endif>{{$consultation->ctype_name}}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="appointmentDate">Appointment Date</label>
                                        <input type="hidden" id="hospital_id" name="hospital_id" value="{{ $hospitalId }}" />
                                        <input type="hidden" id="doctor_id" name="doctor_id" value="{{ $doctorId }}" />
                                        <select class="form-control" name="appointmentDate" id="appointmentDate">
                                            <option value=''>Select Date</option>
                                            @foreach($appointmentDetails as $appointmentData)
                                            <option value="{{$appointmentData->booking_date}}">{{$appointmentData->booking_date}}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="appointmentTime">Appointment Time</label>
                                        <select class="form-control" data-placeholder="Select Date" name="appointmentTime" id="appointmentTime">
                                            <option value="">Select Time</option>
                                        </select>
                                        <!--<input type="time" class="form-control" id="appointmentTime" placeholder="please enter">-->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="appointmentTitle">Appointment Tile</label>
                                        <input type="text" class="form-control" id="appointmentTitle" name="appointment_title" 
                                               placeholder="e.g. typhoid">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="please enter email">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" class="form-control" id="phone" name="phone" 
                                               aria-describedby="Mobile" placeholder="0222-222-2222">
                                    </div>
                                </div>
<!--                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" id="country"
                                               placeholder="please enter here">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city"
                                               placeholder="please enter city">
                                    </div>
                                </div>-->
                            </div>
                            <div class="row">

                                <div class="form-group col">
                                    <label for="message">Appointment Details</label>
                                    <textarea class="form-control" id="message" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-check col  ml-4">
                                    <input type="checkbox" class="form-check-input" name="doctor_concent" id="doctor_concent">
                                    <label class="form-check-label" for="doctor_concent">Give consent to
                                        doctor for Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                    </label>
                                    @error('doctor_concent')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-check col ml-4">
                                    <input type="checkbox" class="form-check-input" name="patien_concent" id="patien_concent">
                                    <label class="form-check-label" for="patien_concent">Give consent amet
                                        consectetur adipisicing elit.
                                    </label>
                                    @error('patien_concent')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6 my-auto">
                                    <button type="submit" class="btn btn-signup"
                                            style="margin-top: 15px;">Book Appointment</button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>






        <!--Footer Starts Here-->
        <div class="fullcont_sec">
            <div class="bg_grey">

                <div class="foot_bg">
                    <div class="row h-100">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 my-auto"><img src="images/foot_logo.svg" class="img-responsive fot_logo"></div>
                        <div class="col-lg-7 col-md-7 col-sm-8 col-xs-10 my-auto">
                            <p>
                                Ut perum sequate stempori ut velique cor
                                maiosti onsectati assinie nditem et omnient,
                                tem quis autatem sintin re veruptam,
                                consedCiis eostrum que et hilignatior
                            </p>
                        </div>
                        <!-- <div class="col-sm-3 col-md-3 col-xs-12 my-auto"></div> -->
                        <div class="col-sm-12 col-md-4 col-xs-12 col-lg-3 my-auto" style="display:inline-block; vertical-align:middle;">
                            <ul class="foot_links">
                                <li><i class="fa fa-linkedin"></i></li>
                                <li><i class="fa fa-twitter"></i></li>
                                <li><i class="fa fa-facebook-f"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Contact Us Section-->
</div>
@endsection
