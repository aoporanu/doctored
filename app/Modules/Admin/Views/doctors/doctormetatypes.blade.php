@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Doctor Metatypes</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_doctormetatype'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create Doctor Meta Type 
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow">
            <thead>
                <tr>
                    <th>Doctor Meta Name</th>
                    <th>Doctor Meta key</th>
                    <th>Language Code</th>
                    <th>Doctor Meta Icon</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($metatypes as $type)
                <tr class="gradeA">
                    <td> {{ucwords($type->dmetaname)}}</td>                
                    <td>{{ucwords($type->dmetakey)}}</td>
                    <td>{{$type->dmeta_lang_code}}</td>
                    <td>{{$type->dmeta_icon}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_doctormetatype/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$type->dmeta_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_doctormetatype/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$type->dmeta_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && (isset($type->is_lock) && $type->is_lock == 0) && $type->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$type->dmeta_id}}" {{$type->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($type->is_lock) && $type->is_lock == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                            @if(isset($accessDetails) && $accessDetails->delete_access)
                            <a href="/admin/delete_doctormetatype/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$type->dmeta_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
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