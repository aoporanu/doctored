<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Redirect;
use View;
use Log;
use Session;
use Exception;
use Illuminate\Support\Facades\Validator as Validator;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use App\Modules\Admin\Models\Menus as Menus;
use App\Modules\Admin\Models\Roles as Roles;
use App\Modules\Admin\Models\Groups as Groups;
use App\Modules\Admin\Models\RoleMenuMapping as RoleMenuMapping;
use App\Modules\Admin\Models\GroupRoleMapping as GroupRoleMapping;

/**
 * Description of RolesController
 *
 * @author sandeep.jeedula
 */
class RolesController extends AdminController {

    private $_url_key = '/admin/roles';
    private $_mapping_key = 'R';

    public function roles() {
        try {
            $this->setData($this->_url_key, 'view');
            if ($this->limitedAccess == 'All') {
                $roles = Roles::orderBy('role_id', 'asc')->where('is_delete', 0);
            } else {
                $roles = $this->getRolesByGroup();
            }
            return view('Admin::roles/roles')->with(['roles' => $roles->paginate(10), 'url_key' => $this->_url_key,
                        'accessDetails' => $this->accessDetails, 'mapping_key' => $this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createRole() {
        try {
            $this->setData($this->_url_key, 'add');
            $groups = [];
            if ($this->limitedAccess == 'All') {
                $limitOptions = ['Own', 'All'];
                $menus = Menus::orderBy('sort_order', 'asc')->get()->all();
                $groups = Groups::orderBy('group_id', 'asc')->get()->all();
            } else {
                $menus = [];
                $limitOptions = ['Own'];
                $menuList = $this->getMenusByGroup()->all();
                foreach ($menuList as $menuData) {
                    if (($menuData->create_access) || $menuData->edit_access || $menuData->view_access ||
                            $menuData->delete_access) {
                        $menus[$menuData->menu_id] = $menuData;
                    }
                }
            }
            return view('Admin::roles/create_role')->with(['menus' => $menus,
                        'limit_options' => $limitOptions,
                        'limited_access' => $this->limitedAccess,
                        'groups' => $groups]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addRole(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            if ($request->isMethod('post')) {
//                $validator = Validator::make($request->all(), ['role_name' => 'required']);
//                if ($validator->fails()) {
//                    return Redirect::back()->withErrors($validator);
//                }
                try {
                    $request->validate([
                        'role_name' => 'required|unique:roles,role_name,' . $request->role_id . ',role_id'
                    ], [
                        'role_name.required' => 'Role name is reqiured',
                        'role_name.unique' => 'Role name is already created please use different name'
                    ]);
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::error($e->getMessage());
                    Log::error($e->getTraceAsString());
                    return Redirect::back()->withErrors($e->errors())->withInput();
                }
                $requestParams = $this->filterParameters($request->all());
                if (!$this->roleId) {
                    $this->roleId = Session::get('role_id');
                }
                if ($this->init() === false) {
                    return Redirect::to('admin/login');
                }
                $successMessage = 'Added suceessfully';
                $roleId = isset($requestParams['role_id']) ? $requestParams['role_id'] : 0;
                if ($roleId != 0) {
                    $roleDetails = Roles::where('role_id', $roleId)->where('is_delete', 0)->first();
                    $roleDetails->role_name = $request->role_name;
                    $roleDetails->save();
                    $successMessage = 'Updated suceessfully';
                } else {
                    $roleData = new Roles();
                    $roleData->role_name = $request->role_name;
                    $roleData->save();
                    $roleId = $roleData->role_id;
                }

                $accessDetails = $request->accessDetails;
                if (is_array($accessDetails)) {
                    foreach ($accessDetails as $menuId => $access) {
                        $roleMenuMapping = RoleMenuMapping::whereRaw('role_id = ' . $roleId . ' and menu_id = ' . $menuId)->first();
                        if (!$roleMenuMapping) {
                            $roleMenuMapping = new RoleMenuMapping;
                        }
                        $roleMenuMapping->role_id = $roleId;
                        $roleMenuMapping->menu_id = $menuId;
                        if ($this->roleId != 1)
                            $roleMenuMapping->user_id = $this->userId;
                        else
                            $roleMenuMapping->user_id = 0;
                        $roleMenuMapping->create_access = isset($access['create']) ? 1 : 0;
                        $roleMenuMapping->edit_access = isset($access['edit']) ? 1 : 0;
                        $roleMenuMapping->view_access = isset($access['view']) ? 1 : 0;
                        $roleMenuMapping->activate_access = isset($access['activate']) ? 1 : 0;
                        $roleMenuMapping->delete_access = isset($access['delete']) ? 1 : 0;
                        $roleMenuMapping->limited_to = isset($access['limited_to']) ? $access['limited_to'] : 'Own';
                        try {
                            $roleMenuMapping->save();
                        } catch (Exception $ex) {
                            Log::error($ex->getMessage());
                            Log::error($ex->getTraceAsString());
                            return Redirect::back()->with('error', $ex->getMessage());
                        } catch (ErrorException $ex) {
                            Log::error($ex->getMessage());
                            Log::error($ex->getTraceAsString());
                            return Redirect::back()->with('error', $ex->getMessage());
                        }
                    }
                }
            }
            return Redirect::to('admin/roles')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editRole($roleId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $roleIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($roleId);
            $role_id = str_replace($this->_mapping_key, '', $roleIdData);
            $role = Roles::where('role_id', $role_id)->where('is_delete', 0)->first();
            $roleMenuMapping = new RoleMenuMapping;
            $roleDetails = $roleMenuMapping::where('role_id', $role_id)->get()->all();
            $roleDetailMapping = $this->mapRoleMenus($roleDetails);
            if ($this->limitedAccess == 'All') {
                $limitOptions = ['Own', 'All'];
                $menus = Menus::where('is_delete', 0)->orderBy('sort_order', 'asc')->get()->all();
            } else {
                $menus = [];
                $limitOptions = ['Own'];
                $menuList = $this->getMenusByGroup()->all();
                foreach ($menuList as $menuData) {
                    if (($menuData->create_access) || $menuData->edit_access || $menuData->view_access ||
                            $menuData->delete_access) {
                        $menus[$menuData->menu_id] = $menuData;
                    }
                }
            }
            $groups = [];
            if ($this->limitedAccess == 'All') {
                $limitOptions = ['Own', 'All'];
                $menus = Menus::orderBy('sort_order', 'asc')->get()->all();
                $groups = Groups::orderBy('group_id', 'asc')->get()->all();
            } else {
                $menus = [];
                $limitOptions = ['Own'];
                $menuList = $this->getMenusByGroup()->all();
                foreach ($menuList as $menuData) {
                    if (($menuData->create_access) || $menuData->edit_access || $menuData->view_access ||
                            $menuData->delete_access) {
                        $menus[$menuData->menu_id] = $menuData;
                    }
                }
            }
            $limitOptions = ['Own', 'All'];
            return view('Admin::roles/create_role')->with(['menus' => $menus, 'limit_options' => $limitOptions, 'role' => $role, 'groups' => $groups,
                        'role_mapping' => $roleDetailMapping, 'limited_access' => $this->limitedAccess]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteRole($roleId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $roleIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($roleId);
            $role_id = str_replace($this->_mapping_key, '', $roleIdData);
            if ($role_id) {
                $roleDetails = Roles::where('role_id', $role_id)->where('is_delete', 0)->first();
                $roleDetails->is_delete = 1;
                $roleDetails->save();
                return Redirect::to('admin/roles/');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewRole($roleId) {
        try {
            $this->setData($this->_url_key, 'view');
            $roleIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($roleId);
            $role_id = str_replace($this->_mapping_key, '', $roleIdData);
            $role = Roles::where('role_id', $role_id)->where('is_delete', 0)->first();
            $roleMenuMapping = new RoleMenuMapping;
            $roleDetails = $roleMenuMapping::where('role_id', $role_id)->where('is_delete', 0)->get()->all();
            $roleDetailMapping = $this->mapRoleMenus($roleDetails);
            if ($this->limitedAccess == 'All') {
                $limitOptions = ['Own', 'All'];
                $menus = Menus::where('is_delete', 0)->orderBy('sort_order', 'asc')->get()->all();
            } else {
                $menus = [];
                $limitOptions = ['Own'];
                $menuList = $this->getMenusByGroup()->all();
                foreach ($menuList as $menuData) {
                    if (($menuData->create_access) || $menuData->edit_access || $menuData->view_access ||
                            $menuData->delete_access) {
                        $menus[$menuData->menu_id] = $menuData;
                    }
                }
            }
            $groups = [];
            if ($this->limitedAccess == 'All') {
                $limitOptions = ['Own', 'All'];
                $menus = Menus::orderBy('sort_order', 'asc')->get()->all();
                $groups = Groups::orderBy('group_id', 'asc')->get()->all();
            } else {
                $menus = [];
                $limitOptions = ['Own'];
                $menuList = $this->getMenusByGroup()->all();
                foreach ($menuList as $menuData) {
                    if (($menuData->create_access) || $menuData->edit_access || $menuData->view_access ||
                            $menuData->delete_access) {
                        $menus[$menuData->menu_id] = $menuData;
                    }
                }
            }
            $limitOptions = ['Own', 'All'];
            return view('Admin::roles/view_role')->with(['menus' => $menus, 'limit_options' => $limitOptions, 'role' => $role, 'groups' => $groups,
                        'role_mapping' => $roleDetailMapping, 'limited_access' => $this->limitedAccess]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
