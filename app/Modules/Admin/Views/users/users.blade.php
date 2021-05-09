@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Users</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_user'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create User 
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0" >
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usersList as $user)
                <tr class="gradeA">
                    <td>  {{$user->user_name}}</td>
                    <td> {{$user->email}}</td>
                    <td> {{$user->is_active == 1 ? 'Active' : 'In-Active'}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access == 1 && $user->is_active == 1)
                        <a href="/admin/edit_user/{{\App\Http\Middleware\EncryptUrlParams::encrypt($user->user_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @else
                        <i class="icon md-edit" aria-hidden="true"></i>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access == 1)
                        <a href="/admin/edit_user/{{\App\Http\Middleware\EncryptUrlParams::encrypt($user->user_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @else
                        <i class="icon md-eye" aria-hidden="true"></i>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && $user->is_lock == 0 && $user->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$user->user_id}}" {{$user->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($role->is_lock) && $role->is_lock == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                            @if(isset($accessDetails) && $accessDetails->delete_access == 1 && isset($user->is_lock) && $user->is_lock == 0)
                            <a href="/admin/delete_user/{{\App\Http\Middleware\EncryptUrlParams::encrypt($user->user_id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
{{isset($usersList) && $usersList instanceof \Illuminate\Pagination\LengthAwarePaginator ? $usersList->links() : ''}}
</div>
    </div>
</div>
<!-- <h2>Users</h2>
<table border="1px solid">
    <tr><th>User Name</th><th>Email</th><th>Edit</th><th>Delete</th></tr>
    @foreach($usersList as $user)
    <tr>
        <td>
            {{$user->user_name}}
        </td>
        <td>
            {{$user->email}}
        </td>
        <td>
            <a class="animsition-link" href="/admin/edit_user/{{\App\Http\Middleware\EncryptUrlParams::encrypt($user->user_id)}}"><span class="site-menu-title">Edit</span></a>
        </td>
        <td>
            <a class="animsition-link" href="/admin/delete_user?user_id={{\App\Http\Middleware\EncryptUrlParams::encrypt($user->user_id)}}"><span class="site-menu-title">Delete</span></a>
        </td>
    </tr>
    @endforeach
</table>
<a href="/admin/create_user">Create User</a> -->
@endsection