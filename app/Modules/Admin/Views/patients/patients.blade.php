@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Members</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    <!-- <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href='/admin/create_patientmetatype'">
                      <i class="icon md-plus" aria-hidden="true"></i> Create Patient Meta Type 
                    </button> -->
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0" >
            <thead>
                <tr>
                    <th>Patient Code</th>
                    <th>Title</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr class="gradeA">
                    <td> {{$patient->patientcode}}</td>

                    <td>{{$patient->title}}</td>
                    <td>{{$patient->firstname}}</td>
                    <td>{{$patient->lastname}}</td>
                    <td>{{$patient->email}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_member/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$patient->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_member/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$patient->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->delete_access)
                        <a href="/admin/delete_member/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$patient->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
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