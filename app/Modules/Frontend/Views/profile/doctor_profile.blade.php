@extends('Frontend::layouts.frontend')
@section('content')
    <?php // date_default_timezone_set("Asia/Bangkok");
    //usercountry is available
    ?>
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <?php $doctordata = (array)$doctordata[0];?>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-12 mt-2">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li>Doctor</li>
                        <li>Dr. {{ucfirst($doctordata['dname']) ?? ''}}</li>
                    </ol>
                </div>


            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto">
                    <!-- Profile widget -->
                    <div class="bg-white shadow rounded overflow-hidden">
                        <div class="p-3 cover pos-rel">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <div class="media align-items-end profile-head">
                                        <div class="profile mr-3"><img
                                                src="{{$groupdata['photo'] ?? '/assets/img/doc.png'}}" alt="..."
                                                style="border-radius:35px" width="120"
                                                class="rounded mb-2 img-thumbnail"></div>
                                        <div class="media-body mb-4 text-white">
                                            <h4 class="mt-0 mb-0 txt-white">
                                                Dr. {{ucfirst($doctordata['dname']) ?? ''}}</h4>
                                            <?php
                                            $specs = array();
                                            foreach ($specialization as $skey => $sval) {
                                                $specs[] = ucfirst($sval->specialization_shortcode);
                                            }
                                            if (count($specs) > 0) {
                                                echo '<p class="small mb-2">Expert In: <!-- |Exp: 30 years -->' . implode(',', $specs) . '</p>';
                                            }

                                            ?>
                                            <p class="small mb-2"> {{ucfirst($doctordata['address_line1']) ?? ''}} {{ucfirst($doctordata['address_line2']) ?? ''}}
                                                <br/> {{ucfirst($doctordata['cityname']) ?? ''}}
                                                , {{ucfirst($doctordata['statename']) ?? ''}} {{ucfirst($doctordata['address_postcode']) ?? ''}}  <!--<i class="fa fa-map-marker" aria-hidden="true"></i> 4.5 kms</p>-->
                                                <a href="#" class="colr-yelw"><i class="fa fa-star"
                                                                                 aria-hidden="true"></i><i
                                                        class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star"
                                                                                                     aria-hidden="true"></i><i
                                                        class="fa fa-star" aria-hidden="true"></i><i
                                                        class="fa fa-star-half-o" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12 d-flex justify-content-end text-center">
                                    <div class="row mb-3">
                                        <div class="col-12 pl-0 pr-0 mt-3">

                                            <?php
                                            foreach ($consultations as $ckey => $cval) {
                                                echo '<p class="badge badge-primary text-wrap"><img height="15" src="/' . $cval->ctype_icon . '"> ' . ucfirst($cval->ctype_name) . ' </p>';
                                            }

                                            ?>
                                        </div>
                                        <div class="col-12 pl-0 pr-0">
                                            <?php
                                            if (count($languages) > 1) {
                                                foreach ($languages as $lamguage) {
                                                    echo '<p class="badge badge-primary text-wrap">' . ucfirst($lamguage->name) . '</p>&nbsp;';
                                                }
                                            } else {
                                                echo '<p class="badge badge-primary text-wrap">' . ucfirst($languages[0]->name) . '</p>&nbsp;';
                                            }

                                            ?>


                                        </div>

                                        <div class="col-12 text-center">
                                            <?php if (count($slots) > 0) { ?>
                                            <form name="bookappointment" id="bookappointment" method="post"
                                                  action="/book-appointment">
                                                @csrf

                                                <input type="hidden" id="docid" name="docid"
                                                       value="{{$doctordata['doctorcode'] ?? ''}}"/>

                                                <button type="submit" class="btn btn-primary btn-block">Book an
                                                    Appointment
                                                </button>
                                            </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-4 px-4">
                            <div class="row ml-0 mr-0 doctor-navtab">
                                <div class="card">
                                    <div class="card-header">

                                        <!-- START TABS DIV -->
                                        <div class="tabbable-responsive">
                                            <div class="tabbable">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="first-tab" data-toggle="tab"
                                                           href="#first" role="tab" aria-controls="first"
                                                           aria-selected="true">About Me</a>
                                                    </li>

                                                    <?php
                                                    dump($metadata);
                                                    foreach ($metadata as $mkey => $mval) {
                                                    $tabname = str_replace(' ', '', $mval->dmetaname);
                                                    ?>
                                                    <li class="nav-item">

                                                        <a class="nav-link" id="{{$tabname}}-tab" data-toggle="tab"
                                                           href="#{{$tabname}}" role="tab" aria-controls="{{$tabname}}"
                                                           aria-selected="true">{{ucfirst($tabname)}}</a>
                                                    </li>
                                                    <?php    }                          ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="second-tab" data-toggle="tab"
                                                           href="#second" role="tab" aria-controls="second"
                                                           aria-selected="false">Book Slot</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="first" role="tabpanel"
                                                 aria-labelledby="first-tab">
                                                <p class="card-text">

                                                    {{ucfirst($doctordata['summary']) ?? ''}}
                                                </p>
                                            </div>

                                            <?php
                                            foreach ($metadata as $mkey => $mval) {
                                            $taname = str_replace(' ', '', $mval->dmetaname);
                                            ?>
                                            <div class="tab-pane" id="{{$taname}}" role="tabpanel"
                                                 aria-labelledby="{{$taname}}-tab">
                                                <p class="card-text">{{ucfirst($mval->mapping_type_data_value)}}</p>
                                            </div>
                                            <?php } ?>
                                            <div class="tab-pane fade" id="second" role="tabpanel"
                                                 aria-labelledby="second-tab">
                                   <span>
                                    </span>
                                                <div class="px-1 py-1">

                                                    <div class="row d-flex justify-content-between">
                                                        <div class="col-9">

                                                        <?php
                                                        $structure = array();
                                                        if (count($slots) == 0) {
                                                            echo "<h5>No Slots available</h5>";
                                                        }
                                                        foreach ($slots as $skey => $sval) {
                                                            //if(($sval->booking_date>=date('d-m-Y')) && ($sval->booking_start_time > date('H:i'))){
                                                            if (($sval->booking_date == date('d-m-Y')) && ($sval->booking_start_time <= date('H:i'))) {
                                                                //should not be add
                                                            } else {
                                                                $structure[$sval->hospital_id]['hospital'] = $sval->hospital_name;
                                                                $structure[$sval->hospital_id]['values'][$sval->screen_id][$sval->booking_date][$sval->shift][] = array(
                                                                    'time' => $sval->booking_time_long,
                                                                    'type' => $sval->available_types,
                                                                    'slotid' => $sval->slotid,
                                                                    'time_start' => $sval->booking_start_time
                                                                );
                                                            }
                                                        }


                                                        ?>

                                                        <!--<pre><?php // print_r($structure); ?></pre> -->


                                                            <!--- - Collapse --->
                                                            <div id="accordion">
                                                                <?php


                                                                foreach ($structure as $str_key => $str_val) {                    ?>
                                                                <div class="card">
                                                                    <div class="card-header"
                                                                         id="headinghospital{{$str_key}}"
                                                                         style="padding:0px">
                                                                        <h5 style="height:20px;"><a
                                                                                style="font-size:12px;font-weight:bold"
                                                                                class="btn btn-link"
                                                                                data-toggle="collapse"
                                                                                data-target="#collapsehospital{{$str_key}}"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapsehospital{{$str_key}}">
                                                                                {{ucfirst($str_val['hospital'])}}
                                                                            </a></h5>

                                                                    </div>

                                                                    <div id="collapsehospital{{$str_key}}"
                                                                         class="collapse"
                                                                         aria-labelledby="headinghospital{{$str_key}}"
                                                                         data-parent="#accordion">
                                                                        <div class="card-body"
                                                                             style="height:300px;overflow-y:scroll">
                                                                            @foreach($str_val['values'] as  $vkey=>$vval)
                                                                                <div class="row">
                                                                                <!--<h6>{{$vkey}}</h6>-->
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        @foreach($vval as  $datekey=>$dateval)
                                                                                            <div class="row"
                                                                                                 style="background:#214214;color:#fff">
                                                                                                <div class="col-12"
                                                                                                     style="font-size:12px;font-weight:bold;text-align:center">
                                                                                                    {{ucfirst($datekey)}}
                                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo date('l', strtotime($datekey)); ?>
                                                                                                    )
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                @foreach($dateval as  $shiftkey=>$shiftval)
                                                                                                    <div class="col-4"
                                                                                                         style="padding:0px">
                                                                                                        <div
                                                                                                            class="card"
                                                                                                            style="margin-bottom:1px">
                                                                                                            <div
                                                                                                                class="card-header"
                                                                                                                style="padding:0px;text-align:center;font-size:12px;font-weight:bold;background:#21421">{{ucfirst($shiftkey)}}</div>
                                                                                                            <div
                                                                                                                class="card-body"
                                                                                                                style="padding:0px">
                                                                                                                @foreach($shiftval as $timekey=>$timeval)

                                                                                                                    <?php  $separteid = $timeval['slotid'] . "_" . str_replace(',', 'COMMA', $timeval['type']) . "_" . encodeTime($timeval['time']) . "_" . $vkey . "_" . str_replace('-', 'HYPHEN', $datekey) . "_" . $str_key; ?>
                                                                                                                    <a id="{{$separteid}}"
                                                                                                                       action="#"
                                                                                                                       class="badge bookme"
                                                                                                                       style="font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px;cursor:pointer">{{$timeval['time_start']}}

                                                                                                                    </a>

                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endforeach


                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php            }    //print_r($structure);                        ?>
                                                            </div>
                                                            <!--- - end Collapse --->


                                                        </div>

                                                        <div class="col-3">
                                                            <?php if (count($slots) > 0) { ?>
                                                            <form name="bookappointment" id="bookappointment"
                                                                  method="post" action="/book-appointment">
                                                                @csrf
                                                                <div class="row">
                                                                    <input type="hidden" id="docid" name="docid"
                                                                           value="{{$doctordata['doctorcode'] ?? ''}}"/>
                                                                    <input type="hidden" id="cid" name="cid" value=""/>
                                                                    <input type="hidden" id="hid" name="hid" value=""/>

                                                                    <input type="hidden" id="fullpath" name="fullpath"
                                                                           value=""/>
                                                                    <input type="hidden" id="ctypes" name="ctypes"
                                                                           value=""/>
                                                                    <input type="hidden" id="allctypes" name="allctypes"
                                                                           value="{{$allctypes}}"/>

                                                                    <div id="displaydetails"></div>
                                                                </div>


                                                                <div class="row bookhide" style="display:none">
                                                                    <div class="selopt"></div>
                                                                    <br/><br/><br/>
                                                                </div>
                                                                <div class="row bookhide" style="display:none">
                                                                    <button type="submit" class="btn btn-primary ml-0">
                                                                        Book an Appointment
                                                                    </button>

                                                                </div>
                                                            </form>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END TABS DIV -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            //"11COLON30SPACEAMHYPHEN11COLON45SPACEAM"
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
