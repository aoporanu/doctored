@extends('Admin::layouts.admin')
@section('content')
<form action="/admin/add_user" method="post">
    User Name: <input name="user_name" id="user_name" value="{{isset($userDetails) ? $userDetails->user_name : ''}}" />
    <input type="hidden" name="user_id" value="{{isset($userDetails) ? $userDetails->user_id : 0}}" />
    <br/>
    Email: <input name="email" id="email" value="{{isset($userDetails) ? $userDetails->email : ''}}" />
    <br/>
    Password: <input type="password" name="password" id="password" value="{{isset($userDetails) ? $userDetails->password : ''}}" />
    <br/>
    <?php // echo "<pre>";print_R($mappedRole);die; ?>
    @if($limited_access == 'All')
    Roles: <select name="role_id">
        <option value="0">Please select</option>
        @foreach($rolesList as $role)
        <option value="{{$role->role_id}}" @if(isset($mappedRole) && $mappedRole == $role->role_id) selected @endif>{{$role->role_name}}</option>
        @endforeach
    </select>
    <br/>
    
    Group: 
        <select name="group_id">
            <option value="0">Please select group</option>
            @foreach($groups as $group)
            <option value="{{$group->gid}}" @if(isset($group_mapping) && $group_mapping->gid == $group->gid) selected @endif>{{$group->group_name}}</option>
            @endforeach
        </select>
    <br/>
    @else
    Hospital Level Permissions:
    @if(!empty($user_permissions))
        <table border="1px solid">
            <tr>
            <th>Hospital</th>
                <th>Allow Access</th>
        </tr>
        @foreach($hospitalList as $hospitalData)
        <tr>
        <td>
            {{$hospitalData->hospital_name}}</td>
        <td>
            <table border="1px solid">
                <tr>
                    <th>MENU</th>
                    <th>CREATE</th>
                <th>EDIT</th>
                <th>VIEW</th>
                    <th>DELETE</th>
            </tr>
            @foreach($user_permissions as $menu)
                @if($menu->create_access && $menu->edit_access && $menu->delete_access && $menu->view_access)
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
                @endif
            @endforeach
        </table>
        </td>
        </tr>
        @endforeach
    </table>
    @endif
    <br/>
    @endif
    <button type="submit">Submit</button>
    <a href="/admin/users">Back</a>
</form>
@endsection