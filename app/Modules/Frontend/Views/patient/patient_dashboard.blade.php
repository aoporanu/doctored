@extends('Frontend::layouts.frontend')
@section('content')

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="row">
                <div class="col-lg-3 col-md-3 col-12 mt-2">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li>Dashboard</li>
                    </ol>
                </div>

                <div class="col-lg-9 col-md-9 col-12">
                    <div class="row justify-content-end">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="input-group custom-search">
                                <input type="text" class="form-control"
                                       placeholder="Patient Name/Mobile Number/Patient ID">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
        <div class="container">
            <!-- page-title -->
            <div class="page-title-1 pb-3">
                <div class="row doc-block ml-0 mr-0">
                    <div class="col-12">
                        <div class="row">
                            <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-12 avatar-circle"><img src="assets/img/avatars/doctor.png" alt="doc-avatar" /></div> -->
                            <div class="col-12">
                                <ul class="doc-details">
                                    <li><span>{{ \Carbon\Carbon::now()->format('jS') }}</span> {{ \Carbon\Carbon::now()->monthName }}, {{ \Carbon\Carbon::now()->dayName }}</li>
                                    <li><span>09</span> Total Appointments</li>
                                    <li><span>02</span> Cancel Appointments</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- End / page-title -->

            <!-- Section -->
            <section class="md-section sldr-slot circle-1 pb-0 pt-2">

                <div class="container pb-3">

                    <div class="row">
                        <div class="col-12 pl-0 pr-0"><h4 class="txt-green">Manage Slots</h4></div>
                        <div class="col-12 card">
                            <div class="card-body pt-3 pb-3 pl-0 pr-0">
                                This section for Manage Slots for development.
                                @foreach($doctors as $doctor)
                                    <div class="row">
                                        <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img
                                                src="assets/img/patient-pic.jpg" class="img-circle-width"
                                                alt="patient-avatar"/></div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Doctor name</h6>
                                            <span>{{ $doctor->firstname . ' ' . $doctor->lastname }}</span></div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Active since</h6>
                                            <span></span></div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Request Appointment</h6>
                                            <span><form method="post" action="{{ route('initiate_call') }}">
                                                    @csrf
                                                    <input type="hidden" name="number_to_call" value="{{ $doctor->phone }}">
                                                    <button
                                                        type="submit" class="btn btn-primary"><i
                                                            class="fa fa-phone"></i></button></form></span>
                                            <span>
                                                <video-form room_name="{{ $doctor->email }}"></video-form>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- End / Section -->

            <!-- Section -->
            <section class="md-section pt-3 pb-3">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-12 xs-top">
                        <h4 class="txt-green">Manage Consultation</h4>
                        <div class="card man-con">
                            <div class="card-body p-0">
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6>
                                        <span>Rajamouli</span></div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 18th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Vinayak Reddy</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 19th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Raju Hirani</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 20th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                                <div class="row mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Deepak Muske</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 21th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 xs-top">
                        <h4 class="txt-green">Manage Reports</h4>
                        <div class="card man-con">
                            <div class="card-body p-0">
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-3 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-9"><h6>Thu 16th, Dec</h6> <span>Afshan Ibrahim</span>
                                    </div>
                                    <div class="col-12 offset-lg-0 offset-md-2">Patient called and says thanks...</div>
                                </div>
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-3 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-9"><h6>Thu 17th, Dec</h6> <span>Kelly Dodze</span>
                                    </div>
                                    <div class="col-12 offset-lg-0 offset-md-2">Patient called and says thanks...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End / Section -->

            <!-- Section -->
            <section class="md-section xs-top pt-3 pb-3">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                        <h4 class="txt-green">Recent Member Activity</h4>
                        <div class="card man-con">
                            <div class="card-body p-0">
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Andy Battle</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 18th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Andy Battle</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 19th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Andy Battle</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 20th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                                <div class="row mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Andy Battle</span>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6>
                                        <span>Sat 21th Dec</span></div>
                                    <div
                                        class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3">
                                        <h6>Health Status</h6> <span>Back Pain</span></div>
                                    <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment
                                            Status</h6> <span>Confirmed</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 xs-top">
                        <h4 class="txt-green">Manage Prescription</h4>
                        <div class="card man-con">
                            <div class="card-body p-0">
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-3 col-md-2 col-sm-3 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-9"><h6>Thu 16th, Dec</h6> <span>Afshan Ibrahim</span>
                                    </div>
                                    <div class="col-12 offset-lg-0 offset-md-2">Prescription details goes here...</div>
                                </div>
                                <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                    <div class="col-lg-3 col-md-2 col-sm-3 col-3"><img src="assets/img/patient-pic.jpg"
                                                                                       class="img-circle-width"
                                                                                       alt="patient-avatar"/></div>
                                    <div class="col-md-9 col-sm-9 col-9"><h6>Thu 17th, Dec</h6> <span>Kelly Dodze</span>
                                    </div>
                                    <div class="col-12 offset-lg-0 offset-md-2">Prescription details goes here...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End / Section -->

        </div>
    </section>
@endsection
