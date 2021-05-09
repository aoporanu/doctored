@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">View Roles</h3>
<br/>
<div class="panel">
                <div class="example-wrap panel-body container-fluid">
        
                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Role Name:  </strong></label>
                        <div class="col-md-9">
                       {{isset($role) ? $role->role_name : ''}}
                         
                        </div>
                      </div>

                      <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>MENUS</th>
            <th>CREATE</th>
            <th>EDIT</th>
            <th>VIEW</th>
            <th>DELETE</th>
            @if($limited_access == 'All')<th>LIMITED TO</th>@endif
        </tr>
        @if(isset($role_mapping))
        <?php // echo "<pre>";print_R($role);print_r($role_mapping); ?>
        @endif
        @foreach($menus as $key => $menu)
        <tr>
            <td>{{$menu->menu_name}}</td>
            @if($limited_access == 'All')
            @if(isset($role_mapping[$menu->menu_id]))
            <!----{{$role_mapping[$menu->menu_id]['edit_access'] === true}}---->
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][create]" @if(isset($role_mapping[$menu->menu_id]['create_access']) && $role_mapping[$menu->menu_id]['create_access'] === true) checked @endif /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][edit]" @if(isset($role_mapping[$menu->menu_id]['edit_access']) && $role_mapping[$menu->menu_id]['edit_access'] === true) checked @endif  /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][view]" @if(isset($role_mapping[$menu->menu_id]['view_access']) && $role_mapping[$menu->menu_id]['view_access'] === true) checked @endif /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][delete]" @if(isset($role_mapping[$menu->menu_id]['delete_access']) && $role_mapping[$menu->menu_id]['delete_access'] === true) checked @endif /></td>
            @else
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][create]" /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][edit]" /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][view]" /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][delete]" /></td>
            @endif
            @else
            @if(isset($role_mapping[$menu->menu_id]))
            <!----{{$role_mapping[$menu->menu_id]['edit_access'] === true}}---->
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][create]" 
                       @if(isset($role_mapping[$menu->menu_id]['create_access']) && $role_mapping[$menu->menu_id]['create_access'] === true) checked @endif 
                @if(isset($menu->create_access) && $menu->create_access == true)) '' @else disabled="disabled" @endif  
                /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][edit]" 
                       @if(isset($role_mapping[$menu->menu_id]['edit_access']) && $role_mapping[$menu->menu_id]['edit_access'] === true) checked @endif  
                @if(isset($menu->edit_access) && $menu->edit_access == true)) '' @else disabled="disabled" @endif/></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][view]" @if(isset($role_mapping[$menu->menu_id]['view_access']) && $role_mapping[$menu->menu_id]['view_access'] === true) checked @endif /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][delete]" @if(isset($role_mapping[$menu->menu_id]['delete_access']) && $role_mapping[$menu->menu_id]['delete_access'] === true) checked @endif /></td>
            @else
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][create]"
                       @if(isset($menu->create_access) && $menu->create_access == true)) '' @else disabled="disabled" @endif /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][edit]" 
                       @if(isset($menu->edit_access) && $menu->edit_access == true)) '' @else disabled="disabled" @endif /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][view]" 
                       @if(isset($menu->view_access) && $menu->view_access == true)) '' @else disabled="disabled" @endif /></td>
            <td><input type="checkbox" disabled name="accessDetails[{{$menu->menu_id}}][delete]" 
                       @if(isset($menu->delete_access) && $menu->delete_access == true)) '' @else disabled="disabled" @endif /></td>
            @endif
            @endif
            @if($limited_access == 'All')
            <td>
                <select disabled name="accessDetails[{{$menu->menu_id}}][limited_to]"  class="form-control">
                    @foreach($limit_options as $option)
                    <option @if(isset($role_mapping[$menu->menu_id]['limited_to']) && $role_mapping[$menu->menu_id]['limited_to'] === $option) selected @endif>{{$option}}</option>
                    @endforeach
                </select>
            </td>
            @endif
        </tr>
        @endforeach
    </table><br/><br/>

                    
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button"  onclick="window.location.href='/admin/edit_role?role_id={{$role->role_id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/roles'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
               
                  </div>
                  </div>
@endsection