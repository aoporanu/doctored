@extends('Admin::layouts.admin')
@section('content')
<h3>View Consultation Types</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">

        <div class="form-group  row">
            <label class="col-md-2"><strong>Consultation Type Name: </strong></label>
            <div class="col-md-9">

                {{isset($consultationtypes->ctype_name) ? $consultationtypes->ctype_name : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Consultation Type Icon :</strong></label>
            <div class="col-md-9">
                {{isset($consultationtypes->ctype_icon) ? $consultationtypes->ctype_icon : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Consultation Type Description: </strong></label>
            <div class="col-md-9">
                {{isset($consultationtypes->ctype_descrption) ? $consultationtypes->ctype_descrption : ''}}
            </div>
        </div>

        <div class="form-group form-material row">
            <div class="col-md-9">
                <button type="button" onclick="window.location.href='/admin/edit_consultation/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$consultationtypes->ctype_id)}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                <button type="button" onclick="window.location.href = '/admin/consultationtypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
            </div>
        </div>

    </div>

</div>
@endsection