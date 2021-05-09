<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use App\Http\Middleware\EncryptUrlParams;
use App\Http\Requests\AddHospitalRequest;
use App\Modules\Admin\Models\HospitalMetaTypes;
use App\Modules\Admin\Models\MetatypeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Modules\Admin\Models\Hospitals as Hospitals;
use App\Modules\Admin\Models\Groups as Groups;
use App\Modules\Admin\Models\Users as Users;
use App\Modules\Admin\Models\GroupHospitalMapping as GroupHospitalMapping;
use App\Modules\Admin\Models\UserHospitalMapping as UserHospitalMapping;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use App\Modules\Admin\Models\Specialization as Specialization;
use App\Modules\Admin\Models\ConsultationTypes as ConsultationTypes;
use App\Modules\Frontend\Models\HospitalDoctorMapping;
use App\Modules\Admin\Models\Doctors;
use App\Modules\Admin\Models\GroupUserMapping;
use App\Modules\Admin\Models\UserRoleMapping;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Validation\ValidationException;

/**
 * Description of MenusController
 *
 * @author sandeep.jeedula
 */
class HospitalsController extends AdminController
{

    private string $url_key = '/admin/hospitals';
    private string $mapping_type = 'Hospital';
    private string $mapping_key = 'H';

    public function hospitals()
    {
        try {
            $this->setData($this->url_key, 'view');
            $groups = [];
            if ($this->limitedAccess == 'All') {
                $hospitals = Hospitals::orderBy('hospital_id', 'asc')->where('is_delete', 0)->paginate(10);
                $groups = Groups::orderBy('group_id', 'asc')
                    ->where('is_active', 1)
                    ->where('is_delete', 0)
                    ->get()->all();
            } else {
                $hospitals = $this->getHospitalsByGroup();
            }
            return view('Admin::hospitals/hospitals')->with(['hospitalList' => $hospitals, 'groups' => $groups,
                        'accessDetails' => $this->accessDetails, 'roleId' => $this->roleId, 'mapping_key' => $this->mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createHospital()
    {
        try {
            $this->setData($this->url_key, 'add');
            $groups = [];
            $users = [];
            if ($this->limitedAccess == 'All') {
                $hospitals = Hospitals::orderBy('hospital_id', 'asc')->where('is_delete', 0)->get();
                $groups = Groups::orderBy('group_id', 'asc')->where('is_active', 1)->where('is_delete', 0)->get()->all();
            } else {
                $hospitals = $this->getRolesByGroup();
            }
            $consultationTypes = ConsultationTypes::where('is_active', 1)->where('is_delete', 0)->get()->all();
            $specializations = Specialization::where('is_active', 1)->where('is_delete', 0)->get()->all();
            $hospitalMetaTypes = HospitalMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            return view('Admin::hospitals/create_hospital')->with(['hospitalsList' => $hospitals->all(),
                        'limited_access' => $this->limitedAccess, 'groups' => $groups,
                        'consultationTypes' => $consultationTypes, 'hospitalMetaTypes' => $hospitalMetaTypes,
                        'specializations' => $specializations, 'users' => $users]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addHospital(AddHospitalRequest $request)
    {
        try {
            $this->setData($this->url_key, 'add');
            $requestParams = $this->filterParameters($request->all());
            Log::info("Class" . __CLASS__ . " Method" . __METHOD__ . ' request data => ' . json_encode($requestParams));
            $successMessage = 'Added successfully';
            $hospitalId = isset($requestParams['hospital_id']) ? $requestParams['hospital_id'] : 0;
            if ($hospitalId != 0) {
                $hospitalDetails = Hospitals::where('hospital_id', $hospitalId)->where('is_delete', 0)->first();
                $hospitalDetails->hospital_name = $request->hospital_name;
                $hospitalDetails->hospital_business_name = $request->hospital_business_name;
                $hospitalDetails->licence = $request->licence;
                $hospitalDetails->dateofregistration = $request->dateofregistration;
                $hospitalDetails->hospital_type = $request->hospital_type;
                $hospitalDetails->fax = $request->fax;
                $hospitalDetails->location = $request->location;
                $this->saveHospitalBanner($request, $hospitalDetails);
                $hospitalDetails->phone = $request->phonecode . '-' . $request->phone;
                $hospitalDetails->updated_by = $this->userId;
                $hospitalDetails->save();
                $successMessage = 'Updated successfully';
            } else {
                $request->validate([
                    'hospital_name' => ['required', 'regex:/^[ A-Za-z0-9_@.#&+-]*$/'],
                    'phone' => 'required|numeric|digits_between:10,12|unique:hospitals',
                    'email' => 'required|email|unique:hospitals',
                    'licence' => 'required|digits_between:7,7|unique:hospitals,licence',
                    'address_line1' => 'required',
                    'address_line2' => 'required',
                    'address_city' => 'required',
                    'address_state' => 'required',
                    'address_country' => 'required',
                    'address_postcode' => 'required',
                ]);
                $hmax = Hospitals::max('hospital_id');
                if ($hmax == '') {
                    $hmax = 1;
                } else {
                    $hmax++;
                }
                $hospitalCode = 'HSPBE' . date('y') . (10000 + $hmax);
                $hospitalData = new Hospitals();
                $hospitalData->hospitalcode = $hospitalCode;
                $hospitalData->hospital_name = $request->hospital_name;
                $hospitalData->hospital_business_name = $request->hospital_business_name;
                $hospitalData->licence = $request->licence;
                $hospitalData->dateofregistration = $request->dateofregistration;
                $hospitalData->hospital_type = $request->hospital_type;
                $hospitalData->phone = $request->phonecode . '-' . $request->phone;
                $hospitalData->email = $request->email;
                $hospitalData->fax = $request->fax;
                $this->saveHospitalBanner($request, $hospitalData);
                $hospitalData->location = $request->location;
                $hospitalData->is_active = 1;
                $hospitalData->is_delete = 0;
                $hospitalData->created_by = $this->userId;
                $hospitalData->updated_by = 0;
                $hospitalData->save();
                $hospitalId = $hospitalData->hospital_id;
            }
            if ($hospitalId) {
                $groupId = isset($requestParams['group_id']) ? $requestParams['group_id'] : $this->groupId;
                $groupHospitalMapping = GroupHospitalMapping
                    ::whereRaw('hospital_id = ' . $hospitalId . ' and group_id = ' . $groupId)
                    ->first();
//            echo "<pre>";print_r($groupHospitalMapping);die;
                if (!$groupHospitalMapping) {
                    $groupHospitalMapping11 = new GroupHospitalMapping();
                    $groupHospitalMapping11->hospital_id = $hospitalId;
                    $groupHospitalMapping11->group_id = $groupId;
                    $groupHospitalMapping11->created_by = $this->userId;
                    $groupHospitalMapping11->updated_by = 0;
                    $groupHospitalMapping11->save();
                } else {
                    $groupHospitalMapping->group_id = $groupId;
                    $groupHospitalMapping->updated_by = $this->userId;
                    $groupHospitalMapping->save();
                }
                $userId = isset($requestParams['user_id']) ? $requestParams['user_id'] : $this->userId;
                $userHospitalMapping = UserHospitalMapping
                    ::whereRaw('hospital_id = ' . $hospitalId . ' and user_id = ' . $userId)
                    ->first();
                if (!$userHospitalMapping) {
//                $userHospitalMapping1 = new UserHospitalMapping();
                    $userHospitalMapping1['hospital_id'] = $hospitalId;
                    $userHospitalMapping1['user_id'] = $userId;
                    $userHospitalMapping1['created_by'] = $this->userId;
                    $userHospitalMapping1['updated_by'] = 0;
                    UserHospitalMapping::updateOrInsert($userHospitalMapping1);
                } else {
                    $userHospitalMapping->updated_by = $this->userId;
                    $userHospitalMapping->save();
                }
                $this->setSpecialization(
                    $request,
                    $hospitalId,
                    $this->mapping_type,
                    $userId
                );
            }
            $hospitalMetaTypes = HospitalMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $this->saveMetaTypeData(
                $hospitalId,
                $this->mapping_type,
                $hospitalMetaTypes,
                $requestParams,
                'hmetaname',
                'hmeta_id'
            );
            return Redirect::to('admin/hospitals')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editHospital($hospitalId)
    {
        try {
            $this->setData($this->url_key, 'edit');

            $hospitalIdData = EncryptUrlParams::decrypt($hospitalId);
            $hospital_id = str_replace($this->mapping_key, '', $hospitalIdData);
            if (!$hospital_id) {
                return Redirect::back()->with('error', 'Hopital not found');
            }
            $hospitals = Hospitals::where('hospital_id', $hospital_id)->first();
            $phoneCode = '';
            $phoneNumber = '';
            list($phoneCode, $phoneNumber) = $this->setPhoneForHospital($hospitals);
            $groups = [];
            list($groups, $users, $groupDetails, $userDetails) = $this->processLimitedAccess($hospital_id);

            list($specializations, $specializationList, $consultationTypes, $consultationList) =
                $this->setSpecializationToConsultation($hospital_id);
            list($hospitalMetaTypes, $hospitalMetaList) = $this->getHospitalMetaTypes($hospital_id);
            $doctorsList = $this->getDoctorsListByGroup();
            return view('Admin::hospitals/create_hospital')->with(['hospital_details' => $hospitals,
                'phoneNumber' => $phoneNumber, 'phoneCode' => $phoneCode, 'hospitalMetaTypes' => $hospitalMetaTypes,
                'groups' => $groups, 'users' => $users, 'specializations' => $specializations,
                'specializationList' => $specializationList, 'consultationTypes' => $consultationTypes,
                'consultationList' => $consultationList, 'doctorsList' => $doctorsList,
                'hospitalMetaList' => $hospitalMetaList,
                'groupDetails' => $groupDetails, 'userDetails' => $userDetails,
                'hospital_id' => $hospitalId,
                'limited_access' => $this->limitedAccess]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewHospital($hospitalId)
    {
        try {
            $this->setData($this->url_key, 'view');

            $hospitalIdData = EncryptUrlParams::decrypt($hospitalId);
            $hospital_id = str_replace($this->mapping_key, '', $hospitalIdData);
            $hospitals = Hospitals::where('hospital_id', $hospital_id)->first();
            $groups = [];
            if ($this->limitedAccess == 'All') {
                $groups = Groups::orderBy('group_id', 'asc')->get()->all();
                $users = Users::orderBy('user_id', 'asc')->get()->all();
            } else {
                $users = $this->getUsersByGroup();
            }
            list($specializations, $specializationList, $consultationTypes, $consultationList) =
                $this->setSpecializationToConsultation($hospital_id);
            $groupDetails = GroupHospitalMapping::where('hospital_id', $hospital_id)->first();
            $userDetails = UserHospitalMapping::where('hospital_id', $hospital_id)->first();

            list($hospitalMetaTypes, $hospitalMetaList) = $this->getHospitalMetaTypes($hospital_id);
            return view('Admin::hospitals/view_hospital')->with(['hospital_details' => $hospitals,
                        'groups' => $groups, 'users' => $users, 'specializations' => $specializations
                        ,'consultationList' => $consultationList, 'hospitalMetaTypes' => $hospitalMetaTypes,
                    'specializationList' => $specializationList, 'hospitalMetaList' => $hospitalMetaList,
                        'groupDetails' => $groupDetails, 'userDetails' => $userDetails,
                        'consultationTypes' => $consultationTypes, 'hospital_id' => $hospitalId,
                        'limited_access' => $this->limitedAccess]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function migrateHospitalView($hospitalId)
    {
        try {
            if ($this->init() === false) {
                return Redirect::to('admin/login');
            }
            $groups = [];
            if (!$this->limitedAccess && Session::has('limited_access')) {
                $this->limitedAccess = Session::get('limited_access');
            } else {
                $this->getLimitedAccessData($this->url_key);
            }
            if (!$this->accessDetails && Session::has('access_details')) {
                $this->accessDetails = Session::get('access_details');
            } else {
                $this->getAccessDetails($this->url_key);
            }
            if (
                isset($this->accessDetails) &&
                isset($this->accessDetails->view_access) &&
                $this->accessDetails->view_access
            ) {
                $hospitalIdData = EncryptUrlParams::decrypt($hospitalId);
                $hospital_id = str_replace($this->mapping_key, '', $hospitalIdData);
                $hospitals = Hospitals::where('hospital_id', $hospital_id)->first();
                list($groups, $users, $groupDetails, $userDetails) = $this->processLimitedAccess($hospital_id);
            } else {
                return redirect('admin/dashboard')->withErrors('Invalid access page!');
            }
            $specializations = Specialization::all()->where('is_delete', 0);
            return view('Admin::hospitals/migrate_hospital')->with(['hospital_details' => $hospitals,
                        'groups' => $groups, 'users' => $users, 'specializations' => $specializations,
                        'groupDetails' => $groupDetails, 'userDetails' => $userDetails,
                        'limited_access' => $this->limitedAccess]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function migrateHospital(Request $request)
    {
        try {
            if ($this->init() === false) {
                return Redirect::to('admin/login');
            }
            $requestParams = $request->all();
            $hospital_id = $requestParams['hospital_id'];

            $hsmapping = HospitalDoctorMapping::where('hospital_id', $hospital_id)->first();
            $groupDetails = GroupHospitalMapping::where('hospital_id', $hospital_id)->first();
            $doctor_id = $hsmapping->doctor_id;
            $doctor = Doctors::where('id', $doctor_id)->first();

            $userDetails = Users::where('email', $doctor->email)->first();
            $userDetails = json_decode(json_encode($userDetails), 1);
            if (!isset($userDetails['user_name'])) {
                $userData = new Users();
                $userData->user_name = $doctor->firstname . ' ' . $doctor->lastname;
                $userData->email = $doctor->email;
                $userData->password = $doctor->password;
                $userData->created_by = $this->userId;
                $userData->save();
                $userId = $userData->user_id;

                $groupMapping = new GroupUserMapping();
                $groupMapping->user_id = $userId;
                $groupMapping->gid = $groupDetails->group_id;
                $groupMapping->created_by = $this->userId;
                $groupMapping->save();

                $userRoleMapping['user_id'] = $userId;
                $userRoleMapping['role_id'] = 3;

                $userRoleDetails = UserRoleMapping::whereRaw('user_id = ' . $userId . ' and role_id = 3')->first();
                if (!empty($userRoleDetails) && $userRoleDetails->user_id) {
                    $userRoleMapping['updated_by'] = $this->userId;
                } else {
                    $userRoleMapping['created_by'] = $this->userId;
                }
                UserRoleMapping::updateOrInsert($userRoleMapping);
            }
            $hospitalDetails = Hospitals::where('hospital_id', $hospital_id)->where('is_delete', 0)->first();
            $hospitalDetails->hospital_type = $this->mapping_key;
            $hospitalDetails->updated_by = $this->userId;
            $hospitalDetails->save();

            $doctorDetails = Doctors::where('hospital_id', $hospital_id)->where('is_delete', 0)->first();
            $doctorDetails->opt_clinic = 'no';
            $doctorDetails->save();

            return Redirect::to('admin/hospitals/')->with('success', 'Migrated successfully');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteHospital($hospitalId)
    {
        try {
            $this->setData($this->url_key, 'delete');
            $hospitalIdData = EncryptUrlParams::decrypt($hospitalId);
            $hospital_id = str_replace($this->mapping_key, '', $hospitalIdData);
            if ($hospital_id) {
                $hospitals = Hospitals::where('hospital_id', $hospital_id)->where('is_delete', 0)->first();
                $hospitals->is_delete = 1;
                $hospitals->save();
                return Redirect::to('admin/hospitals/');
            } else {
                return Redirect::back('admin/hospitals/')->withError('No hospital found');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    /**
     * @param array|bool|string|null $hospital_id
     * @return array
     */
    private function processLimitedAccess(array | bool | string | null $hospital_id): array
    {
        if ($this->limitedAccess == 'All') {
            $groups = Groups::orderBy('group_id', 'asc')->get()->all();
            $users = Users::orderBy('user_id', 'asc')->get()->all();
        } else {
            $users = $this->getUsersByGroup();
        }
        $groupDetails = GroupHospitalMapping::where('hospital_id', $hospital_id)->first();
        $userDetails = UserHospitalMapping::where('hospital_id', $hospital_id)->first();
        return array($groups, $users, $groupDetails, $userDetails);
    }

    /**
     * @param array|bool|string|null $hospital_id
     * @return array
     */
    private function getHospitalMetaTypes(array | bool | string | null $hospital_id): array
    {
        $hospitalMetaTypes = HospitalMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
        $hospitalMetaData = MetatypeData::where('mapping_type', $this->mapping_type)
            ->where('mapping_type_id', $hospital_id)->get()->all();
        $hospitalMetaList = [];
        if ($hospitalMetaData) {
            foreach ($hospitalMetaData as $hospitalMetaInfo) {
                $hospitalMetaList[$hospitalMetaInfo->mapping_type_data_id] = $hospitalMetaInfo->mapping_type_data_value;
            }
        }
        return array($hospitalMetaTypes, $hospitalMetaList);
    }

    /**
     * @param AddHospitalRequest $request
     * @param $hospitalDetails
     * @throws ValidationException
     */
    private function saveBanner(AddHospitalRequest $request, $hospitalDetails): void
    {
        if ($request->hasFile('banner')) {
            if ($request->file('banner')->isValid()) {
                try {
                    $this->validate($request, [
                        'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);

                    $file = $request->file('banner');
                    $name = $file->getClientOriginalName();
                    $request->file('banner')->move("uploads", $name);
                    $hospitalDetails->banner = $name;
                } catch (FileNotFoundException $e) {
                    Log::error("Class" . __CLASS__ . " Method" . __METHOD__ . ' banner upload failed => ' . $e->getMessage());
                    Log::error("Class" . __CLASS__ . " Method" . __METHOD__ . ' banner upload failed => ' . $e->getTraceAsString());
                }
            }
        }
    }

    /**
     * @param AddHospitalRequest $request
     * @param $hospitalDetails
     * @throws ValidationException
     */
    private function saveHospitalBanner(AddHospitalRequest $request, $hospitalDetails): void
    {
        if ($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                try {
                    $this->validate($request, [
                        'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);

                    $file = $request->file('logo');
                    $name = $file->getClientOriginalName();
                    $request->file('logo')->move("uploads", $name);
                    $hospitalDetails->logo = $name;
                } catch (FileNotFoundException $e) {
                    Log::error("Class" . __CLASS__ . " Method" . __METHOD__ . ' logo upload failed => ' . $e->getMessage());
                    Log::error("Class" . __CLASS__ . " Method" . __METHOD__ . ' logo upload failed => ' . $e->getTraceAsString());
                }
            }
        }
        $this->saveBanner($request, $hospitalDetails);
        $hospitalDetails->address_line1 = $request->address_line1;
        $hospitalDetails->address_line2 = $request->address_line2;
        $hospitalDetails->address_line3 = $request->address_line3;
        $hospitalDetails->address_city = $request->address_city;
        $hospitalDetails->address_state = $request->address_state;
        $hospitalDetails->address_country = $request->address_country;
        $hospitalDetails->address_postcode = $request->address_postcode;
        $hospitalDetails->address_lat = $request->address_lat;
        $hospitalDetails->address_long = $request->address_long;
        $hospitalDetails->summary = $request->summary;
    }
}
