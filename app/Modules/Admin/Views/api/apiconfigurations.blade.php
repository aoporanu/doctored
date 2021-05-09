@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Api Configurations</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_apiconfigurations'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create API Configurations 
                    </button>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0">
            <thead>
                <tr>
                    <th>Request Type</th>
                    <th>Environment</th>
                    <th>API Type</th>
                    <th>API URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($configurations as $config)
                <tr class="gradeA">
                    <td> {{$config->request_type}}</td>

                    <td>{{$config->environment}}</td>
                    <td>{{$config->api_type}}</td>
                    <td>{{$config->api_url}}</td>
                    <td>{{$config->is_active == 1 ? 'Active' : 'In-Active'}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_apiconfigurations/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$config->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_apiconfigurations/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$config->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && $config->is_lock == 0 && $config->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$config->id}}" {{$config->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($config->is_lock) && $config->is_lock == 1)
                        <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                        @if(isset($accessDetails) && $accessDetails->delete_access)
                        <a href="/admin/delete_apiconfigurations/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$config->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">

        </div>
    </div>
</div>

@endsection