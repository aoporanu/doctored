@extends('Frontend::layouts.frontend')
@section('content')
asd
<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mt-2">
                <ol>
                    <li><a href="{{ route('/') }}">Home</a></li>
                    <li>Dashboard</li>
                </ol>
            </div>

            <div class="col-lg-9 col-md-9 col-12">
                <div class="row justify-content-end">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="input-group custom-search">
                            <input type="text" class="form-control" placeholder="Patient Name/Mobile Number/Patient ID">
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
                                <!--<li><span>8th</span> December, Tuesday</li>-->
                                <li><span>{{date("jS", strtotime(date('d-m-Y')))}}</span> {{date("F, l", strtotime(date('d-m-Y')))}}</li>
                                <li><span>{{$todayBookings}}</span> Total Appointments</li>
                                <li><span>{{$todayCancellations}}</span> Cancel Appointments</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- End / page-title -->

        <!-- Section -->
        <section class="md-section sldr-slot circle-1 pb-0" style="padding: 0px 0px !important;">

            <div class="container pl-0 pr-0 pb-3 position-relative">

                <div class="row mt-5">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-8 pl-3"><h2 class="post-03__title">Manage Slots</h2></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-align pr-4">
<!--                        <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                            <input class="form-control" type="text" readonly id="slot_date" />
                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>-->
                    </div>
                </div>
                @if (count($availableSlots) == 0)
                <h5>No Slots available</h5>
                @else
                <div id="demo" class="carousel slide position-relative" data-ride="carousel">
                    <div class="row">
                        <div class="col-2 offset-9">
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next" style="right: -40px !important;">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <?php $count = 0; ?>
                        @foreach ($availableSlotDates as $avbDate)
                        <div class="carousel-item {{$count == 0 ? 'active' : ''}} {{$count != 0 && $count < count($availableSlotDates) ? 'carousel-item-next ' : '' }}">
                            <div class="d-flex">
                                <div class="col-12 d-flex flex-column card pl-0 pr-0">
                                    <div class="introduce card-body">
                                        <h5 class="post-02__title pl-2 pr-2 mt-1">{{date("l jS F, Y", strtotime($avbDate))}}</h5>
                                        <div class="flex-column-1 p-1">
                                            <div class="row ml-0 mr-0">
                                                @foreach ($availableSlots as $avbSlots)
                                                @if($avbDate == $avbSlots->booking_date)
                                                <div class="col-lg-2 col-md-4 col-sm-6 col-6 p-1">
                                                    <div class="slot-box">
                                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i>{{date("G:i A", strtotime($avbSlots->booking_start_time))}}</p>
                                                        <p>1 time slot available</p>
                                                        <p><a @if (isset($avbSlots->appointment_status) && $avbSlots->appointment_status != '') href="/doctor/consultation/{{$avbSlots->slotid}}" class="book-app" @else href="javascript:void(0);" class="booked" @endif >@if (isset($avbSlots->appointment_status) && $avbSlots->appointment_status != '') Booked @else Available @endif</a></p>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php $count++; ?>
                        @endforeach
                    </div>

                </div>
                @endif
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
<!--                            <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg" class="img-circle-width" alt="patient-avatar" /></div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Rajamouli</span></div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6> <span>Sat 18th Dec</span></div>
                                <div class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3"><h6>Health Status</h6> <span>Back Pain</span></div>
                                <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment Status</h6> <span>Confirmed</span></div>
                            </div>-->
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12 col-sm-12 col-12 xs-top">
                    <h4 class="txt-green">Manage Reports</h4>
                    <div class="card man-con">
                        <div class="card-body p-0">
<!--                            <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                <div class="col-lg-3 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg" class="img-circle-width" alt="patient-avatar" /></div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-9"><h6>Thu 16th, Dec</h6> <span>Afshan Ibrahim</span></div>
                                <div class="col-12 offset-lg-0 offset-md-2">Patient called and says thanks...</div>
                            </div>-->
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
<!--                            <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                <div class="col-lg-1 col-md-2 col-sm-2 col-3"><img src="assets/img/patient-pic.jpg" class="img-circle-width" alt="patient-avatar" /></div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-4"><h6>Patient Name</h6> <span>Andy Battle</span></div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-4"><h6>Date</h6> <span>Sat 18th Dec</span></div>
                                <div class="col-lg-3 offset-lg-0 col-md-6 offset-md-2 col-sm-4 offset-sm-2 col-4 offset-3"><h6>Health Status</h6> <span>Back Pain</span></div>
                                <div class="col-lg-3 col-md-4 offset-md-0 col-sm-4 offset-sm-2 col-4"><h6>Payment Status</h6> <span>Confirmed</span></div>
                            </div>-->
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12 col-sm-12 col-12 xs-top">
                    <h4 class="txt-green">Manage Prescription</h4>
                    <div class="card man-con">
                        <div class="card-body p-0">
<!--                            <div class="row brd-btm mt-3 mb-3 ml-0 mr-0">
                                <div class="col-lg-3 col-md-2 col-sm-3 col-3"><img src="assets/img/patient-pic.jpg" class="img-circle-width" alt="patient-avatar" /></div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-9"><h6>Thu 16th, Dec</h6> <span>Afshan Ibrahim</span></div>
                                <div class="col-12 offset-lg-0 offset-md-2">Prescription details goes here...</div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End / Section -->

    </div>
</section>
@endsection
@section('jscript')
<script type="text/javascript">
//$(document).ready(function () {
//
//});
$(function () {
    $("#datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        onSelect: function(dateText) {
            console.log("Selected date: " + dateText + "; input's current value: "+this.value);
        }
    });
});
$(document).ready(function () {
    $('#myModal').modal('show');
});
</script>
@endsection
