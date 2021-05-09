<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ApiConfiguration;
use App\Modules\Admin\Models\ConsultationMapping;
use App\Modules\Admin\Models\ConsultationTypes;
use App\Modules\Admin\Models\DoctorMetaTypes;
use App\Modules\Admin\Models\Durations;
use App\Modules\Admin\Models\GroupMetaTypes;
use App\Modules\Admin\Models\Groups;
use App\Modules\Admin\Models\GroupUserMapping as GroupUserMapping;
use App\Modules\Admin\Models\Hospitals;
use App\Modules\Admin\Models\LanguageMapping;
use App\Modules\Admin\Models\Menus as Menus;
use App\Modules\Admin\Models\MetatypeData;
use App\Modules\Admin\Models\Pages;
use App\Modules\Admin\Models\PatientMetaTypes;
use App\Modules\Admin\Models\Patients;
use App\Modules\Admin\Models\RoleMenuMapping as RoleMenuMapping;
use App\Modules\Admin\Models\Roles;
use App\Modules\Admin\Models\Specialization;
use App\Modules\Admin\Models\SpecializationMapping;
use App\Modules\Admin\Models\UserRoleMapping as UserRoleMapping;
use App\Modules\Admin\Models\Users as Users;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminIndexController extends Controller
{

    private string $limitedAccess;
    private int $groupId;
    private int $userId;
    private int $roleId;
    private $accessDetails;
    private array $adminModules = ['/admin/roles', '/admin/menus', '/admin/pages'];

    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        if (!Session::has('user_id')) {
            return false;
        }
        if (!$this->groupId) {
            $this->groupId = Session::get('group_id');
        }
        if (!$this->userId) {
            $this->userId = Session::get('user_id');
        }
        return true;
    }

    public function hashData($key)
    {
        if ($key != '') {
            return hash(env('HASH_CODE'), env('SALT') . $key);
        }
        return $key;
    }

    /**
     *
     */
    public function encryptPasswords()
    {
        try {
            $users = Users::all();
            $updatedCount = 0;
            if ($users) {
                foreach ($users as $userDetails) {
                    if (strlen($userDetails->password) != 64) {
                        $updatedCount++;
                        $userDetails->password = $this->hashData($userDetails->password);
                        $userDetails->save();
                    }
                }
                echo "Updated No of records = " . $updatedCount . "<br/>";
                echo "Completed";
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            echo $ex->getMessage();
        }
    }

    public function login()
    {
        Session::flush();
        return view('Admin::login');
    }

    public function loginSubmit(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make(
                    $request->all(),
                    [
                    'email' => 'required|email',
                    'password' => ['required']],
                    [
                        'email.required' => 'Email is required ',
                        'password.required' => 'Password is required',
                        'password.min' => 'Invalid Credentials',
                        'password.regex' => 'Invalid Credentials'
                    ]
                );
                if ($validator->fails()) {
                    //
                    return Redirect::back()->withErrors($validator);
                }
                $requestParams = $this->filterParameters($request->all());
                $email = isset($requestParams['email']) ? $requestParams['email'] : '';
                $password = isset($requestParams['password']) ? $this->hashData($requestParams['password']) : '';
                $userDetails = Users::where("email", $email)
                    ->where('password', $password)
                    ->where('is_delete', 0)
                    ->first();
                if (!empty($userDetails)) {
                    $userHospitalDetails = [];
                    $userRoleDetails = UserRoleMapping::where('user_id', $userDetails->user_id)->first();
                    if (empty($userRoleDetails)) {
                        $userHospitalDetails = RoleMenuMapping::where('user_id', $userDetails->user_id)
                            ->orderBy('hospital_id')
                            ->first();
                    }
                    $hospitalId = isset($userHospitalDetails->hospital_id) ? $userHospitalDetails->hospital_id : 0;
                    Session::put('user_id', $userDetails->user_id);
                    Session::put('role_id', isset($userRoleDetails->role_id) ? $userRoleDetails->role_id : 0);
                    Session::put('user_name', $userDetails->user_name);
                    Session::put('hospital_id', $hospitalId);
                    Session::put('profilepic', $userDetails->photo);
                    $this->userId = $userDetails->user_id;
                    $this->roleId = isset($userRoleDetails->role_id) ? $userRoleDetails->role_id : 0;
                    $this->getGroupData();
                    return Redirect::to('admin/dashboard');
                } else {
                    return Redirect::back()->withErrors(['login' => 'Invalid Credentials']);
                }
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->withErrors(['login' => 'Invalid Credentials']);
        }
    }

    public function userProfile(Request $request)
    {
        if ($this->init() === false) {
            return Redirect::to('admin/login');
        }


        $userId = Session::get('user_id');
        $msg = "";
        $error = "";


        $userDetails = [];
        $users = Users::all();
        if ($userId) {
            $userDetails = Users::where('user_id', $userId)->where('is_delete', 0)->first();
            Session::put('profilepic', $userDetails->photo);
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'user_name' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
                'dob' => 'required|date|before:today',
                'email' => 'required|email',
                'new_password' => [
                    'required_with:old_password|min:8',
                    'required_with:old_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                ],
                'password_confirmation' => 'required_with:new_password|same:new_password',
            ], [
                'user_name.required' => 'User Name is required',
                'user_name.regex' => 'User Name format is invalid , use characters only',
                'dob.required' => 'Date of Birth is required',
                'dob.date' => '  Date of Birth is invalid,Use Date format',
                'dob.before' => 'The Date of Birth must be a date before today. ',
                'email.required' => 'Email Address is required ',
                //    'email.unique' => 'Record already existing with same Email address',
                'new_password.min' => 'Minimum 8 charcters required',
                'new_password.regex' => 'Invalid Format',
                'password_confirmation.required' => 'Confirm Password is required',
                'password_confirmation.same' => 'Confirm Password  should be same as password',
            ]);
            $userDetails = Users::where('user_id', $userId)->where('is_delete', 0)->first();
            $userDetails->user_name = $request->user_name;
            $userDetails->email = $request->email;

            if ($request->old_password) {
                if ($userDetails->password === $request->old_password) {
                    $userDetails->password = $request->new_password;
                } else {
                    $error = 'The specified password does not match with old Password';

                    return view('Admin::users/profile')
                        ->with(
                            [
                                'users' => $users,
                                'userDetails' => $userDetails,
                                'msg' => $msg,
                                'error' => $error
                            ]
                        );
                }

                if ($request->new_password === $request->old_password) {
                    $error = 'The New password must not be same as Old password';

                    return view('Admin::users/profile')
                        ->with(
                            [
                                'users' => $users,
                                'userDetails' => $userDetails,
                                'msg' => $msg,
                                'error' => $error
                            ]
                        );
                }
            }


            // $userDetails->photo = $request->photo;
            $userDetails->gender = $request->gender;
            $userDetails->dob = $request->dob;
            try {
                $this->setProfilePhoto($request, $userDetails);
            } catch (ValidationException $e) {
            }
            Session::put('profilepic', $userDetails->photo);
            $userDetails->save();
            $msg = "profile updated successfully";
        }
        return view('Admin::users/profile')
            ->with(
                [
                    'users' => $users,
                    'userDetails' => $userDetails,
                    'msg' => $msg,
                    'error' => $error
                ]
            );
    }

    public function logout()
    {
        Session::flush();
        return Redirect::to('/admin/login');
    }

    public function getGroupData()
    {
        try {
            if ($this->userId) {
                $groupData = GroupUserMapping::where('user_id', $this->userId)->get();
                if (!empty($groupData)) {
                    foreach ($groupData as $groupInfo) {
                        if ($groupInfo->gid) {
                            $this->groupId = $groupInfo->gid;
                            Session::put('group_id', $this->groupId);
                        }
                    }
                } else {
                    die('no group data');
                }
            } else {
                return 0;
            }
            return $this->groupId;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return 0;
        }
    }

    public function getLimitedAccessData($urlKey)
    {
        try {
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            if (!$this->roleId) {
                $this->roleId = Session::get('role_id');
            }
            if ($this->userId) {
                if ($this->roleId > 0) {
                    $limitedAccess = DB::table('role_action_mapping')
                        ->select('role_action_mapping.*')
                        ->join('user_role_mapping', 'user_role_mapping.role_id', '=', 'role_action_mapping.role_id')
                        ->join('menus', 'menus.menu_id', '=', 'role_action_mapping.menu_id')
                        ->where('user_role_mapping.user_id', $this->userId)
                        ->where('menus.menu_url', $urlKey)
                        ->get()->all();
                } else {
                    $limitedAccess = DB::table('role_action_mapping')
                        ->select('role_action_mapping.*')
                        ->join('menus', 'menus.menu_id', '=', 'role_action_mapping.menu_id')
                        ->where('role_action_mapping.user_id', $this->userId)
                        ->where('menus.menu_url', $urlKey)
                        ->get()->all();
                }
                if (!empty($limitedAccess)) {
                    foreach ($limitedAccess as $limit) {
                        $this->limitedAccess = $limit->limited_to;
                        Session::put('limited_access', $limit->limited_to);
                    }
                } else {
                    die('no access');
                }
            }
            return $this->limitedAccess;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return 'Own';
        }
    }

    public static function getMenusHtml()
    {

        try {
            if (Session::has('user_id') && Session::get('user_id') > 0) {
                $userId = Session::get('user_id');
                $roleId = Session::get('role_id');
                $hospitalId = $roleId == 0 ? Session::get('hospital_id') : 0;
                $menuDetails = [];

                if ($roleId != 0) {
                    $limitedAccess = DB::table('user_role_mapping')
                        ->whereRaw('user_id = ' . $userId . ' and role_id = ' . $roleId)
                        ->get()->all();
                }

                if ($roleId == 0 && $hospitalId > 0) {
                    $menuAllowed = DB::table('role_action_mapping')
                        ->where('user_id', '=', $userId)
                        ->where('hospital_id', '=', $hospitalId)
                        ->orderBy('menu_id', 'asc')
                        ->groupBy(['menu_id', 'role_action_mapping_id'])
                        ->get()->all();
                } elseif ($roleId > 0) {
                    $menuAllowed = DB::table('menus')
                        ->join('role_action_mapping', 'role_action_mapping.menu_id', '=', 'menus.menu_id')
                        ->where('role_action_mapping.role_id', '=', $roleId)
                        ->where('menus.is_active', 1)
                        ->where('menus.is_delete', 0)
                        ->whereRaw('(create_access = true OR edit_access = true OR view_access = true OR activate_access = true OR
delete_access = true)')
                        ->select('menus.*', 'role_action_mapping.*')
                        ->orderBy('menus.sort_order', 'asc')
                        ->groupBy(['role_action_mapping.role_action_mapping_id', 'menus.menu_id'])
                        ->get()->all();
                } else {
                    $menuAllowed = DB::table('menus')
                        ->join('role_action_mapping', 'role_action_mapping.menu_id', '=', 'menus.menu_id')
                        ->where('role_action_mapping.user_id', '=', $userId)
                        ->where('menus.is_delete', 0)
                        ->where('menus.is_active', 1)
                        ->whereRaw('(create_access = true OR edit_access = true OR view_access = true OR activate_access = true OR
delete_access = true)')
                        ->select('menus.*', 'role_action_mapping.*')
                        ->orderBy('menus.sort_order', 'asc')
                        ->groupBy(['role_action_mapping.role_action_mapping_id', 'menus.menu_id'])
                        ->get()->all();
                }
                if ($roleId != 1) {
                    foreach ($menuAllowed as $menuData) {
                        if ((property_exists($menuData, 'create_access') && $menuData->create_access) || (property_exists($menuData, 'edit_access') && $menuData->edit_access) || (property_exists($menuData, 'view_access') && $menuData->view_access) || (property_exists($menuData, 'delete_access') && $menuData->delete_access)) {
                            $menuDetails[$menuData->menu_id] = $menuData;
                        }
                    }
                } else {
                    foreach ($menuAllowed as $menuData) {
                        $menuDetails[$menuData->menu_id] = $menuData;
                    }
                }
                if ($roleId != 0) {
                    $role = UserRoleMapping::where('role_id', $roleId)->get()->all();
                    //        echo "<pre>";print_r($role);die;
                    if (!empty($role) && is_object($role) && $role->role_id == 1) {
                        $menuDetails = Menus::where('is_delete', 0)->orderBy('sort_order', 'asc')->get()->all();
                    }
                }
                $menuList = [];
                if (!empty($menuDetails)) {
                    $tempMenusItems = [];
                    $subMenusItems = [];
                    foreach ($menuDetails as $menuInfo) {
                        if (property_exists($menuInfo, 'parent_id') && $menuInfo->parent_id > 0) {
                            $subMenusItems[$menuInfo->parent_id][] = $menuInfo;
                        } else {
                            $tempMenusItems[$menuInfo->menu_id] = $menuInfo;
                        }
                    }
                    foreach ($tempMenusItems as $tempItem) {
                        if (isset($subMenusItems[$tempItem->menu_id])) {
                            $tempItem->sub_menu = $subMenusItems[$tempItem->menu_id];
                        }
                        $menuList[$tempItem->menu_id] = $tempItem;
                    }
                }
                return $menuList;
            } else {
                return [];
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public static function getHospitalListHtml()
    {
        try {
            if (Session::has('user_id') && Session::get('user_id') > 0) {
                $userId = Session::get('user_id');
                $roleId = Session::get('role_id');
                $hospitalDetails = [];
                if ($roleId == 0) {
                    $hospitalList = DB::table('role_action_mapping')
//                                    ->leftJoin('hospitals', 'hospitals.hospital_id', '=', 'role_action_mapping.hospital_id')
                        ->whereRaw('role_action_mapping.user_id = ' . $userId . ' and role_action_mapping.role_id = ' . $roleId .
                            ' and role_action_mapping.hospital_id != 0')
                        ->orderBy('role_action_mapping.hospital_id', 'asc')
                        ->get()->all();
                }
                if (!empty($hospitalList)) {
                    foreach ($hospitalList as $hospitalData) {
                        $hospitalDetails[$hospitalData->hospital_id] = $hospitalData;
                    }
                }
                return $hospitalDetails;
            } else {
                return [];
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public static function getHospitalDetails($hospitalId)
    {
        try {
            if ($hospitalId > 0) {
                $hospitalDetails = Hospitals::find($hospitalId);
                return $hospitalDetails;
            } else {
                return [];
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public static function getMenuDetails($menuId)
    {
        $menuDetails = [];
        if ($menuId > 0) {
            $menuDetails = Menus::where('menu_id', $menuId)->first();
        }
        return $menuDetails;
    }

    public function updateHospital(Hospitals $hospital)
    {
        try {
            if ($hospital) {
                Session::put('hospital_id', $hospital->id);
                return Redirect::to('admin/dashboard');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }

    public function getAccessDetails($urlKey, $allowedAction = null)
    {
        $this->userId = 0;
        try {
            if (!$this->userId) {
                $this->userId = 1;
            }
            $accessDetails = [];
            if ($urlKey) {
                if ($this->userId) {
//                    DB::enableQueryLog();
                    $limitedAccess = DB::table('role_action_mapping')
                        ->select('role_action_mapping.*')
                        ->join('user_role_mapping', 'user_role_mapping.role_id', '=', 'role_action_mapping.role_id')
                        ->join('menus', 'menus.menu_id', '=', 'role_action_mapping.menu_id')
                        ->where('user_role_mapping.user_id', $this->userId)
                        ->where('menus.menu_url', $urlKey)
                        ->get()->all();
                    if (empty($limitedAccess)) {
                        $limitedAccess = DB::table('role_action_mapping')
//                            ->select('role_action_mapping.*')
//                            ->join('user_role_mapping', 'user_role_mapping.role_id', '=', 'role_action_mapping.role_id')
                            ->join('menus', 'menus.menu_id', '=', 'role_action_mapping.menu_id')
                            ->where('role_action_mapping.user_id', $this->userId)
                            ->where('menus.menu_url', $urlKey)
                            ->get()->all();
                    }
//                    dd(DB::getQueryLog());
//                    echo "<pre>limitedAccess => ";print_r($limitedAccess);die;
                    if (!empty($limitedAccess)) {
                        foreach ($limitedAccess as $limit) {
                            switch ($allowedAction) {
                                case 'creact_access':
                                    return property_exists($limit, 'create_access') ? $limit->create_access : 0;
                                case 'edit_access':
                                    return property_exists($limit, 'edit_access') ? $limit->edit_access : 0;
                                case 'view_access':
                                    return property_exists($limit, 'view_access') ? $limit->view_access : 0;
                                case 'delete_access':
                                    return property_exists($limit, 'delete_access') ? $limit->delete_access : 0;
                                case 'activate_access':
                                    return property_exists($limit, 'activate_access') ? $limit->activate_access : 0;
                                default:
                                    $accessDetails = $this->accessDetails = $limit;
                                    Session::put('access_details', $this->accessDetails);
                                    return $limit;
                            }
                        }
                    }
                }
            }
            return $accessDetails;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return false;
        }
    }

    public function getAllAccessByUserData()
    {
        try {
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            $limitedAccess = [];
            if ($this->userId) {
                $limitedAccess = DB::table('role_action_mapping')
                    ->select('role_action_mapping.*')
                    ->join('user_role_mapping', 'user_role_mapping.role_id', '=', 'role_action_mapping.role_id')
                    ->join('menus', 'menus.menu_id', '=', 'role_action_mapping.menu_id')
                    ->where('user_role_mapping.user_id', $this->userId)
                    ->groupBy('role_action_mapping.menu_id', 'role_action_mapping.role_action_mapping_id')
                    ->get()->all();
            }
            return $limitedAccess;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return false;
        }
    }

    public function forgetpassword()
    {
        return view('Admin::forgetpassword');
    }

    public function getRolesByGroup()
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            $this->getGroupData();
            return DB::table('roles')
                ->join('group_role_mapping', 'group_role_mapping.role_id', '=', 'roles.role_id')
                ->where('group_role_mapping.gid', '=', $this->groupId)
                ->where('roles.is_active', 1)->where('roles.is_delete', 0)
                ->select('roles.*')
                ->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getUserRolesByGroup($userId)
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            $this->getGroupData();
            $roleData = DB::table('roles')
                ->join('group_role_mapping', 'group_role_mapping.role_id', '=', 'roles.role_id')
                ->join('role_action_mapping', 'role_action_mapping.role_id', '=', 'roles.role_id')
                ->where('group_role_mapping.gid', '=', $this->groupId)
                ->where('roles.is_active', 1)
                ->where('roles.is_delete', 0)
                ->where('role_action_mapping.user_id', '=', $userId)
                ->select('roles.*', 'role_action_mapping.*')
                ->groupBy(['role_action_mapping.role_action_mapping_id', 'roles.role_id'])
                ->get()->all();
            if (empty($roleData)) {
                $roleData = DB::table('role_action_mapping')
                    ->where('role_action_mapping.user_id', '=', $userId)
                    ->select('role_action_mapping.*')
                    ->groupBy(['role_action_mapping.role_action_mapping_id'])
                    ->get()->all();
            }
            return $roleData;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getUserRoleId($userId)
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            $this->getGroupData();
            return DB::table('roles')
                ->join('user_role_mapping', 'user_role_mapping.role_id', '=', 'roles.role_id')
                ->where('user_role_mapping.user_id', '=', $userId)
                ->select('roles.role_id')
                ->first();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getUsersByGroupId($groupId)
    {
        try {
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            $this->getGroupData();
            $userData = DB::table('users')
                ->join('group_user_mapping', 'group_user_mapping.user_id', '=', 'users.user_id')
                ->where('group_user_mapping.gid', '=', $groupId)
                ->where('users.user_id', '!=', $this->userId)
                ->select('users.*')
                ->get();
            return json_encode($userData);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getUsersByGroup()
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            $this->getGroupData();
            $userData = DB::table('users')
                ->join('group_user_mapping', 'group_user_mapping.user_id', '=', 'users.user_id')
                ->where('group_user_mapping.gid', '=', $this->groupId)
                ->where('users.user_id', '!=', $this->userId)
                ->select('users.*')
                ->get();
            return $userData;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getDoctorsByGroup()
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            $this->getGroupData();
            return DB::table('doctors')
                ->join('hospital_doctor_mapping', 'hospital_doctor_mapping.doctor_id', '=', 'doctors.id')
                ->join(
                    'group_hospital_mapping',
                    'group_hospital_mapping.hospital_id',
                    '=',
                    'hospital_doctor_mapping.hospital_id'
                )
                ->where('group_hospital_mapping.group_id', '=', $this->groupId)
                ->select('doctors.*')
                ->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getDoctorsListByGroup()
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
//            DB::enableQueryLog();
            $this->getGroupData();
            return DB::table('doctors')
                ->join('hospital_doctor_mapping', 'hospital_doctor_mapping.doctor_id', '=', 'doctors.id')
                ->join(
                    'group_hospital_mapping',
                    'group_hospital_mapping.hospital_id',
                    '=',
                    'hospital_doctor_mapping.hospital_id'
                )
                ->where('group_hospital_mapping.group_id', '=', $this->groupId)
                ->select('doctors.*')
                ->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    /**
     * @return array|Collection
     */
    public function getMenusByGroup()
    {
        try {
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            $this->getGroupData();
            return DB::table('menus')
                ->join('role_action_mapping', 'role_action_mapping.menu_id', '=', 'menus.menu_id')
                ->join('user_role_mapping', 'user_role_mapping.role_id', '=', 'role_action_mapping.role_id')
                ->where('user_role_mapping.user_id', '=', $this->userId)
                ->select('menus.*', 'role_action_mapping.*')
                ->orderBy('menus.sort_order', 'asc')
                ->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getGroupsByGroup()
    {
        try {
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            return DB::table('group')
                ->join('group_user_mapping', 'group_user_mapping.gid', '=', 'group.gid')
                ->where('group_user_mapping.user_id', '=', $this->userId)
                ->select('group.*', 'group_user_mapping.*')
                ->orderBy('group.group_id', 'asc')
                ->get()->all();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getGroupByUser()
    {
        try {
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            return DB::table('group')
                ->join('group_user_mapping', 'group_user_mapping.gid', '=', 'group.gid')
                ->where('group_user_mapping.user_id', '=', $this->userId)
                ->select('group.*', 'group_user_mapping.*')
                ->orderBy('group.group_id', 'asc')
                ->first();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getHospitalByGroup($group_id = 0)
    {
        try {
            if (!$group_id) {
                $group_id = Session::get('group_id');
            }
            return DB::table('hospitals as h')
                ->join('group_hospital_mapping as ghm', 'ghm.hospital_id', '=', 'h.hospital_id')
                ->where('ghm.group_id', '=', $group_id)
                ->select('h.*', 'ghm.*')
                ->orderBy('h.hospital_id', 'asc')
                ->get()->all();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function getHospitalsByGroup()
    {
        try {
            if (!$this->groupId) {
                $this->groupId = Session::get('group_id');
            }
            if (!$this->userId) {
                $this->userId = Session::get('user_id');
            }
            $groupsData = DB::table('hospitals')
                ->join('group_hospital_mapping', 'group_hospital_mapping.hospital_id', '=', 'hospitals.hospital_id')
                ->where('group_hospital_mapping.group_id', '=', $this->groupId)
                ->select('hospitals.*')
                ->where('hospitals.is_active', 1)->where('hospitals.is_delete', 0)
                ->orderBy('hospitals.hospital_id', 'asc')
                ->get()->all();
            if (empty($groupsData)) {
                $groupsData = DB::table('hospitals')
                    ->join('group_hospital_mapping', 'group_hospital_mapping.hospital_id', '=', 'hospitals.hospital_id')
                    ->join('role_action_mapping', 'role_action_mapping.hospital_id', '=', 'hospitals.hospital_id')
                    ->where('group_hospital_mapping.group_id', '=', $this->groupId)
                    ->where('role_action_mapping.user_id', '=', $this->userId)
                    ->where('hospitals.is_active', 1)->where('hospitals.is_delete', 0)
                    ->select('hospitals.*')
                    ->groupBy('hospitals.hospital_id')
                    ->orderBy('hospitals.hospital_id', 'asc')
                    ->get()->all();
            }
            return $groupsData;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public function mapRoleMenus($roleDetails)
    {
        $tempArray = [];
        if (!empty($roleDetails)) {
            foreach ($roleDetails as $mapingData) {
                $tempArray[$mapingData->menu_id] = ['role_id' => $mapingData->role_id,
                    'create_access' => $mapingData->create_access,
                    'edit_access' => $mapingData->edit_access,
                    'view_access' => $mapingData->view_access,
                    'activate_access' => $mapingData->activate_access,
                    'delete_access' => $mapingData->delete_access,
                    'limited_to' => $mapingData->limited_to,
                    'menu_id' => isset($mapingData->menu_id) ? $mapingData->menu_id : 0,
                    'user_id' => isset($mapingData->user_id) ? $mapingData->user_id : 0,
                    'hospital_id' => isset($mapingData->hospital_id) ? $mapingData->hospital_id : 0];
            }
        }
        return $tempArray;
    }

    public function validateLicense(Request $request): JsonResponse
    {
        try {
            $requestParams = $this->filterParameters($request->all());
            $responseData = [];
            if (isset($requestParams['licence'])) {
                $responseData = ['valid' => true];
                $module = isset($requestParams['module_name']) ? $requestParams['module_name'] : '';
                switch ($module) {
                    case 'group':
                        $validatedData = \Validator::make($request->all(), [
                            'licence' => 'required|unique:group,licence,' . $request->id . ',group_id',
                        ]);
                        if ($validatedData->fails()) {
                            $responseData['valid'] = false;
                        }
                        break;
                    default:
                        break;
                }
            }
            return response()->json($responseData);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function setData($url_key, $accessType): RedirectResponse
    {
        try {
            if ($this->init() === false) {
                die(redirect('admin/logout')->with('error', 'Invalid session'));
            }
            if (!$this->roleId && Session::has('role_id')) {
                $this->roleId = Session::get('role_id');
            }
            foreach ($this->adminModules as $moduleUrl) {
                if ($url_key == $moduleUrl && $this->roleId != 1) {
                    die(redirect('admin/dashboard')->with('error', 'Invalid page access'));
                }
            }
            if (!$this->limitedAccess && Session::has('limited_access')) {
                $this->limitedAccess = Session::get('limited_access');
            } else {
                $this->getLimitedAccessData($url_key);
            }
            if (!$this->accessDetails && Session::has('access_details')) {
                $this->accessDetails = Session::get('access_details');
            } else {
                $this->getAccessDetails($url_key);
            }
            switch ($accessType) {
                case 'add':
                    if (
                        isset($this->accessDetails) &&
                        isset($this->accessDetails->add_access) &&
                        !$this->accessDetails->add_access
                    ) {
                        die(redirect('admin/dashboard')->with('error', 'Invalid access page!'));
                    }
                    break;
                case 'edit':
                    if (
                        isset($this->accessDetails) &&
                        isset($this->accessDetails->edit_access) &&
                        !$this->accessDetails->edit_access
                    ) {
                        die(redirect('admin/dashboard')->with('error', 'Invalid access page!'));
                    }
                    break;
                case 'view':
                    if (
                        isset($this->accessDetails) &&
                        isset($this->accessDetails->view_access) &&
                        !$this->accessDetails->view_access
                    ) {
                        die(redirect('admin/dashboard')->with('error', 'Invalid access page!'));
                    }
                    break;
                case 'activate':
                    if (
                        isset($this->accessDetails) &&
                        isset($this->accessDetails->activate_access) &&
                        !$this->accessDetails->delete_access
                    ) {
                        die(redirect('admin/dashboard')->with('error', 'Invalid access page!'));
                    }
                    break;
                case 'delete':
                    if (
                        isset($this->accessDetails) &&
                        isset($this->accessDetails->delete_access) &&
                        !$this->accessDetails->delete_access
                    ) {
                        die(redirect('admin/dashboard')->with('error', 'Invalid access page!'));
                    }
                    break;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request): bool|string
    {
        try {
            $response = ['status' => 1, 'message' => 'SUCCESS'];
            $requestParams = $this->filterParameters($request->all());
            Log::info($requestParams);
//            DB::enableQueryLog();
            switch ($requestParams['module']) {
                case '/admin/roles':
                    $moduleObj = Roles::where('role_id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/menus':
                    $moduleObj = Menus::where('menu_id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/users':
                    $moduleObj = \Users::where('user_id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/durations':
                    $moduleObj = Durations::where('id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/doctors':
                    $moduleObj = doctors::where('doctor_id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/groups':
                    $moduleObj = Groups::where('group_id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/hospitals':
                    $moduleObj = Hospitals::where('hospital_id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/pages':
                    $moduleObj = Pages::where('id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/settings/patientsmetatypes':
                    $moduleObj = PatientMetaTypes
                        ::where('pmeta_id', $requestParams['id'])
                        ->where('is_delete', 0)
                        ->first();
                    break;
                case '/admin/settings/groupmetatypes':
                    $moduleObj = GroupMetaTypes
                        ::where('gmeta_id', $requestParams['id'])
                        ->where('is_delete', 0)
                        ->first();
                    break;
                case '/admin/settings/doctorsmetatypes':
                    $moduleObj = DoctorMetaTypes
                        ::where('dmeta_id', $requestParams['id'])
                        ->where('is_delete', 0)
                        ->first();
                    break;
                case '/admin/settings/apiconfigurations':
                    $moduleObj = ApiConfiguration::where('id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/members':
                    $moduleObj = Patients::where('id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/specializations':
                    $moduleObj = Specialization::where('id', $requestParams['id'])->where('is_delete', 0)->first();
                    break;
                case '/admin/consultationtypes':
                    $moduleObj = ConsultationTypes
                        ::where('ctype_id', $requestParams['id'])
                        ->where('is_delete', 0)
                        ->first();
                    break;
                default:
                    break;
            }
            if (!empty((array)$moduleObj)) {
                $moduleObj->is_active = $requestParams['status'] == 'true' ? 1 : 0;
                $moduleObj->save();
            } else {
                $response = ['status' => 0, 'message' => 'No data found'];
            }
            Log::info($response);
            return json_encode($response);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            $response = ['status' => 0, 'message' => $ex->getMessage()];
            return json_encode($response);
        }
    }

    public static function getGroupByHospitalId($hospitalId): string
    {
        try {
            if ($hospitalId > 0) {
                $hospitalDetails = DB::table('group_hospital_mapping')
                    ->join('group', 'group.gid', '=', 'group_hospital_mapping.group_id')
                    ->select('group.group_name')
                    ->where('group_hospital_mapping.hospital_id', $hospitalId)
                    ->get()->first();
//                echo "<pre>";print_r($hospitalDetails);die;
                return $hospitalDetails->group_name;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }

    public static function getHospitalAddress($hospitalId): string
    {
        try {
            if ($hospitalId > 0) {
                $hospitalDetails = Hospitals::find($hospitalId);
                return (
                    $hospitalDetails->address_line1 . ' ' .
                    $hospitalDetails->address_line2 . ' ' .
                    $hospitalDetails->address_line3 . ' ' .
                    $hospitalDetails->address_city . ' ' .
                    $hospitalDetails->address_state . ' ' .
                    $hospitalDetails->address_country . ' ' .
                    $hospitalDetails->address_postcode
                );
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }

    /**
     * @param int $moduleId
     * @param int $mappingType
     * @param array $specializations
     * @param array $requestParams
     * @param string $metaName
     * @param string $metaId
     * @return string
     */
    public function saveMetaTypeData(
        int $moduleId,
        int $mappingType,
        array $specializations,
        array $requestParams,
        string $metaName = 'gmetaname',
        string $metaId = 'gmeta_id'
    ): string
    {
        try {
            if (!empty($specializations)) {
                if (!$this->userId) {
                    $this->userId = Session::get('user_id');
                }
                foreach ($specializations as $spec) {
                    $name = str_replace(' ', '_', $spec->metaName);
                    if (isset($requestParams[$name])) {
                        $metaData = MetatypeData::where('metatype_data.mapping_type', $mappingType)
                            ->where('metatype_data.is_active', 1)
                            ->where('metatype_data.mapping_type_id', $moduleId)
                            ->where('metatype_data.mapping_type_data_id', $spec->metaId)
                            ->first();
//                            echo "<pre>";print_r($metaData);die;
                        if ($metaData) {
                            $metaData->mapping_type_data_value = $requestParams[$name];
                            $metaData->updated_by = $this->userId;
                            $metaData->save();
                        } else {
                            $metatypeData = new MetatypeData();
                            $metatypeData->mapping_type = $mappingType;
                            $metatypeData->mapping_type_id = $moduleId;
                            $metatypeData->mapping_type_data_id = $spec->metaId;
                            $metatypeData->mapping_type_data_value = $requestParams[$name];
                            $metatypeData->created_by = $this->userId;
                            $metatypeData->updated_by = 0;
                            $metatypeData->save();
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }

    /**
     * @param string $countryCode
     * @return array
     */
    public function getTimezonesByCountryCode(string $countryCode): array
    {
        try {
            $zones = DB::table('timezones')
                ->select(
                    'id',
                    'countrycode',
                    DB::raw("concat('(UTC',replace(UTC_offset,':00',''),') ',TimeZone)  as utc")
                )
                ->where('countrycode', '!=', '')->get()->toJson();
            if ($countryCode != '') {
                $zones = DB::table('timezones')
                    ->select(
                        'id',
                        'countrycode',
                        DB::raw("concat('(UTC',replace(UTC_offset,':00',''),') ',TimeZone)  as utc")
                    )
                    ->where('countrycode', $countryCode)->get()->toJson();
            }
            echo $zones;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }
    }

    public static function getDocSpecTypes($doctorId, $mappingType): string
    {
        try {
            $response = '';
            if ($doctorId > 0) {
                $specializationData = SpecializationMapping::
                join('specialization_types', 'specialization_types.id', '=', 'specialization_mapping.specialization_id')
                    ->where('specialization_mapping.mapping_type', $mappingType)
                    ->where('specialization_mapping.mapping_type_id', $doctorId)
                    ->get()->all();
                $specializationList = [];
                if ($specializationData) {
                    foreach ($specializationData as $specializationInfo) {
                        $specializationList[] = $specializationInfo->specialization_name;
                    }
                    $response = implode(', ', $specializationList);
                }
            }
            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }

    /**
     * @param $doctorId
     * @param $mappingType
     * @return string
     */
    public static function getDocConstTypes($doctorId, $mappingType): string
    {
        try {
            $response = '';
            if ($doctorId > 0) {
                $consultationData = ConsultationMapping::
                join('consultation_types', 'consultation_types.ctype_id', '=', 'consultation_mapping.consultation_id')
                    ->where('consultation_mapping.mapping_type', $mappingType)
                    ->where('consultation_mapping.mapping_type_id', $doctorId)->get()->all();
                $consultationList = [];
                if ($consultationData) {
                    foreach ($consultationData as $consultationInfo) {
                        $consultationList[] = $consultationInfo->ctype_name;
                    }
                    $response = implode(', ', $consultationList);
                }
            }
            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }

    public static function getDocLanguages($doctorId, $mappingType): string
    {
        try {
            $response = '';
            if ($doctorId > 0) {
                $consultationData = LanguageMapping::
                join('languages', 'languages.id', '=', 'lang_mapping.lang_mapping_id')
                    ->where('lang_mapping.module_mapping_type', $mappingType)
                    ->where('lang_mapping.module_mapping_type_id', $doctorId)->get()->all();
                $consultationList = [];
                if ($consultationData) {
                    foreach ($consultationData as $consultationInfo) {
                        $consultationList[] = $consultationInfo->value;
                    }
                    $response = implode(', ', $consultationList);
                }
            }
            return $response;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return '';
        }
    }
}
