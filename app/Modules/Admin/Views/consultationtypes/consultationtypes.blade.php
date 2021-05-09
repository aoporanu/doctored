@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Consultation Types</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_consultation'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create Consultation Type 
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow">
            <thead>
                <tr>
                    <th>Consultation Type Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultationtypes as $consultation)
                <tr class="gradeA">
                    <td> {{ucwords($consultation->ctype_name)}}</td>                    
                    <td>{{$consultation->ctype_descrption}}</td>
                    <td>{{$consultation->is_active == 1 ? 'Active' : 'In-Active'}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_consultation/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$consultation->ctype_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_consultation/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$consultation->ctype_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && $consultation->is_lock == 0 && $consultation->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$consultation->ctype_id}}" {{$consultation->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($consultation->is_lock) && $consultation->is_lock == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                            @if(isset($accessDetails) && $accessDetails->delete_access)
                            <a href="/admin/delete_consultation/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$consultation->ctype_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{isset($consultationtypes) && $consultationtypes instanceof \Illuminate\Pagination\LengthAwarePaginator ? $consultationtypes->links() : ''}}
        </div>
    </div>
</div>

@endsection