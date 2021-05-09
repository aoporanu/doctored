<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Redirect;
use View;
use Log;
use Exception;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use App\Modules\Admin\Models\Users as Users;
use App\Modules\Admin\Models\Roles as Roles;
use App\Modules\Admin\Models\Groups as Groups;
use App\Modules\Admin\Models\UserRoleMapping as UserRoleMapping;
use App\Modules\Admin\Models\GroupUserMapping as GroupUserMapping;
use App\Modules\Admin\Models\GroupRoleMapping as GroupRoleMapping;
use App\Modules\Admin\Models\RoleMenuMapping as RoleMenuMapping;

class UserController extends AdminController {

    private $_url_key = '/admin/users';
    private $_mapping_key = 'U';

    public function users() {
        try {
            $this->setData($this->_url_key, 'view');
            if ($this->limitedAccess == 'All') {
                $users = Users::orderBy('user_id', 'asc')->where('is_delete', 0)->paginate(10);
            } else {
                $users = $this->getUsersByGroup();
            }
            return View::make('Admin::users/users')->with(['usersList' => $users, 'accessDetails' => $this->accessDetails,
                        'mapping_key' => $this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createUser() {
        try {
            $this->setData($this->_url_key, 'add');
            $groups = [];
            $menuAccess = [];
            $menuAccessDetails = $this->getAllAccessByUserData();
            if (!empty($menuAccessDetails)) {
                foreach ($menuAccessDetails as $accessDetails) {
                    if (!$accessDetails->create_access && !$accessDetails->edit_access && !$accessDetails->delete_access && !$accessDetails->view_access) {

                    } else {
                        $menuAccess[] = $accessDetails;
                    }
                }
            }
            if ($this->limitedAccess == 'All') {
                $roles = Roles::orderBy('role_id', 'asc')->where('is_active', 1)->where('is_delete', 0)->get();
                $groups = Groups::orderBy('group_id', 'asc')->where('is_active', 1)->where('is_delete', 0)->get()->all();
            } else {
                $roles = $this->getRolesByGroup();
            }
            $hospitalList = $this->getHospitalsByGroup();
            return view('Admin::users/create_user')->with(['rolesList' => $roles->all(),
                        'limited_access' => $this->limitedAccess, 'user_permissions' => $menuAccess,
                        'hospitalList' => $hospitalList, 'groups' => $groups]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addUser(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            try {
                $request->validate([
                    'user_name' => 'required',
                    'email' => 'required|unique:users,email,' . $request->user_id . ',user_id',
                    'password' => 'required'
                ], [
                    'user_name.required' => 'User Name is reqiured',
                    'email.required' => 'Email is reqiured',
                    'email.unique' => 'Email is already created please use different email',
                    'password.required' => 'Password is reqiured'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());
                return Redirect::back()->withErrors($e->errors())->withInput();
            }
            $requestParams = $this->filterParameters($request->all());
            $userId = isset($requestParams['user_id']) ? $requestParams['user_id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($userId != 0) {
                $userDetails = Users::where('user_id', $userId)->where('is_delete', 0)->first();
                $userDetails->user_name = $request->user_name;
                $userDetails->email = $request->email;
                $userDetails->password = $this->hashData($request->password);
                $userDetails->updated_by = $this->userId;
                $userDetails->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $userData = new Users();
                $userData->user_name = $request->user_name;
                $userData->email = $request->email;
                $userData->password = $this->hashData($request->password);
                $userData->created_by = $this->userId;
                $userData->save();
                $userId = $userData->user_id;
            }
            if ($userId) {
                $groupId = isset($requestParams['group_id']) ? $requestParams['group_id'] : $this->groupId;
                $groupMapping = GroupUserMapping::whereRaw('user_id = ' . $userId . ' and gid = ' . $groupId)->first();
                if (!$groupMapping) {
                    $groupMapping = new GroupUserMapping;
                    $groupMapping->user_id = $userId;
                    $groupMapping->gid = $groupId;
                    $groupMapping->created_by = $this->userId;
                    $groupMapping->save();
                } else {
                    $groupMapping->updated_by = $this->userId;
                    $groupMapping->save();
                }
            }

            if ($request->role_id) {
                $userroleMapping['user_id'] = $userId;
                $userroleMapping['role_id'] = $request->role_id;
                $userRoleDetails = UserRoleMapping::whereRaw('user_id = ' . $userId . ' and role_id = ' . $request->role_id)->first();
                if (!empty($userRoleDetails) && $userRoleDetails->user_id) {
                    $userroleMapping['updated_by'] = $this->userId;
                } else {
                    $userroleMapping['created_by'] = $this->userId;
                }
                UserRoleMapping::updateOrInsert($userroleMapping);

                $accessDetails = $request->accessDetails;
                if (is_array($accessDetails)) {
                    RoleMenuMapping::where('role_id', $request->role_id)->delete();
                    foreach ($accessDetails as $menuId => $access) {
                        $roleMenuMappingList = RoleMenuMapping::whereRaw('role_id = ' . $request->role_id . ' and menu_id = ' . $menuId)->first();

                        $roleMenuMapping = new RoleMenuMapping;
                        $roleMenuMapping->role_id = $request->role_id;
                        $roleMenuMapping->menu_id = $menuId;
                        $roleMenuMapping->create_access = isset($access['create']) ? 1 : 0;
                        $roleMenuMapping->edit_access = isset($access['edit']) ? 1 : 0;
                        $roleMenuMapping->view_access = isset($access['view']) ? 1 : 0;
                        $roleMenuMapping->delete_access = isset($access['delete']) ? 1 : 0;
                        $roleMenuMapping->limited_to = isset($access['limited_to']) ? $access['limited_to'] : 'Own';
                        try {
                            if (!empty($roleMenuMappingList)) {
                                $roleMenuMappingList->create_access = $roleMenuMapping->create_access;
                                $roleMenuMappingList->edit_access = $roleMenuMapping->edit_access;
                                $roleMenuMappingList->view_access = $roleMenuMapping->view_access;
                                $roleMenuMappingList->delete_access = $roleMenuMapping->delete_access;
                                $roleMenuMappingList->updated_by = $this->userId;
                                $roleMenuMappingList->save();
                            } else {
                                $roleMenuMapping->created_by = $this->userId;
                                $roleMenuMapping->save();
                            }
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
                } else {
                    if (!$this->limitedAccess && Session::has('limited_access')) {
                        $this->limitedAccess = Session::get('limited_access');
                    } else {
                        $this->getLimitedAccessData($this->_url_key);
                    }
                    if ($this->limitedAccess == 'All') {
                        $roleAccessDetails = RoleMenuMapping::where('role_id', $request->role_id)
//                            ->groupBy('menu_id')
                                        ->get()->all();
//                    echo "<pre>";print_R($roleAccessDetails);die;
                        if (!empty($roleAccessDetails)) {
                            foreach ($roleAccessDetails as $roleAccess) {
                                $roleAccessInfo = RoleMenuMapping::where('role_id', $request->role_id)
                                        ->where('user_id', $userId)
                                        ->where('menu_id', $roleAccess->menu_id)
//                                    ->groupBy('menu_id')
                                        ->first();
//                            echo "<pre>";print_r($roleAccessInfo);die;
                                if (empty($roleAccessInfo)) {
                                    $roleMenuMapping = new RoleMenuMapping;
                                    $roleMenuMapping->role_id = 0;
                                    $roleMenuMapping->user_id = $userId;
                                    $roleMenuMapping->menu_id = $roleAccess->menu_id;
                                    $roleMenuMapping->hospital_id = isset($request->hospital_id) ? $request->hospital_id : 0;
                                    $roleMenuMapping->create_access = $roleAccess->create_access;
                                    $roleMenuMapping->edit_access = $roleAccess->edit_access;
                                    $roleMenuMapping->view_access = $roleAccess->view_access;
                                    $roleMenuMapping->delete_access = $roleAccess->delete_access;
                                    $roleMenuMapping->limited_to = $roleAccess->limited_to;
//                                echo "<pre>";print_R($roleMenuMapping);die;
                                    $roleMenuMapping->save();
                                }
                            }
                        }
                    }
                }
            } else {
                $accessDetails = $request->accessDetails;
                if (is_array($accessDetails)) {
                    $roleDetails = $this->mapRoleMenus($this->getUserRolesByGroup($userId));
                    foreach ($accessDetails as $hospitalId => $selectedMenus) {
                        foreach ($selectedMenus as $menuId => $access) {
                            if (isset($roleDetails[$menuId])) {
                                $roleDetails[$menuId]['updated'] = 1;
                                $roleMenuMapping = RoleMenuMapping::where('menu_id', $menuId)
                                        ->where('hospital_id', $hospitalId)
                                        ->where('user_id', $userId)
                                        ->first();
                                $roleMenuMapping->updated_by = $this->userId;
                                $roleMenuMapping->create_access = isset($access['create']) && $access['create'] == 'on' ? 1 : 0;
                                $roleMenuMapping->edit_access = isset($access['edit']) && $access['edit'] == 'on' ? 1 : 0;
                                $roleMenuMapping->view_access = isset($access['view']) && $access['view'] == 'on' ? 1 : 0;
                                $roleMenuMapping->delete_access = isset($access['delete']) && $access['delete'] == 'on' ? 1 : 0;
                                $roleMenuMapping->limited_to = isset($access['limited_to']) ? $access['limited_to'] : 'Own';
                            } else {
                                $roleMenuMapping = new RoleMenuMapping;
                                $roleMenuMapping->role_id = 0;
                                $roleMenuMapping->user_id = $userId;
                                $roleMenuMapping->created_by = $this->userId;
                                $roleMenuMapping->menu_id = $menuId;
                                $roleMenuMapping->hospital_id = $hospitalId;
                                $roleMenuMapping->create_access = isset($access['create']) && $access['create'] == 'on' ? 1 : 0;
                                $roleMenuMapping->edit_access = isset($access['edit']) && $access['edit'] == 'on' ? 1 : 0;
                                $roleMenuMapping->view_access = isset($access['view']) && $access['view'] == 'on' ? 1 : 0;
                                $roleMenuMapping->delete_access = isset($access['delete']) && $access['delete'] == 'on' ? 1 : 0;
                                $roleMenuMapping->limited_to = isset($access['limited_to']) ? $access['limited_to'] : 'Own';
                            }
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
                    foreach ($roleDetails as $menuID => $roleData) {
                        if (!isset($roleData['updated'])) {
                            RoleMenuMapping::where('menu_id', $roleData['menu_id'])
                                    ->where('hospital_id', $roleData['hospital_id'])
                                    ->where('user_id', $roleData['user_id'])
                                    ->delete();
                        }
                    }
                }
                ////////
            }
            return Redirect::to('admin/users')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editUser($userId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $userIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($userId);
            $user_id = str_replace($this->_mapping_key, '', $userIdData);
            $userData = Users::where('user_id', $user_id)->where('is_delete', 0)->first();
            $userDetails = UserRoleMapping::where('user_id', $user_id)->first();
            $groupMappingDetails = GroupUserMapping::where('user_id', $user_id)->first();
            $mappedRole = 0;
            if ($userDetails) {
                $userDetails = $userDetails->toArray();
                if (isset($userDetails['role_id'])) {
                    $mappedRole = $userDetails['role_id'];
                }
            }
            $groups = [];
            if ($this->limitedAccess == 'All') {
                $roles = Roles::orderBy('role_id', 'asc')->where('is_delete', 0)->get();
                $groups = Groups::orderBy('group_id', 'asc')->where('is_delete', 0)->get()->all();
            } else {
                $roles = $this->getRolesByGroup();
            }
            $roleDetails = $this->getUserRolesByGroup($userId);
            $menuAccess = [];
            $menuAccessDetails = $this->getAllAccessByUserData();
            if (!empty($menuAccessDetails)) {
                foreach ($menuAccessDetails as $accessDetails) {
                    if (!$accessDetails->create_access && !$accessDetails->edit_access && !$accessDetails->delete_access && !$accessDetails->view_access) {

                    } else {
                        $menuAccess[] = $accessDetails;
                    }
                }
            }
            $hospitalList = $this->getHospitalsByGroup();
            $userRoleId = $this->getUserRoleId($userId);
            return view('Admin::users/create_user')->with(['userDetails' => $userData,
                        'mappedRole' => $mappedRole, 'limited_access' => $this->limitedAccess, 'user_permissions' => $menuAccess,
                        'roleDetails' => $this->mapRoleMenus($roleDetails), 'user_role_id' => $userRoleId, 'hospitalList' => $hospitalList,
                        'groups' => $groups, 'group_mapping' => $groupMappingDetails, 'rolesList' => $roles->all()]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteUser($userId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $userIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($userId);
            $user_id = str_replace($this->_mapping_key, '', $userIdData);
            $userData = Users::where('user_id', $user_id)->where('is_delete', 0)->first();
            if ($userData) {
                $userData->is_delete = 1;
                $userData->updated_by = $this->userId;
                $userData->save();
                return Redirect::back()->with('success', 'User deleted successfully');
            } else {
                return Redirect::back()->with('error', 'Unable to delete user');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
