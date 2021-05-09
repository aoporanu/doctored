@extends('Frontend::layouts.frontend')
@section('content')

<section class="breadcrumbs">
    <div class="container">

        <div class="row">
            <div class="col-lg-3 col-md-3 col-12 mt-2">
                <ol>
                    <li><a href="/doctor-dashboard">Home</a></li>
                    <li>Consultation</li>
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
<main id="main">
    <section class="inner-page">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto">
                    <!-- Profile widget -->
                    <div class="bg-white shadow rounded overflow-hidden">
                        <div class="p-3 cover pos-rel">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="media align-items-end profile-head">
                                        <div class="profile mr-3"><img src="@if($slotData->photo) {{$slotData->photo}} @else /assets/img/patient-pic1.jpg @endif" alt="..." width="130" class="rounded mb-2 img-thumbnail"></div>
                                        <div class="media-body text-white">
                                            <h4 class="mt-0 mb-2 txt-white">Mr {{$slotData->patient_name}}</h4>
                                            <p class="small mb-2">Id: #{{$slotData->patientcode}}</p>
                                            <p class="small mb-2">Booking Date: {{$slotData->booking_date}} | Slot Booked On: {{$slotData->booking_time_long}}</p>
                                            <p class="small mb-2">Appointment Date: {{$slotData->booking_date}}</p>
                                            <p class="small mb-2">Payment Status: {{ucwords($slotData->booking_status)}}</p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                    <div class="row">
                                        <div class="col-12 mt-1">
                                            @if(!empty($consultationTypesObj))
                                            @foreach($consultationTypesObj as $consultationType)
                                            <p class="badge badge-primary text-wrap"><i class="fa fa-user-md" aria-hidden="true"></i>{{$consultationType->ctype_name}}</p>
                                            @endforeach
                                            @endif
<!--                                            <p class="badge badge-primary text-wrap"><i class="fa fa-phone" aria-hidden="true"></i> Telephone</p>
                                            <p class="badge badge-primary text-wrap"><i class="fa fa-user-md" aria-hidden="true"></i> Visit Practise</p>
                                            <p class="badge badge-primary text-wrap"><i class="fa fa-comments" aria-hidden="true"></i> Chat</p>
                                            <p class="badge badge-primary text-wrap"><i class="fa fa-video-camera" aria-hidden="true"></i> Video Call</p>-->
                                        </div>
                                        <div class="col-12">
                                            @if(!empty($languageData))
                                            @foreach($languageData as $languageInfo)
                                            <p class="badge badge-primary text-wrap">{{$languageInfo->value}}</p>
                                            @endforeach
                                            @endif
<!--                                            <p class="badge badge-primary text-wrap">English</p>
                                            <p class="badge badge-primary text-wrap">Hindi</p>
                                            <p class="badge badge-primary text-wrap">Telugu</p>-->
                                        </div>
                                        <div class="col-12 mb-0 mt-2"><a href="#" class="btn btn-primary ml-0">Enter OTP</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row ml-0 mr-0">
                            <div class="container">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-head" id="headingOne">
                                            <h2 class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Consultation
                                            </h2>
                                        </div>
                                        <form id="doctor_consultation_data" method="post" action="/doctor/confirm_consultation" enctype="multipart/form-data">
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row ml-0 mr-0">
                                                        <div class="col-lg-6 col-md-6 col-12 bg-grey">
                                                            <h4 class="txt-green">Symptoms: {{$slotData->title}}</h4>
                                                            <p>{{$slotData->description}}</p>
                                                            <p class="consultation-choosed w-50 text-center">
                                                                <!--<i class="fa fa-video-camera" aria-hidden="true"></i>-->
                                                                <img src="{{URL::to('/')}}/{{$slotData->ctype_icon}}" />
<!--                                                                <a href="#" class="btn btn-primary ml-0">Start Consultation</a>-->
                                                                    <button class="btn btn-primary ml-0" type="button" id="start_consultation">Start Consultation</button>
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" id="confirm_close" data-target="#panelModal">Confirm & Close</button>
                                                            </p>
                                                            @if(!empty($consultationTypesObj))
                                                            <h5 class="txt-green">Change Consultation Type</h5>
                                                            <div class="row ml-0 mr-0">                                                                
                                                                @foreach($consultationTypesObj as $consultationType)
                                                                @if($slotData->booking_type != $consultationType->ctype_id)
                                                                <div class="change-consultation"><a href="#" class="btn btn-primary"><img src="{{URL::to('/')}}/{{$consultationType->ctype_icon}}" /> <span>{{$consultationType->ctype_name}}</span></a></div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-12">
                                                            <div class="row ml-0 mr-0 mb-3 d-flex justify-content-end">
                                                                <h6 class="mb-0 d-inline txt-green">Severity<span class="asterik">*</span></h6>
                                                                <div class="custom-control custom-radio custom-control-inline ml-2">
                                                                    <input type="radio" id="customRadioInline1" name="severity" value="High" class="custom-control-input" checked="">
                                                                    <label class="custom-control-label" for="customRadioInline1">High</label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="customRadioInline2" name="severity" value="Medium" class="custom-control-input">
                                                                    <label class="custom-control-label" for="customRadioInline2">Medium</label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="customRadioInline3" name="severity" value="Low" class="custom-control-input">
                                                                    <label class="custom-control-label" for="customRadioInline3">Low</label>
                                                                </div>
                                                            </div>
                                                            <div class="card mb-0 no-border">
                                                                <div class="card-header">

                                                                    <!-- START TABS DIV -->
                                                                    <div class="tabbable-responsive">
                                                                        <div class="tabbable">
                                                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link active" id="doctor_notes-tab" data-toggle="tab" href="#doctor_notes" role="tab" aria-controls="doctor_notes" aria-selected="true">Doctor Notes</a>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" id="Prescription-tab" data-toggle="tab" href="#Prescription" role="tab" aria-controls="Prescription" aria-selected="false">Prescription</a>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" id="Reports-tab" data-toggle="tab" href="#Reports" role="tab" aria-controls="Reports" aria-selected="false">Reports</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="doctor_id" value="{{$slotData->doctor_id}}" />
                                                                <input type="hidden" name="patient_id" value="{{$slotData->patient_id}}" />
                                                                <input type="hidden" name="hospital_id" value="{{$slotData->hospital_id}}" />
                                                                <input type="hidden" name="slotid" value="{{$slotData->slotid}}" />
                                                                <input type="hidden" name="booking_type" value="{{$slotData->booking_type}}" />
                                                                <div class="card-body p-2 card-border">                                    
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane fade show active" id="doctor_notes" role="tabpanel" aria-labelledby="doctor_notes-tab">
<!--                                                                            <div class="row mb-3 ml-0 mr-0  ">
                                                                                <div class="col-12 text-right"><i class="fa fa-plus" aria-hidden="true"></i> Add</div>
                                                                            </div>-->
                                                                            <textarea name="doctor_notes" class="card-text fixed-height">{{isset($consultationTypeDataList['doctor_notes']) ? $consultationTypeDataList['doctor_notes'] : ''}}</textarea>
                                                                            <div class="col-md-12"> 
                                                                                <input type="file" name="doctor_notes_file[]" id="doctor_notes_file" value="Upload Notes" multiple />                                    
                                                                            </div>
<!--                                                                            <div class="row ml-0 mr-0 mt-3 d-flex justify-content-end">
                                                                                <a href="javascript:void(0);" class="btn btn-primary ml-0 mr-3 save" onclick="saveConsultationData({{$slotData->doctor_id}}, {{$slotData->patient_id}}, {{$slotData->hospital_id}}, {{$slotData->slotid}}, 'doctor_notes')" id="save">Save</a> 
                                                                                <div class="spinner-border text-warning" role="status">
                                                                                    <span class="sr-only">Loading...</span>
                                                                                </div>
                                                                                <a href="javascript:void(0);" class="btn btn-primary ml-0 txt-grey">Cancel</a>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="tab-pane fade" id="Prescription" role="tabpanel" aria-labelledby="Prescription-tab">
                                                                            <!--<div class="col-12 text-right mb-3 pr-0"><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></div>-->
                                                                            <textarea name="Prescription" class="card-text fixed-height">{{isset($consultationTypeDataList['Prescription']) ? $consultationTypeDataList['Prescription'] : ''}}</textarea>
                                                                            <div class="col-md-12"> 
                                                                                Upload Prescription <input type="file" name="prescriptions_file[]" id="prescriptions_file" value="Upload Prescription" multiple />                                    
                                                                            </div>
<!--                                                                            <div class="row ml-0 mr-0 mt-3 d-flex justify-content-end">
                                                                                <a href="javascript:void(0);" class="btn btn-primary ml-0 mr-3 save" onclick="saveConsultationData({{$slotData->doctor_id}}, {{$slotData->patient_id}}, {{$slotData->hospital_id}}, {{$slotData->slotid}}, 'Prescription')" id="save">Save</a> 
                                                                                <div class="spinner-border text-warning" role="status">
                                                                                    <span class="sr-only">Loading...</span>
                                                                                </div>
                                                                                <a href="javascript:void(0);" class="btn btn-primary ml-0">Cancel</a>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="tab-pane fade" id="Reports" role="tabpanel" aria-labelledby="Reports-tab">
                                                                            <!--<div class="col-12 text-right mb-3 pr-0"><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></div>-->
                                                                            <textarea name="Reports" class="card-text fixed-height">{{isset($consultationTypeDataList['Reports']) ? $consultationTypeDataList['Reports'] : ''}}</textarea>
                                                                            <div class="col-md-12"> 
                                                                                Upload Reports <input type="file" name="reports_file[]" id="reports_file" value="Upload Reports" multiple />                                    
                                                                            </div>
<!--                                                                            <div class="row ml-0 mr-0 mt-3 d-flex justify-content-end">
                                                                                <a href="javascript:void(0);" class="btn btn-primary ml-0 mr-3 save" onclick="saveConsultationData({{$slotData->doctor_id}}, {{$slotData->patient_id}}, {{$slotData->hospital_id}}, {{$slotData->slotid}}, 'Reports')" id="save">Save</a> 
                                                                                <div class="spinner-border text-warning" role="status">
                                                                                    <span class="sr-only">Loading...</span>
                                                                                </div>
                                                                                <a href="javascript:void(0);" class="btn btn-primary ml-0">Cancel</a>
                                                                            </div>-->
                                                                        </div>

                                                                    </div>
                                                                    <!-- END TABS DIV -->

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card">
                                        <div class="card-head" id="headingTwo">
                                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Medical History
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse p-2 prev-history-container" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row p-2">
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                                            <i class="fa fa-calendar-check-o txt-green" aria-hidden="true"></i> 10/12/2020 | <i class="fa fa-clock-o txt-green" aria-hidden="true"></i> 10:00 AM
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-6 col-6 text-right severity-block">Cardiologist | <i class="fa fa-circle red" aria-hidden="true"></i> <span>High</span></div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-2">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-12">
                                                            <h5 class="mt-0 mb-1 txt-green">Symptoms: Chest Pain</h5>
                                                            <div class="media align-items-end profile-head">
                                                                <div class="profile mr-3"><img src="assets/img/doctor-pic.jpg" alt="..." width="90" class="rounded mb-2 img-thumbnail"></div>
                                                                <div class="media-body mb-4">
                                                                    <p class="small mb-1">Dr. Pradeep Reddy</p>
                                                                    <p class="small mb-1">Expert In: Cardiology</p>
                                                                    <p class="small mb-1">Apollo Hospitals | Begumpet</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-12">
                                                            <div class="prev-history-reports">
                                                                <ul class="nav nav-tabs" id="myTab">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" data-toggle="tab" href="#tabOne">Doctor Notes</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab" href="#tabTwo">Prescriptions</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab" href="#tabThree">Reports</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="myTabContent">
                                                                    <div class="tab-pane fade active show p-2" id="tabOne">Doctor Notes</div>
                                                                    <div class="tab-pane fade p-2" id="tabTwo">Prescriptions</div>
                                                                    <div class="tab-pane fade p-2" id="tabThree">Reports</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="panelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-simple" role="document" style="max-width: 800px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Consultation Summary</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="media align-items-end profile-head">
                            <div class="profile mr-3"><img src="@if($slotData->photo) {{$slotData->photo}} @else /assets/img/patient-pic1.jpg @endif" alt="..." width="130" class="rounded mb-2 img-thumbnail"></div>
                            <div class="media-body">
                                <h4 class="mt-0 mb-2 txt-white">Mr {{$slotData->patient_name}}</h4>
                                <p class="small mb-2">Id: #{{$slotData->patientcode}}</p>
                                <p class="small mb-2">Booking Date: {{$slotData->booking_date}} | Slot Booked On: {{$slotData->booking_time_long}}</p>
                                <p class="small mb-2">Appointment Date: {{$slotData->booking_date}}</p>
                                <p class="small mb-2">Payment Status: {{ucwords($slotData->booking_status)}}</p> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row ml-0 mr-0">
                        <div class="col-lg-6 col-md-6 col-12 bg-grey">
                            <h4 class="txt-green">Symptoms: {{$slotData->title}}</h4>
                            <p>{{$slotData->description}}</p>                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="row ml-0 mr-0 mb-3 d-flex justify-content-end">
                                <h6 class="mb-0 d-inline txt-green">Severity<span class="asterik">*</span></h6>
                                <p id="Severity-data"></p>
                            </div>
                            <div class="card mb-0 no-border">
                                <div class="card-header">
                                    <!-- START TABS DIV -->
                                    <div class="tabbable-responsive">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="doctor_notes-data-tab" data-toggle="tab" href="#doctor_notes-data" role="tab" aria-controls="doctor_notes-data" aria-selected="true">Doctor Notes</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="Prescription-tab-data" data-toggle="tab" href="#Prescription-data" role="tab" aria-controls="Prescription-data" aria-selected="false">Prescription</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="Reports-data-tab" data-toggle="tab" href="#Reports-data" role="tab" aria-controls="Reports-data" aria-selected="false">Reports</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-2 card-border">                                    
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="doctor_notes-data" role="tabpanel" aria-labelledby="doctor_notes-data-tab">
                                            <p id="doctor_notes_data"></p>
                                        </div>
                                        <div class="tab-pane fade" id="Prescription-data" role="tabpanel" aria-labelledby="Prescription-data-tab">
                                            <p id="prescription_data"></p>
                                        </div>
                                        <div class="tab-pane fade" id="Reports-data" role="tabpanel" aria-labelledby="Reports-data-tab">
                                            <p id="reports_data"></p>
                                        </div>

                                    </div>
                                    <!-- END TABS DIV -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm">Confirm</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('jscript')
<script type="text/javascript">
    $(document).ready(function(){
        $('.spinner-border').hide();
        $('#confirm_close').hide();
        $('#start_consultation').click(function(){
            $('#start_consultation').hide();
            $('#confirm_close').show();
        });
    })
function saveConsultationData(doctorId, patientId, hospitalId, slotId, consultationDataType)
{
    let data = $('[name="' + consultationDataType + '"]').val();
    if (data != ''){
        $.ajax({
        url: '/doctor/update_consultation_data',
            type: "POST",
            beforeSend: function() {
                $(".save").hide();
                $('.spinner-border').show();
            },
            data: {doctorId: doctorId, patientId: patientId, hospitalId: hospitalId, slotId: slotId, consultationDataType: consultationDataType, data: data},
            success: function(response) {
                console.log('response => ', response);
                let data = JSON.parse(response);
    //                        if(data.status == 'success'){
                if (typeof data.message != 'undefined'){
                    alert(data.message);
                }
                $('.save').show();
                $('.spinner-border').hide();
            }
        });
    }
}
//$( "#doctor_consultation_data" ).submit(function( event ) {
//  alert( "Handler for .submit() called." );
//  event.preventDefault();
//});
$("#confirm").click(function() {
    $("#doctor_consultation_data").submit();
})
$( "#panelModal" ).on( "show.bs.modal", function( event, ui ) {
        
        $('#doctor_notes_data').text($('[name="doctor_notes"]').val());
        $('#prescription_data').text($('[name="Prescription"]').val());
        $('#reports_data').text($('[name="Reports"]').val());
        $('#Severity-data').text($('[name="severity"]:checked').val());
    }
);
</script>
@endsection