@extends('Admin::layouts.admin')
@section('content')
<h3>View API Configurations</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">

        <div class="form-group  row">
            <label class="col-md-2"><strong>Request Type: </strong></label>
            <div class="col-md-9">

                {{isset($configurations->request_type) ? $configurations->request_type : ''}}

            </div>
        </div>


        <div class="form-group  row">
            <label class="col-md-2"><strong> Environment :</strong></label>
            <div class="col-md-9">
                {{isset($configurations->environment) ? $configurations->environment : ''}}

            </div>
        </div>




        <div class="form-group  row">
            <label class="col-md-2"><strong> API Type:</strong></label>
            <div class="col-md-9">
                {{isset($configurations->api_type) ? $configurations->api_type : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>API URL: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->api_url) ? $configurations->api_url : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>API Key: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->api_key) ? $configurations->api_key : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>API Token: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->api_token) ? $configurations->api_token : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Username: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->username) ? $configurations->username : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Password: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->password) ? $configurations->password : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Param1 key: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->param1_key) ? $configurations->param1_key : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Param1 value: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->param1_value) ? $configurations->param1_value : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Param2 key: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->param2_key) ? $configurations->param2_key : ''}}
            </div>
        </div>

        <div class="form-group  row">
            <label class="col-md-2"><strong>Param2 value: </strong></label>
            <div class="col-md-9">
                {{isset($configurations->param2_value) ? $configurations->param2_value : ''}}
            </div>
        </div>



        <div class="form-group form-material row">
            <div class="col-md-9">
                <button type="button" onclick="window.location.href='/admin/edit_apiconfigurations/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$configurations->id)}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                <button type="button" onclick="window.location.href = '/admin/settings/apiconfigurations'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
            </div>
        </div>

    </div>

</div>

@endsection