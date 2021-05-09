@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Hospitals</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_hospital'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create Hospital
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0" data-plugin="dataTable">
            <thead>
                <tr>
                    <th>Hospital Code</th>
                    <th>Hospital Name</th>
                    <th>Business Name</th>
                    <th>Type</th>
                    <th>Group</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hospitalList as $hospital)
                <tr class="gradeA">
                    <td> {{$hospital->hospitalcode}}</td>
                    <td> {{$hospital->hospital_name}}</td>
                    <td> {{$hospital->hospital_business_name}}</td>
                    <td> {{$hospital->hospital_type == 'C' ? 'Clinic' : 'Hospital' }}</td>
                    <td> {{App\Modules\Admin\Controllers\AdminIndexController::getGroupByHospitalId($hospital->hospital_id)}}</td>
                    <td> {{App\Modules\Admin\Controllers\AdminIndexController::getHospitalAddress($hospital->hospital_id)}}</td>
                    <td>{{$hospital->is_active == 1 ? 'Active' : 'In-Active'}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access && $roleId != 1)
                        <a href="/admin/edit_hospital/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$hospital->hospital_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @else
                        <!--<i class="icon md-edit" aria-hidden="true"></i>-->
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_hospital/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$hospital->hospital_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && $hospital->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$hospital->hospital_id}}" {{$hospital->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($hospital->is_lock) && $hospital->is_lock == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                            @if(isset($accessDetails) && $accessDetails->delete_access && $roleId != 1)
                            <a href="/admin/delete_hospital/{{\App\Http\Middleware\EncryptUrlParams::encrypt('H'.$hospital->hospital_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                            @else
                            <!--<i class="icon md-delete" aria-hidden="true"></i>-->
                            @endif
                        @endif
                        @if($hospital->hospital_type == 'C' && $roleId == 1)
                        <a href="/admin/migrate_hospitalview/{{\App\Http\Middleware\EncryptUrlParams::encrypt('H'.$hospital->hospital_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Migrate to Hospital"><i class="icon md-swap" aria-hidden="true"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{isset($hospitalList) && $hospitalList instanceof \Illuminate\Pagination\LengthAwarePaginator ? $hospitalList->links() : ''}}
        </div>
    </div>
</div>
@endsection