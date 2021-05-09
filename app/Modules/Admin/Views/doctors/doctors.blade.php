@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Doctors</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_doctors'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create Doctor 
                    </button>
                    @endif
                    @if($role_id != 1)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/doctormap'"> Doctor Hospital Mapping 
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Specializations</th>
                    <th>Consulation Types</th>
                    <th>Language Known</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctorslist as $doc)
                <tr class="gradeA">

                    <td> {{$doc->doctorcode}} </td>

                    <td>
                        <div class="media">
                            <div class="pr-20">
                                <a class="avatar @if($doc->is_verified!=1) avatar-away @else avatar-online @endif" href="javascript:void(0)">
                                    <img src="/material/global/portraits/5.jpg" alt=""><i></i></a>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 mb-5">
                                    <span class="name">Dr.{{ucfirst($doc->firstname)}}  {{$doc->lastname}}</span>
                                </h5>
                            </div>
                        </div>
                    </td>

                    <td>{{$doc->email}}</td>
                    <td>{{App\Modules\Admin\Controllers\AdminIndexController::getDocSpecTypes($doc->id, $mappingType)}}</td>
                    <td>{{App\Modules\Admin\Controllers\AdminIndexController::getDocConstTypes($doc->id, $mappingType)}}</td>
                    <td>{{App\Modules\Admin\Controllers\AdminIndexController::getDocLanguages($doc->id, $mappingType)}}</td>
                    <td>
                        @if($doc->is_verified!=1)
                        <small class="badge badge-round badge-warning" >Pending verification</small>
                        @else
                        <small class="badge badge-round badge-info">Verified</small>

                        @endif
                        @if($doc->is_rejected==1)
                        <small class="badge badge-round badge-danger">Rejected</small>
                        @endif


                    </td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_doctors/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$doc->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_doctors/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$doc->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && isset($doc->is_lock) && $doc->is_lock == 0 && $doc->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$doc->id}}" {{$doc->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($doc->is_lock) && $doc->is_lock == 1)
                        <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                        @if(isset($accessDetails) && $accessDetails->delete_access)
                        <a href="/admin/delete_doctors/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$doc->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                        @endif
                        @endif
                        @if($doc->is_verified==0)
                        <a href="/admin/doctor/verify/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$doc->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Verify"><i class="icon md-badge-check" aria-hidden="true"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{isset($doctorslist) && $doctorslist instanceof \Illuminate\Pagination\LengthAwarePaginator ? $doctorslist->links() : ''}}
        </div>
    </div>
</div>

@endsection