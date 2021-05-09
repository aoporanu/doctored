@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit API Configurations</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_apiconfiguration" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong>Request Type: </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="id" value="{{isset($configurations->id) ? $configurations->id : 0}}" />

  <!--<input name="request_type" class="form-control" id="request_type" value="{{isset($configurations->request_type) ? $configurations->request_type : ''}}"/>-->
                    <select name="request_type" class="form-control  @error('request_type') is-invalid @enderror" id="request_type">
                        <option value="">Please select</option>

                        <option value="REST" {{ (isset($configurations->request_type) && $configurations->request_type=="REST")? "selected" : "" }}>REST</option>
                        <option value="SOAP" {{ (isset($configurations->request_type) && $configurations->request_type=="SOAP")? "selected" : "" }}>SOAP</option>

                    </select>
                    @error('request_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror  
                </div>
            </div>


            <div class="form-group  row">
                <label class="col-md-2"><strong> Environment :</strong></label>
                <div class="col-md-9">
                <!--<input name="environment" class="form-control" id="environment" value="{{isset($configurations->environment) ? $configurations->environment : ''}}"/>-->
                    <select name="environment" class="form-control @error('environment') is-invalid @enderror" id="environment">
                        <option value="">Please select</option>

                        <option value="Development" {{ (isset($configurations->environment) && $configurations->environment=="Development")? "selected" : "" }}>Development</option>
                        <option value="UAT" {{ (isset($configurations->environment) && $configurations->environment=="UAT")? "selected" : "" }}>UAT</option>
                        <option value="Production" {{ (isset($configurations->environment) && $configurations->environment=="Production")? "selected" : "" }}>Production</option>

                    </select>
                    @error('request_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror  

                </div>
            </div>




            <div class="form-group  row">
                <label class="col-md-2"><strong> API Type:</strong></label>
                <div class="col-md-9">
                <!--<input name="api_type" class="form-control" id="api_type" value="{{isset($configurations->api_type) ? $configurations->api_type : ''}}" />-->
                    <select name="api_type" class="form-control @error('api_type') is-invalid @enderror" id="api_type">
                        <option value="">Please select</option>

                        <option value="GET" {{ (isset($configurations->api_type) && $configurations->api_type=="GET")? "selected" : "" }}>GET</option>
                        <option value="POST" {{ (isset($configurations->api_type) && $configurations->api_type=="POST")? "selected" : "" }}>POST</option>
                        <option value="PUT" {{ (isset($configurations->api_type) && $configurations->api_type=="PUT")? "selected" : "" }}>PUT</option>

                    </select>
                    @error('api_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror  
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>API URL: </strong></label>
                <div class="col-md-9">
                    <input name="api_url" class="form-control @error('api_url') is-invalid @enderror" id="api_url" value="{{isset($configurations->api_url) ? $configurations->api_url : ''}}" />
                    @error('api_url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror  
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>API Key: </strong></label>
                <div class="col-md-9">
                    <input name="api_key" class="form-control @error('api_key') is-invalid @enderror" id="api_key" value="{{isset($configurations->api_key) ? $configurations->api_key : ''}}" />
                    @error('api_key')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror  
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>API Token: </strong></label>
                <div class="col-md-9">
                    <input name="api_token" class="form-control @error('api_token') is-invalid @enderror" id="api_token" value="{{isset($configurations->api_token) ? $configurations->api_token : ''}}" />
                    @error('api_token')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Username: </strong></label>
                <div class="col-md-9">
                    <input name="username" class="form-control  @error('username') is-invalid @enderror" id="username" value="{{isset($configurations->username) ? $configurations->username : ''}}" />
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Password: </strong></label>
                <div class="col-md-9">
                    <input name="password"  type="password" class="form-control  @error('password') is-invalid @enderror" id="password" value="{{isset($configurations->password) ? $configurations->password : ''}}" />
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Param1 key: </strong></label>
                <div class="col-md-9">
                    <input name="param1_key" class="form-control" id="param1_key" value="{{isset($configurations->param1_key) ? $configurations->param1_key : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Param1 value: </strong></label>
                <div class="col-md-9">
                    <input name="param1_value" class="form-control" id="param1_value" value="{{isset($configurations->param1_value) ? $configurations->param1_value : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Param2 key: </strong></label>
                <div class="col-md-9">
                    <input name="param2_key" class="form-control" id="param2_key" value="{{isset($configurations->param2_key) ? $configurations->param2_key : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Param2 value: </strong></label>
                <div class="col-md-9">
                    <input name="param2_value" class="form-control" id="param2_value" value="{{isset($configurations->param2_value) ? $configurations->param2_value : ''}}" />
                </div>
            </div>



            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/settings/apiconfigurations'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>

</div>

@endsection