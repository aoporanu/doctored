@extends('Admin::layouts.admin')
@section('content')
<h3>View Group Meta Types</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">

        <div class="form-group  row">
            <label class="col-md-2"><strong>Group Meta Name: </strong></label>
            <div class="col-md-9">

                {{isset($metatypes->gmetaname) ? $metatypes->gmetaname : ''}}
            </div>
        </div>


        <div class="form-group  row">
            <label class="col-md-2"><strong> Group Meta key :</strong></label>
            <div class="col-md-9">
                {{isset($metatypes->gmetakey) ? $metatypes->gmetakey : ''}}
            </div>
        </div>




        <div class="form-group  row">
            <label class="col-md-2"><strong> Language Code:</strong></label>
            <div class="col-md-9">
                {{isset($metatypes->gmeta_lang_code) ? $metatypes->gmeta_lang_code : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Group Meta Icon: </strong></label>
            <div class="col-md-9">

                {{isset($metatypes->gmeta_icon) ? $metatypes->gmeta_icon : ''}}
            </div>
        </div>


        <div class="form-group form-material row">
            <div class="col-md-9">
                <button type="button" onclick="window.location.href='/admin/edit_groupmetatype/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$metatypes->gmeta_id)}}}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                <button type="button" onclick="window.location.href='/admin/settings/groupmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
            </div>
        </div>

    </div>

</div>
@endsection