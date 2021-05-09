<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use App\Http\Middleware\EncryptUrlParams;
use App\Http\Requests\DoctorAddRequest;
use App\Http\Requests\DoctorVerificationRequest;
use App\Http\Requests\MapDoctorRequest;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use App\Modules\Admin\Models\ConsultationMapping as ConsultationMapping;
use App\Modules\Admin\Models\ConsultationTypes as ConsultationTypes;
use App\Modules\Admin\Models\DoctorMetaTypes;
use App\Modules\Admin\Models\Doctors as doctors;
use App\Modules\Admin\Models\Groups as Groups;
use App\Modules\Admin\Models\LanguageMapping;
use App\Modules\Admin\Models\Languages as Languages;
use App\Modules\Admin\Models\MetatypeData;
use App\Modules\Admin\Models\Specialization as Specialization;
use App\Modules\Admin\Models\SpecializationMapping as SpecializationMapping;
use App\Modules\Admin\Models\Users as Users;
use App\Modules\Frontend\Models\HospitalDoctorMapping;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

/**
 * Description of MenusController
 *
 * @author sandeep.jeedula
 */
class DoctorsController extends AdminController
{

    private $_url_key = '/admin/doctors';
    private $_mapping_type = 'Doctor';
    private $_mapping_key = 'D';

    //put your code here

    public function doctors()
    {
        try {
            $groups = [];
            $this->setData($this->_url_key, 'view');
            if ($this->limitedAccess == 'All') {
                $doctors = doctors::where('is_delete', 0)->orderBy('id', 'asc')->paginate(10);
                $groups = Groups::where('is_delete', 0)->orderBy('group_id', 'asc')->get()->all();
            } else {
                $doctors = $this->getDoctorsByGroup();
            }
//            echo "<pre>";print_R($doctors);die;
            return view('Admin::doctors/doctors')->with(['doctorslist' => $doctors, 'groups' => $groups, 'role_id' => $this->roleId,
                'accessDetails' => $this->accessDetails, 'mapping_key' => $this->_mapping_key, 'mappingType' => $this->_mapping_type]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createDoctors()
    {
        try {
            $this->setData($this->_url_key, 'add');
            $doctors = [];
            $consultationTypes = ConsultationTypes::all()->where('is_delete', 0)->where('is_active', 1);
            $doctorMetaTypes = DoctorMetaTypes::all()->where('is_delete', 0)->where('is_active', 1);
            $languageData = Languages::all()->where('is_delete', 0);
            $specializations = Specialization::all()->where('is_delete', 0)->where('is_active', 1);
            return view('Admin::doctors/create_doctors')->with(['doctors' => $doctors, 'consultationTypes' => $consultationTypes,
                'doctorMetaTypes' => $doctorMetaTypes,
                'languageData' => $languageData, 'specializations' => $specializations]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function verifydoctor($doctorId, DoctorVerificationRequest $request)
    {
        try {
            $this->setData($this->_url_key, 'view');
            $doctorIdData = EncryptUrlParams::decrypt($doctorId);
            $doctorid = str_replace($this->_mapping_key, '', $doctorIdData);
            $groups = [];
            if (!$this->limitedAccess && Session::has('limited_access')) {
                $this->limitedAccess = Session::get('limited_access');
            } else {
                $this->getLimitedAccessData($this->_url_key);
            }
            $doctors = [];
            $doctors = doctors::where('id', $doctorid)->where('is_delete', 0)->first();
            if ($this->limitedAccess == 'All') {
                $groups = Groups::orderBy('group_id', 'asc')->get()->all();
                $users = Users::orderBy('user_id', 'asc')->get()->all();
            } else {
                $users = $this->getUsersByGroup();
            }
            if ($request->isMethod('post')) {
                $input = $request->validated();
                $doctorData = doctors::where('id', $doctorid)->first();
                $demail = $doctorData->email;
                $firstname = $doctorData->firstname;
                $doctorData->verification_summary = $request->verification_summary;

                if ($request->status == 'approved') {
                    $doctorData->is_verified = 1;
                    $doctorData->is_active = 1;
                    $doctorData->is_rejected = 0;
                } else {
                    $doctorData->is_rejected = 1;
                }
                $doctorData->verified_user = $request->verified_user;
                if ($doctorData->save()) {
                    if ($request->status == 'approved') {
                        Mail::send('Admin::doctor_confirmation',
                            array(
                                'firstname' => $firstname,
                                'demail' => $demail,
                            ), function ($message) use ($request) {
                                $message->to('needtomodify@asdas.com');
                                $message->subject('Account Verified successfully');
                                $message->from('admin@doctored.dev');
                            });
                    }
                    $msg = 'Doctor data updated successfully with status ' . ucfirst($request->status);
                    return redirect('admin/doctors')->with('success', $msg);
                }
            }
            return view('Admin::doctors/verify_doctor')->with(['doc' => $doctors,
                'limited_access' => $this->limitedAccess]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addDoctors(DoctorAddRequest $request)
    {
        try {
            $this->setData($this->_url_key, 'add');
            $requestParams = $this->filterParameters($request->validated());
//                echo "<pre>";print_R($requestParams);die;
            $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
            $max = DB::table('doctors')->max('id');
            if ($max == '') {
                $max = 1;
            } else {
                $max++;
            }
            $doctor_code = 'DMEBE' . date('y') . (1000 + $max);
            if ($id != 0) {
                $doctors = doctors::where('id', $id)->where('is_delete', 0)->first();
                // $doctors->doctorcode = $doctor_code;
                $doctors->title = $request->title;
                $doctors->firstname = $request->firstname;
                $doctors->lastname = $request->lastname;
//                    $doctors->phone = $request->phone;
                $doctors->phone = $request->phonecode . '-' . $request->phone;
                $doctors->email = $request->email;
                $doctors->licence = $request->licence;
                $doctors->opt_clinic = $request->opt_clinic;
                // $doctors->password = Hash::make($request->email);
                $doctors->terms = $request->terms;
                $doctors->gender = $request->gender;
                $this->setProfilePhoto($request, $doctors);

                $doctors->summary = $request->summary;
                $doctors->address_line1 = $request->address_line1;
                $doctors->address_line2 = $request->address_line2;
                $doctors->address_line3 = $request->address_line3;
                $doctors->address_city = $request->address_city;
                $doctors->address_state = $request->address_state;
                $doctors->address_country = $request->address_country;
                $doctors->address_postcode = $request->address_postcode;
                $doctors->timezone = $request->timezone;
                // $doctors->address_address = $request->address_address;
                // $doctors->address_long = $request->address_long;

                $doctors->activation_key = Hash::make($request->email);
                $doctors->visitor = $this->getUserIpAddr();
                $doctors->updated_by = $this->userId;
                $doctors->save();
            } else {
                $randomPassword = EncryptUrlParams::generateRandomString();
                $doctorsData = new doctors();
                $doctorsData->doctorcode = $doctor_code;
                $doctorsData->title = $request->title;
                $doctorsData->firstname = $request->firstname;
                $doctorsData->lastname = $request->lastname;
//                    $doctorsData->phone = $request->phone;
                $doctorsData->phone = $request->phonecode . '-' . $request->phone;
                $doctorsData->is_verified = 1;
                $doctorsData->email = $request->email;
                $doctorsData->licence = $request->licence;
                $doctorsData->opt_clinic = $request->opt_clinic;
//            $doctorsData->password = Hash::make($request->email);
//                    $doctorsData->password = Hash::make($randomPassword);
                $doctorsData->password = Hash::make('test@1234');
                $doctorsData->is_active = 1;
                $doctorsData->created_by = $this->userId;
                $doctorsData->terms = $request->terms;
                $doctorsData->gender = $request->gender;
                $doctorsData->dob = $request->dob;
                $doctorsData->photo = $request->photo;

                if ($request->hasFile('photo')) {
                    if ($request->file('photo')->isValid()) {
                        try {
                            $this->validate($request, [
                                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);

                            $file = $request->file('photo');
                            $name = $file->getClientOriginalName();
                            $request->file('photo')->move("uploads", $name);
                            $doctorsData->photo = $name;
                        } catch (FileNotFoundException $e) {

                        }
                    }
                }

                $doctorsData->summary = $request->summary;
                $doctorsData->address_line1 = $request->address_line1;
                $doctorsData->address_line2 = $request->address_line2;
                $doctorsData->address_line3 = $request->address_line3;
                $doctorsData->address_city = $request->address_city;
                $doctorsData->address_state = $request->address_state;
                $doctorsData->address_country = $request->address_country;
                $doctorsData->address_postcode = $request->address_postcode;
                $doctorsData->timezone = $request->timezone;
                // $doctorsData->address_address = $request->address_address;
                // $doctorsData->address_long = $request->address_long;
                $doctorsData->activation_key = Hash::make($request->email);
                $doctorsData->visitor = $this->getUserIpAddr();
                $doctorsData->save();
                $id = $doctorsData->id;

                Mail::send(
                    'Frontend::doctor_notification_one',
                    [
                        'doctorName' => $doctorsData->title . " " . $doctorsData->firstname,
                    ],
                    function ($message) use ($request) {
                        $message->subject('Account Created');
                        $message->from(getenv('MAIL_FROM_ADDRESS'));
                        $message->to($request->email);
                    }
                );
            }
            $requestParams = $this->setSpecialization(
                $requestParams,
                $id,
                $this->_mapping_type,
                $this->userId
            );
            if (isset($requestParams['languages']) && count($requestParams['languages']) > 0) {
                foreach ($requestParams['languages'] as $langId) {
                    if ($langId != '') {
                        $langDetails = LanguageMapping::where('module_mapping_type', $this->_mapping_type)
                            ->where('module_mapping_type_id', $id)
                            ->where('lang_mapping_id', $langId)->get()->all();
                        if (!$langDetails) {
                            $langData = new LanguageMapping();
                            $langData->module_mapping_type = $this->_mapping_type;
                            $langData->module_mapping_type_id = $id;
                            $langData->lang_mapping_id = $langId;
                            $langData->created_by = $this->userId;
                            $langData->updated_by = 0;
                            $langData->save();
                        }
                    }
                }
            } else {
                LanguageMapping::where('module_mapping_type', $this->_mapping_type)
                    ->where('module_mapping_type_id', $id)->delete();
            }
            $doctorMetaTypes = DoctorMetaTypes::all();
            $this->saveMetaTypeData(
                $id,
                $this->_mapping_type,
                $doctorMetaTypes,
                $requestParams,
                'dmetaname',
                'dmeta_id'
            );
            return Redirect::to('/admin/doctors');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editDoctors($doctorId)
    {
        try {
            $this->setData($this->_url_key, 'edit');
            $doctorIdData = EncryptUrlParams::decrypt($doctorId);
            $doctor_id = str_replace($this->_mapping_key, '', $doctorIdData);
            $doctors = [];

            if ($doctor_id) {
                $doctors = doctors::where('id', $doctor_id)->where('is_delete', 0)->first();
            }
            $phoneCode = '';
            $phoneNumber = '';
            if ($doctors) {
                if (isset($doctors->phone) && $doctors->phone != '') {
                    $phoneDetails = explode('-', $doctors->phone);
                    $phoneCode = isset($phoneDetails[0]) ? $phoneDetails[0] : '';
                    $phoneNumber = isset($phoneDetails[1]) ? $phoneDetails[1] : '';
                }
            }
            list($specializations, $specializationList, $consultationTypes,
                $consultationList, $consultationData) =
                $this->setSpecializationToConsultation
            ($doctor_id);

            $doctorMetaTypes = DoctorMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $docMetaData = MetatypeData::where('mapping_type', $this->_mapping_type)
                ->where('mapping_type_id', $doctor_id)->get()->all();
            $docMetaList = [];
            if ($docMetaData) {
                foreach ($docMetaData as $docMetaInfo) {
                    $docMetaList[$docMetaInfo->mapping_type_data_id] = $docMetaInfo->mapping_type_data_value;
                }
            }
            $languageData = Languages::all()->where('is_delete', 0);
            $languageMappingData = LanguageMapping::where('module_mapping_type', $this->_mapping_type)
                ->where('module_mapping_type_id', $doctor_id)->get()->all();
            $languageList = [];
            if ($consultationData) {
                foreach ($languageMappingData as $langInfo) {
                    $languageList[] = trim($langInfo->lang_mapping_id);
                }
            }
            return view('Admin::doctors/create_doctors')->with(['doctors' => $doctors, 'specializations' => $specializations,
                'specializationList' => $specializationList, 'consultationTypes' => $consultationTypes, 'languageData' => $languageData,
                'phoneCode' => $phoneCode, 'phoneNumber' => $phoneNumber, 'docMetaList' => $docMetaList, 'doctorMetaTypes' => $doctorMetaTypes,
                'selected_langs' => $languageList, 'consultationList' => $consultationList]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewDoctors($doctorId)
    {
        try {
            $this->setData($this->_url_key, 'view');
            $doctorIdData = EncryptUrlParams::decrypt($doctorId);
            $id = str_replace($this->_mapping_key, '', $doctorIdData);
            $doctors = [];

            if ($id) {
                $doctors = doctors::where('id', $id)->where('is_delete', 0)->first();
            }
            $specializationData = SpecializationMapping::join('specialization_types', 'specialization_types.id', '=', 'specialization_mapping.specialization_mapping_id')
                ->where('specialization_mapping.mapping_type', $this->_mapping_type)
                ->where('specialization_mapping.mapping_type_id', $id)->get()->all();
//        echo "<pre>";print_r($specializationData);die;
            $specializationList = [];
            if ($specializationData) {
                foreach ($specializationData as $specializationInfo) {
                    $specializationList[] = $specializationInfo->specialization_name;
                }
            }
            $consultationData = ConsultationMapping::join('consultation_types', 'consultation_types.ctype_id', '=', 'consultation_mapping.consultation_id')
                ->where('consultation_mapping.mapping_type', $this->_mapping_type)
                ->where('consultation_mapping.mapping_type_id', $id)->get()->all();
            $consultationList = [];
            if ($consultationData) {
                foreach ($consultationData as $consultationInfo) {
                    $consultationList[] = $consultationInfo->ctype_name;
                }
            }

            return view('Admin::doctors/view_doctors')->with(['doctors' => $doctors,
                'specializationList' => $specializationList,
                'consultationList' => $consultationList]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteDoctors($doctorId)
    {
        try {
            $this->setData($this->_url_key, 'delete');
            $doctorIdData = EncryptUrlParams::decrypt($doctorId);
            $id = str_replace($this->_mapping_key, '', $doctorIdData);
            if ($id) {
                $doctors = doctors::where('id', $id)->where('is_delete', 0)->first();
                $doctors->is_delete = 1;
                $doctors->save();
                return Redirect::to('admin/doctors/');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function doctorHospitalMapping()
    {
        try {
            $userGroup = $this->getGroupByUser();
            $group_id = isset($userGroup->gid) ? $userGroup->gid : '';
            $hospitalData = $this->getHospitalByGroup($group_id);
            $doctors = $this->getDoctorsMapped($group_id);
            return view('Admin::doctors/doctor_hospital_map')->with(['userGroup' => $userGroup, 'hospitalData' => $hospitalData, 'doctorslist' => $doctors]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    /**
     * @param int $group_id
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function getDoctorsMapped(int $group_id)
    {
        try {
            return DB::table('hospital_doctor_mapping as hdm')
                ->join('doctors as d', 'hdm.doctor_id', '=', 'd.id')
                ->join('group_hospital_mapping as ghm', 'ghm.hospital_id', '=', 'hdm.hospital_id')
                ->join('group as g', 'g.gid', '=', 'ghm.group_id')
                ->join('hospitals as h', 'h.hospital_id', '=', 'hdm.hospital_id')
                ->where('ghm.group_id', '=', $group_id)
                ->select('*')
                ->orderBy('hdm.hospital_id', 'asc')
                ->get()->all();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function mapDoctorHospital(MapDoctorRequest $request)
    {
        $requestParams = $request->all();
        $hospitals = $requestParams['hospital'];
        $doctor_id = $requestParams['doctor_id'];
        foreach ($hospitals as $key => $hospitalId) {
            $docHosp = HospitalDoctorMapping::where('doctor_id', $doctor_id)
                ->where('hospital_id', $hospitalId)->get()->all();
            if (count($docHosp) == 0) {
                $hospitalDoctorMap = new HospitalDoctorMapping();
                $hospitalDoctorMap->hospital_id = $hospitalId;
                $hospitalDoctorMap->doctor_id = $doctor_id;
                $hospitalDoctorMap->save();
            }
        }
        $msg = 'Doctor assigned to hospital successfully';
        return back()->with('success', $msg);
    }

    public function getDoctors(Request $request)
    {
        try {
            $this->setData($this->_url_key, 'view');
            $data = $request->all();
            $term = isset($data['term']) ? $data['term'] : '';
            $prodAry = array();
            $doctorData = doctors::where('licence', 'ilike', '%' . $term . '%')
                ->where('is_verified', 1)->get()->all();
            if (count($doctorData) > 0) {
                foreach ($doctorData as $doctor) {
                    $doctor_id = $doctor->id;
                    $name = $doctor->firstname . ' ' . $doctor->lastname;
                    $prod_arr = array("label" => $name, "doctor_id" => $doctor_id);
                    array_push($prodAry, $prod_arr);
                }
            } else {
                $prod_arr = array("label" => 'No Result Found', 'value' => '');
                array_push($prodAry, $prod_arr);
            }
            echo json_encode($prodAry);
            die;
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function getDoctorDetails(Request $request)
    {
        try {
            $this->setData($this->_url_key, 'view');
            $data = $request->all();
            $doctor_id = isset($data['doctor_id']) ? $data['doctor_id'] : '';
            $doc_html = 'No doctor found';
            if ($doctor_id != '') {
                $doctorData = doctors::where('id', $doctor_id)->first();
                if (isset($doctorData->firstname)) {
                    $pic = $photo = isset($doctorData->photo) ? $doctorData->photo : '';
                    if ($photo == '') {
                        $pic = '/material/global/portraits/5.jpg';
                    }
                    $doc_html = '<div class="col-md-2">
                        <img src="' . $pic . '" width="50px" height="50px">
                      </div>
                      <div class="col-md-4">
                        Name: ' . $doctorData->firstname . ' ' . $doctorData->lastname . '<br/>
                        Licence: ' . $doctorData->licence . '<br/>
                        Email: ' . $doctorData->email . '<br/>
                        Phone : ' . $doctorData->phone . '<br/>
                        Doctor Code: ' . $doctorData->doctorcode . '<br/>
                      </div>';
                }
            }
            return json_encode(['status' => 200, 'response' => $doc_html]);
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function deleteDoctorMapping(Request $request)
    {
        $requestParams = $request->all();
        $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
        if ($id) {
            DB::table('hospital_doctor_mapping')->where('hd_mapping_id', $id)->delete();
            $msg = 'Doctor removed from hospital successfully';
            return back()->with('success', $msg);
        }
    }

    public function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}
