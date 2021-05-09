@extends('Admin::layouts.admin')
@section('content')

<h3 class="page-title">Create/Edit User</h3><br/>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_user" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong> User Name:  </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="user_id" value="{{isset($userDetails) ? $userDetails->user_id : 0}}" />
                    <input name="user_name" id="user_name" class="form-control" value="{{isset($userDetails) ? $userDetails->user_name : ''}}" />
                    @error('user_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Email:  </strong></label>
                <div class="col-md-9">
                    <input name="email" id="email" class="form-control" value="{{isset($userDetails) ? $userDetails->email : ''}}" />
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Password:  </strong></label>
                <div class="col-md-9">

                    <input type="password" name="password" id="password" class="form-control" value="{{isset($userDetails) ? $userDetails->password : ''}}" />
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if($limited_access == 'All')
            <div class="form-group  row">
                <label class="col-md-2"><strong> Roles:  </strong></label>
                <div class="col-md-9">

                    <select name="role_id" class="form-control">
                        <option value="0">Please select</option>
                        @foreach($rolesList as $role)
                        <option value="{{$role->role_id}}" @if(isset($mappedRole) && $mappedRole == $role->role_id) selected @endif>{{$role->role_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong> Group:  </strong></label>
                <div class="col-md-9">

                    <select name="group_id" class="form-control">
                        <option value="0">Please select group</option>
                        @foreach($groups as $group)
                        <option value="{{$group->gid}}" @if(isset($group_mapping) && $group_mapping->gid == $group->gid) selected @endif>{{$group->group_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @else
            Hospital Level Permissions:
            @if(!empty($user_permissions))
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>Hospital</th>
                    <th>Allow Access</th>
                </tr>
                @foreach($hospitalList as $hospitalData)
                <tr>
                    <td>
                        {{$hospitalData->hospital_name}}</td>
                    <td>
                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <th>MENU</th>
                                <th>CREATE</th>
                                <th>EDIT</th>
                                <th>VIEW</th>
                                <th>DELETE</th>
                            </tr>
                            <?php // echo "<pre>";print_r($user_permissions);die; ?>
                            @foreach($user_permissions as $menu)
                            <!--@if($menu->create_access && $menu->edit_access && $menu->delete_access && $menu->view_access)-->
                            <tr>
                                <td>{{App\Modules\Admin\Controllers\MenusController::getMenuName($menu->menu_id)}}</td>
                                <td><input type="checkbox" name="accessDetails[{{$hospitalData->hospital_id}}][{{$menu->menu_id}}][create]"
                                           @if(isset($menu->create_access) && $menu->create_access == true)) '' @else disabled="disabled" @endif
                                    @if(isset($roleDetails[$menu->menu_id]['hospital_id']) && $roleDetails[$menu->menu_id]['hospital_id'] == $hospitalData->hospital_id
                                    && isset($roleDetails[$menu->menu_id]['create_access']) && $roleDetails[$menu->menu_id]['create_access'] === true) 
                                    checked @endif 
                                    />
                                </td>
                                <td><input type="checkbox" name="accessDetails[{{$hospitalData->hospital_id}}][{{$menu->menu_id}}][edit]" 
                                           @if(isset($menu->edit_access) && $menu->edit_access == true)) '' @else disabled="disabled" @endif 
                                    @if(isset($roleDetails[$menu->menu_id]['hospital_id']) && $roleDetails[$menu->menu_id]['hospital_id'] == $hospitalData->hospital_id
                                    && isset($roleDetails[$menu->menu_id]['edit_access']) && $roleDetails[$menu->menu_id]['edit_access'] === true) 
                                    checked @endif />
                                </td>
                                <td><input type="checkbox" name="accessDetails[{{$hospitalData->hospital_id}}][{{$menu->menu_id}}][view]" 
                                           @if(isset($menu->view_access) && $menu->view_access == true)) '' @else disabled="disabled" @endif 
                                    @if(isset($roleDetails[$menu->menu_id]['hospital_id']) && $roleDetails[$menu->menu_id]['hospital_id'] == $hospitalData->hospital_id
                                    && isset($roleDetails[$menu->menu_id]['view_access']) && $roleDetails[$menu->menu_id]['view_access'] === true) 
                                    checked @endif />
                                </td>
                                <td><input type="checkbox" name="accessDetails[{{$hospitalData->hospital_id}}][{{$menu->menu_id}}][delete]" 
                                           @if(isset($menu->delete_access) && $menu->delete_access == true)) '' @else disabled="disabled" @endif 
                                    @if(isset($roleDetails[$menu->menu_id]['hospital_id']) && $roleDetails[$menu->menu_id]['hospital_id'] == $hospitalData->hospital_id
                                    && isset($roleDetails[$menu->menu_id]['delete_access']) && $roleDetails[$menu->menu_id]['delete_access'] === true) 
                                    checked @endif />
                                </td>
                            </tr>
                            <!--@endif-->
                            @endforeach
                        </table>
                    </td>
                </tr>
                @endforeach
            </table>
            @endif
            <br/>
            @endif
            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/users'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


