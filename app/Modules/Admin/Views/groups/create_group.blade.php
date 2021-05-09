@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">Create/Edit Groups</h3><br/>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_group" id="admin_group_form" method="post" enctype="multipart/form-data">
            <fieldset><div class="form-group row">
                    <label class="col-md-2"><strong> Group Name:  </strong></label>
                    <div class="col-md-9">
                        <input type="hidden" name="group_id" value="{{isset($group_details) ? $group_details->group_id : 0}}" />
                        <input name="group_name" id="group_name" class="form-control" value="{{isset($group_details) ? $group_details->group_name : old('group_name')}}" />
                        @error('group_name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-md-2"><strong>Logo:</strong></label>
                    <div class="col-md-2">
                        <input type="file" name="logo" id="logo" multiple="">
                    </div>
                    @if (isset($group_details->logo))
                    <div class="col-md-2">
                        <img height="100%" width="100%" src="../../uploads/{{$group_details->logo}}">
                    </div>
                    @endif
                </div>


                <div class="form-group  row">
                    <label class="col-md-2"><strong>Banner:</strong></label>
                    <div class="col-md-2">

                        <input type="file" name="banner" id="banner" multiple="">
                    </div>
                    @if (isset($group_details->banner))
                    <div class="col-md-2">
                        <img height="100%" width="100%" src="../../uploads/{{$group_details->banner}}">
                    </div>
                    @endif
                </div>

                <div class="form-group  row">
                    <label class="col-md-2"><strong> Group Description:  </strong></label>
                    <div class="col-md-9">
                        <textarea name="group_description" id="group_description" class="form-control">{{isset($group_details) ? $group_details->group_description : old('group_description')}}</textarea>
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-md-2"><strong> Business Name:  </strong></label>
                    <div class="col-md-9">
                        <input name="group_business_name" id="group_business_name" class="form-control" value="{{isset($group_details) ? $group_details->group_business_name : old('group_business_name')}}" />
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-md-2"><strong> Address:  </strong></label>
                    <div class="col-md-3">
                        <!-- <input name="address" id="address" class="form-control" value="{{isset($group_details) ? $group_details->address : ''}}" /> -->
                        <input type="text" id="searchInMap" name="address" class="form-control"  placeholder="Enter a location" value="{{isset($group_details) ? $group_details->address : old('address')}}"/>
                    </div>
                    <div class="col-md-2">
                        <!-- <input name="address" id="address" class="form-control" value="{{isset($group_details) ? $group_details->address : ''}}" /> -->
                        <input type="text" id="PlaceName" name="address_place" class="form-control" value="{{isset($group_details) ? $group_details->address_place : old('address_place')}}"/>
                    </div>
                    <div class="col-md-2">

                        <input type="text" id="cityLat" name="address_lat" class="form-control" value="{{isset($group_details) ? $group_details->address_lat : old('address_lat')}}"/>
                    </div>
                    <div class="col-md-2">

                        <input type="text" id="cityLng" name="address_long" class="form-control" value="{{isset($group_details) ? $group_details->address_long : old('address_long')}}"/> 
                    </div>
                </div>
                <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9ZxHaV_cEegOJfb8FnF_qcNUPIMDQ0A&libraries=places"></script>
                <script type="text/javascript">
google.maps.event.addDomListener(window, 'load', function () {
    var places = new google.maps.places.Autocomplete(document.getElementById('searchInMap'));
    google.maps.event.addListener(places, 'place_changed', function () {
        var place = places.getPlace();
        var address = place.formatted_address;
        /*    var latitude = place.geometry.location.A;
         var longitude = place.geometry.location.F;*/
        document.getElementById('PlaceName').value = address;
        document.getElementById('cityLat').value = place.geometry.location.lat();
        document.getElementById('cityLng').value = place.geometry.location.lng();

    });
});
                </script>
                <!-- End Maps related code -->


                <div class="form-group  row">
                    <label class="col-md-2"><strong> Phone:  </strong></label>
                    <div class="col-md-3">
                        <select class="phonecode pc form-control" name="phonecode" data-value="{{ isset($phoneCode) ? $phoneCode : old('phonecode')}}"> </select>
                    </div>
                    <div class="col-md-6">
                        <input name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{isset($group_details) ? $group_details->phone : old('phone')}}" />
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-md-2"><strong> Email:  </strong></label>
                    <div class="col-md-9">
                        <input name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{isset($group_details) ? $group_details->email : old('email')}}" />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-md-2"><strong> Licence:  </strong></label>
                    <div class="col-md-9">
                        <input name="licence" id="licence" class="form-control @error('licence') is-invalid @enderror" value="{{isset($group_details) ? $group_details->licence : old('licence')}}" />
                        @error('licence')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <h3>Mata Types</h3>
                <hr/>
                <br/>
                <!--                <div class="form-group  row">
                                    <label class="col-md-2"><strong> Mata Types:  </strong></label>
                                    <div class="col-md-9">
                                        <div class="select2-primary">-->
                <!--                            <select class="form-control" multiple="multiple" data-plugin="select2" data-placeholder="Select Meta Type" name="specialization[]">
                                                @foreach($specializations as $specialization)
                                                <option value="{{$specialization->gmeta_id}}" @if(in_array($specialization->gmeta_id, $specializationList)) selected @endif>{{$specialization->gmetaname}}</option>
                                                @endforeach    
                                            </select>-->

                <!--                        </div>
                                    </div>
                                </div>-->
                @foreach($specializations as $specialization)
                <div class="form-group  row">
                    <label class="col-md-2"><strong> {{ucwords($specialization->gmetaname)}}:  </strong></label>
                    <div class="col-md-9">
                        <input name="{{$specialization->gmetaname}}" id="{{$specialization->gmetaname}}" class="form-control" 
                               value="{{isset($metaTypeData[$specialization->gmetaname]) ? $metaTypeData[$specialization->gmetaname] : '' }}" />
                        @error($specialization->gmetaname)
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                @endforeach
                <div class="form-group form-material row">
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                        <button type="button" onclick="window.location.href = '/admin/groups'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                    </div>
                </div></fieldset>
        </form>
    </div>
</div>
@endsection
@section('jscript')
<script type="text/javascript">
    console.log('admin_group_form => ', $('#admin_group_form'));
    $(document).ready(function () {
        $('#admin_group_form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                group_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Group Name is required and can\'t be empty'
                        }
                    }
                }, email: {
                    validators: {
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    }
                },
                licence: {
                    validators: {
                        stringLength: {
                            min: 7,
                            message: 'The licence must be 7 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'The licence can only consist of alphabetical, number, dot and underscore'
                        }, remote: {
                            url: '/admin/validateLicence',
                            data: function (validator) {
                                return{
                                    module_name: 'group',
                                    licence: $('[name="licence"]').val(),
                                    id: $('[name="group_id"]').val()
                                };
                            },
                            message: 'The licence with this number is already registered'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection