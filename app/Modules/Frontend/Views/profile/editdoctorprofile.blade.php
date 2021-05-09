@extends('Frontend::layouts.frontend')
@section('content')
    <?php
    // date_default_timezone_set("Asia/Bangkok");
    //usercountry is available
    ?>
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <?php $doctordata = isset($doctordata[0]) ? (array)$doctordata[0] : []; ?>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-12 mt-2">
                    <ol>
                        <li><a href="{{ route('doctor.dashboard') }}">Home</a></li>
                        <li>{{ __('doctor/form.Doctor') }}</li>
                        <li>{{ __('doctor/form.dr-shortened') }} {{ucfirst($doctordata['dname']) ?? ''}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section><!-- End Breadcrumbs Section -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif


    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <section class="inner-page">
        <div class="container">
            <ul class="nav nav-tabs nav-fill wizard" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a href="#home" class="nav-link active" id="home-tab" data-toggle="tab" role="tab"
                       aria-controls="home" aria-selected="true"><span class="step"><i class="fa fa-user-md"
                                                                                       aria-hidden="true"></i></span>Profile</a>
                </li>
                @if(!empty($doctorMetaTypes))
                    @foreach($doctorMetaTypes as $docMetaType)
                        <li class="nav-item">
                            <a href="#{{$docMetaType->dmetakey}}" class="nav-link" id="{{$docMetaType->dmetakey}}-tab"
                               data-toggle="tab" role="tab" aria-controls="{{$docMetaType->dmetakey}}"
                               aria-selected="false"><span class="step"><i class="fa fa-trophy" aria-hidden="true"></i></span>{{$docMetaType->dmetaname}}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form id="doctor_profile_form" method="post" action="{{ route('doctor-profile.update') }}"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{$doctordata['id']}}"/>
                        <input type="hidden" name="doctorcode" value="{{$doctordata['doctorcode']}}"/>
                        <div class="row">
                            <div class="col-12"><h4>Personal Details</h4></div>
                            <div class="col-12 mb-3">
                                <h6 class="mb-0">Title<span class="asterik">*</span></h6>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="title" value="mr"
                                           class="custom-control-input" {{ $doctordata['title'] == 'mr' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadioInline1">Mr</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="title" value="mrs"
                                           class="custom-control-input" {{ $doctordata['title'] == 'mrs' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadioInline2">Mrs</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline3" name="title" value="miss"
                                           class="custom-control-input" {{ $doctordata['title'] == 'miss' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadioInline3">Miss</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline4" name="title" value="ms"
                                           class="custom-control-input" {{ $doctordata['title'] == 'ms' ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadioInline4">Ms</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">First Name<span class="asterik">*</span></h6>
                                    <input type="text" name="firstname" placeholder="Please enter first name"
                                           value="{{ $doctordata['firstname'] ?? ''}}" class="form-control"/>
                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Sur Name<span class="asterik">*</span></h6>
                                    <input type="text" name="lastname" placeholder="Please enter sur name"
                                           value="{{ $doctordata['lastname'] ?? ''}}" class="form-control"/>
                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Date of Birth<span class="asterik">*</span></h6>
                                    <input type="date" name="dob" placeholder="mm/dd/yyyy"
                                           value="{{ $doctordata['dob'] ?? ''}}" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Mobile Phone Code<span class="asterik">*</span></h6>
                                    <input type="text" class="phonecode pc form-control" name="phonecode"
                                           data-value="{{ isset($doctordata['phoneCode']) ? $doctordata['phoneCode'] : old('phonecode') }}"
                                           value="{{ isset($doctordata['phoneCode']) ? $doctordata['phoneCode'] : old('phonecode') }}"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Mobile Phone<span class="asterik">*</span></h6>
                                    <input name="phone" id="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{isset($doctordata['phoneNumber']) ? $doctordata['phoneNumber'] : old('phone')}}"/>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Email Address<span class="asterik">*</span></h6>
                                    <input type="text" name="email" placeholder="Please enter email"
                                           value="{{ $doctordata['email'] ?? ''}}" class="form-control"/>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3"><h4 class="mb-0">Account</h4></div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Account Password</h6>
                                    <input type="text" name="name" placeholder="Please Enter" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Repeat Password</h6>
                                    <input type="text" name="name" placeholder="Please Enter" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-12 mb-3"><strong>{{ __('doctor/form.invalid-password') }}</strong></div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3"><h4 class="mb-0">Clinic/Hospital Address</h4></div>
                            <div class="col-12 mb-3">
                                <h6 class="mb-0">{{ __('doctor/form.owner') }}<span class="asterik">*</span></h6>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline5" name="customRadioInline2"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline5">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline6" name="customRadioInline2"
                                           class="custom-control-input" checked>
                                    <label class="custom-control-label" for="customRadioInline6">No</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group pos-rel">
                                    <h6 class="mb-0">Address1<span class="asterik">*</span></h6>
                                    <span class="map-pointer"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    <input type="text" name="address_line1"
                                           placeholder="{{ __('doctor/form.Please Enter Address line 1') }}"
                                           value="{{ $doctordata['address_line1'] ?? ''}}"
                                           class="form-control address-field"/>
                                    @error('address_line1')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group pos-rel">
                                    <h6 class="mb-0">Address2<span class="asterik">*</span></h6>
                                    <span class="map-pointer"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    <input type="text" name="address_line2"
                                           placeholder="{{ __('doctor/form.Please Enter Address line 2') }}"
                                           value="{{ $doctordata['address_line2'] ?? ''}}"
                                           class="form-control address-field"/>
                                    @error('address_line2')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Country<span class="asterik">*</span></h6>
                                <!--<input type="text" name="address_country" placeholder="Please Enter Country" value="{{ $doctordata['countryname'] ?? ''}}" class="form-control"/>-->
                                    <select
                                        class="form-control countries @error('address_country') is-invalid @enderror"
                                        id="countryId" aria-describedby="address_country" placeholder="Country"
                                        name="address_country"
                                        data-value="{{isset($doctordata) ? $doctordata['address_country'] : old('address_country')}}">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">State<span class="asterik">*</span></h6>
                                <!--<input type="text" name="address_country" placeholder="Please Enter Country" value="{{ $doctordata['countryname'] ?? ''}}" class="form-control"/>-->
                                    <select class="form-control states @error('address_state') is-invalid @enderror"
                                            id="stateId" aria-describedby="address_state" placeholder="State"
                                            name="address_state"
                                            data-value="{{isset($doctordata) ? $doctordata['address_state'] : old('address_country')}}">
                                        <option value="">Select State</option>
                                    </select>
                                    @error('address_state')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Town/City<span class="asterik">*</span></h6>
                                <!--<input type="text" name="address_city" placeholder="Please Enter City" value="{{ $doctordata['cityname'] ?? ''}}" class="form-control"/>-->
                                    <select class="form-control cities @error('address_city') is-invalid @enderror"
                                            name="address_city" class="cities" id="cityId"
                                            data-value="{{isset($doctordata) ? $doctordata['address_city'] : old('address_city')}}">
                                        <option value="">Select City</option>
                                    </select>
                                    @error('address_city')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Postcode<span class="asterik">*</span></h6>
                                    <input type="text" name="address_postcode" placeholder="Please Enter Postcode"
                                           value="{{ $doctordata['address_postcode'] ?? ''}}" class="form-control"/>
                                    @error('address_postcode')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3"><h4 class="mb-0">Additional Details</h4></div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Licence ID<span class="asterik">*</span></h6>
                                    <input type="text" name="licence" placeholder="Please Enter Licence"
                                           class="form-control" value="{{ $doctordata['licence'] ?? ''}}"/>
                                    @error('licence')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <h6 class="mb-0">Languages</h6>
                                    <div class="select2-primary">
                                        <!--<select data-placeholder="Know Languages" multiple class="chosen-select" tabindex="8">-->
                                        <select class="form-control" multiple="multiple" data-plugin="select2"
                                                data-placeholder="Select Known Language" name="languages[]">
                                            @if(isset($languageData) && count($languageData) > 0)
                                                @foreach($languageData as $lang)
                                                    <option
                                                        @if(isset($languageList) && in_array($lang->id, $languageList)) selected @endif>{{$lang->name . ' / ' . $lang->short_code}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('languages')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <h6 class="mb-0">Upload your Licence ID</h6>
                                @if (isset($doctordata['licence_file']))
                                    <div class="col-md-2">
                                        <img height="100" width="100" src="../uploads/{{$doctordata['licence_file']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="licence_file" id="licence_file" value="Upload Image"/>
                                    </div>
                                @else
                                    <div class="form-group upload-block">
                                        <input type="file" name="licence_file" id="licence_file" value="Upload Image"/>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <h6 class="mb-0">Upload your Profile Picture</h6>
                                @if (isset($doctordata['photo']))
                                    <div class="col-md-2">
                                        <img height="100" width="100" src="../uploads/{{$doctordata['photo']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="photo" id="photo" value="Upload Image"/>
                                    </div>
                                @else
                                    <div class="form-group upload-block">
                                        <input type="file" name="photo" id="photo" value="Upload Image"/>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="terms" class="custom-control-input"
                                               id="customCheck1">
                                        <label class="custom-control-label"
                                               for="customCheck1">{{ __('doctor/form.terms-agree') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-2">
                                <button type="submit" class="btn appointment-btn ml-0">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if(!empty($doctorMetaTypes))
                    @foreach($doctorMetaTypes as $docMetaType)
                        <div class="tab-pane fade" id="{{$docMetaType->dmetakey}}" role="tabpanel"
                             aria-labelledby="{{$docMetaType->dmetakey}}-tab">
                            <div class="row mt-3 d-flex justify-content-end">
                                <div class="col-2 text-right">
                                    <button class="btn appointment-btn ml-0"
                                            onClick="editMetaType('{{$docMetaType->dmetakey}}')">Edit
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h3 class="txt-green">{{$docMetaType->dmetaname}}</h3>
                                    <p id="{{$docMetaType->dmetakey}}-text">@if(isset($docMetaList[$docMetaType->dmeta_id])) {{$docMetaList[$docMetaType->dmeta_id]}} @endif</p>
                                    <textarea class="form-control" id="{{$docMetaType->dmetakey}}-edit"
                                              data-plugin="summernote" name="{{$docMetaType->dmetaname}}" rows="5"
                                              cols="5"
                                              style="display:none;">@if(isset($docMetaList[$docMetaType->dmeta_id])) {{$docMetaList[$docMetaType->dmeta_id]}} @endif</textarea>
                                    <button id="{{$docMetaType->dmetakey}}-submit" class="btn appointment-btn ml-0"
                                            onClick="SubmitMetaType('{{$docMetaType->dmeta_id}}', '{{$docMetaType->dmetakey}}')"
                                            style="display:none;">Save
                                    </button>
                                    <button id="{{$docMetaType->dmetakey}}-cancel" class="btn appointment-btn ml-0"
                                            onClick="cancelMetaType('{{$docMetaType->dmetakey}}')"
                                            style="display:none;">Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <?php

    function encodeTime($str)
    {
        $str = str_replace(':', 'COLON', str_replace(' ', 'SPACE', str_replace('-', 'HYPHEN', $str)));
        return $str;
    }
    ?>
@endsection
@section('jscript')
    <style type="text/css">
        .help-block {
            color: red;
        }
    </style>
    <!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.bookme').on('click', function () {
                var selected = $(this).attr('id');
                $('.bookme').each(function () {
                    if ($(this).attr('id') != selected) {
                        $(this).css('border', '1px solid #ccc');
                        $(this).css('background', 'rgb(237, 249, 233)');
                    } else {
                        $(this).css('border', '1px solid red');
                        $(this).css('background', '#ffd100');
                    }
                });
                displayData(selected);
            });
        });

        function displayData(selected) {
            selvalues = selected.split('_');
            console.log(selvalues);
            display = '<h6><b>Slot Deatils</b></h6>';
            $('#cid').val(selvalues[0]);
            ctypes = selvalues[1].replace('COMMA', ',');

            $('#ctypes').val(ctypes);
            $('#hid').val(selvalues[5]);
            display += '<label> Date: ' + selvalues[4].replace('HYPHEN', '-').replace('HYPHEN', '-') + '</label><br>';
            sv = selvalues[2].replace('COLON', ':');
            sv = sv.replace('SPACE', ' ');
            sv = sv.replace('HYPHEN', '-');
            sv = sv.replace('COLON', ':');
            sv = sv.replace('SPACE', ' ');
            display += '<label> Time : ' + sv + '</label><br>';
            $('#fullpath').val(selected);
            //-------------------------
            allctypes = $('#allctypes').val();
            allctypes = JSON.parse(allctypes);
            selopt = '<select name="selectedtype" id="selectedtype" style="font-size:12px;font-weight:bold">';
            $.each(allctypes, function (index, value) {

                ctype = $('#ctypes').val();

                if (ctypes.includes(index)) {
                    selopt += '<option value="' + index + '"><img src="' + value[1] + '" height="15">' + value[0].toUpperCase() + '</option>';
                }
            });
            selopt += '</select>'
            $('.selopt').html(selopt);
            //console.log(selopt);
            //--------------------------
            //display += selopt;
            $('#displaydetails').html(display);
            $('.bookhide').show();
            //console.log(selvalues);
            //$('#bookappointment').attr('action','/bookappointment');
        }

        function editMetaType(key) {
//    alert(key);
            $('#' + key + '-text').hide();
            $('#' + key + '-edit').show();
            $('#' + key + '-submit').show();
            $('#' + key + '-cancel').show();
        }

        function cancelMetaType(key) {
//    alert(key);
            $('#' + key + '-text').show();
            $('#' + key + '-edit').hide();
            $('#' + key + '-submit').hide();
            $('#' + key + '-cancel').hide();
        }

        function SubmitMetaType(id, key) {
            let metaValue = $('#' + key + '-edit').val();
            let docId = $.trim($('[name="id"]').val());
            $.ajax('/doctor/update_doctor_meta', {
                type: 'POST',  // http method
                data: {metaId: id, metaValue: metaValue, docId: docId},
                success: function (data, status, xhr) {
                    let response = JSON.parse(data);
                    console.log('data => ', data);
                    console.log('response => ', response);
                    console.log('status => ', status);
                    console.log('xhr => ', xhr);
                    alert(response.message);
                    $('#' + key + '-text').text(metaValue);
                    $('#' + key + '-text').show();
                    $('#' + key + '-edit').hide();
                    $('#' + key + '-submit').hide();
                    $('#' + key + '-cancel').hide();
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert(errorMessage);
                }
            });
        }
    </script>
@endsection
