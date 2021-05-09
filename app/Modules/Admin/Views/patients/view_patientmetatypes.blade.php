@extends('Admin::layouts.admin')
@section('content')
<h3>View Patient Meta Types</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">

        <div class="form-group  row">
            <label class="col-md-2"><strong>Patient Meta Name: </strong></label>
            <div class="col-md-9">


                {{isset($metatypes->pmetaname) ? $metatypes->pmetaname : ''}}
            </div>
        </div>


        <div class="form-group  row">
            <label class="col-md-2"><strong> Patient Meta key :</strong></label>
            <div class="col-md-9">
                {{isset($metatypes->pmetakey) ? $metatypes->pmetakey : ''}}
            </div>
        </div>




        <div class="form-group  row">
            <label class="col-md-2"><strong> Patient Meta Lang Code:</strong></label>
            <div class="col-md-9">
                {{isset($metatypes->pmeta_lang_code) ? $metatypes->pmeta_lang_code : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Patient Meta Icon: </strong></label>
            <div class="col-md-9">

                {{isset($metatypes->pmeta_icon) ? $metatypes->pmeta_icon : ''}}
            </div>
        </div>


        <div class="form-group form-material row">
            <div class="col-md-9">
                <button type="button" onclick="window.location.href='/admin/edit_patientmetatype?pmeta_id={{$metatypes->pmeta_id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                <button type="button" onclick="window.location.href = '/admin/settings/patientsmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
            </div>
        </div>

    </div>

</div>
@endsection