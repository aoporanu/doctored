<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSaveRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Modules\Admin\Models\DoctorMetaTypes;
use App\Modules\Admin\Models\LanguageMapping;
use App\Modules\Admin\Models\Languages;
use App\Modules\Admin\Models\MetatypeData;
use App\Modules\Admin\Models\PageElements as PageElements;
use App\Modules\Admin\Models\Pages as Pages;
use App\Modules\Frontend\Models\ConsultationData;
use App\Modules\Frontend\Models\Contacts as Contact;
use App\Modules\Frontend\Models\Doctor;
use App\Modules\Frontend\Models\Slots as Slots;
use App\Modules\Frontend\Services\GroupService;
use App\Modules\Frontend\Services\HospitalService;
use App\Modules\Frontend\Services\SlotsService;
use ErrorException;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class IndexController extends Controller
{
    private HospitalService $service;
    private GroupService $groupService;
    private SlotsService $slotService;

    public function __construct(HospitalService $service, GroupService
    $groupService, SlotsService $slotService)
    {
        $this->service = $service;
        $this->groupService = $groupService;
        $this->slotService = $slotService;
        parent::__construct();
    }

    public function settimezone($id)
    {
        $timezone = DB::table('timezones')->select('timezone')->where('countrycode', $id)->get()->first();
        date_default_timezone_set($timezone->timezone);
    }

    public function home()
    {
        $homeRequired = array('our-vision', 'frequently-asked-questions', 'contact', 'why-choose-doctored', 'store-records', 'reach-doctors', 'language-support', 'how-does-it-work', 'multi-speciality-clinics');
        $pagesData = Pages::select('title', 'slug', 'description')->whereIn('slug', $homeRequired)->get()->toArray();
        $pageData = array();
        foreach ($pagesData as $pd_key => $pd_val) {
            $pageData[$pd_val['slug']] = $pd_val;
        }
        $page_elements = PageElements::select('element_name', 'element_value')->where('page_id', 9)->get()->toArray();


        return view('Frontend::home')->with(compact('pageData', 'page_elements'));
    }

    public function fetchSlotsByDoctor(Request $request)
    {
        $data = $request->all();
        $did = $data['id'];
        $slots = Slots::select('id', 'booking_date', 'booking_time_long', 'hospital_id', 'doctor_id', 'screen_id')->where('doctor_id', $did)->orderBy('booking_date', 'asc')
            ->get()
            ->toArray();
        $design = "<h2>Choose an appointment:</h2>";
        if (count($slots) > 0) {
            $dates = [];
            $design = $this->slotService->restructureSlots($slots, $dates, $design);
        } else {
            $design .= " Currently No Slots available";
        }
        echo $design;
    }

    public function fetchSlotsByHospital(Request $request)
    {
        $data = $request->all();
        $hospital = $data['id'];
        $slots = Slots::select('id', 'booking_date', 'booking_time_long', 'hospital_id', 'doctor_id', 'screen_id')->where('hospital_id', $hospital)->orderBy('booking_date', 'asc')
            ->get()
            ->toArray();
        $design = "<h2>Choose an appointment:</h2>";
        if (count($slots) > 0) {
            $dates = [];
            $design = $this->slotService->restructureSlots($slots, $dates, $design);
            $design .= "";
        } else {
            $design .= " Currently No Slots available";
        }
        echo $design;

        //  return view('Frontend::slots/slotdetails')        ->with(compact('doctorInfo','screen_id','restructure','slots_length','hospital'));
    }

    public function hospitalProfile($id)
    {
        try {
            $hData = $this->service->buildHospitalProfile($id);
            return view('Frontend::profile/hospital_profile')
                ->with(compact('hData'));
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function groupProfile($id)
    {
        try {
            $groupData = $this->groupService->buildGroupProfile($id);

            return view('Frontend::profile/group_profile')
                ->with(compact('groupData'));
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function doctorProfile()
    {
        $info = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
        $id = $info['doctorcode'];

        try {
            list($doctorInfo, $doctordata) = $this->loadDoctorInfo($id);

            if ($doctordata) {
                if (isset($doctordata[0]->phone) && $doctordata[0]->phone != '') {
                    $phoneDetails = explode('-', $doctordata[0]->phone);
                    $doctordata[0]->phoneCode = isset($phoneDetails[0]) ? $phoneDetails[0] : '';
                    $doctordata[0]->phoneNumber = isset($phoneDetails[1]) ? $phoneDetails[1] : '';
                }
            }
            //consultations
            list($consultations, $allCTypes) = $this->constructConsultations($id);

            $allCTypes = json_encode($allCTypes);

            //languages
            $languages = DB::table('lang_mapping')
                ->where('lang_mapping.module_mapping_type', 'Doctor')
                ->where('doctors.doctorcode', $id)
                ->leftjoin('doctors', 'lang_mapping.module_mapping_type_id', 'doctors.id')
                ->leftjoin('languages', DB::raw('CAST(languages.id AS varchar)'), 'lang_mapping.lang_mapping_id')
                ->get()->toArray();
            list($languageList, $specialization, $metadata, $slotsQuery) = $this->slotService->buildSlots($languages, $id);

            $doctorMetaTypes = DoctorMetaTypes::all()->where('is_active', '1')->where('is_delete', 0);
            list($docMetaList, $slots) = $this->docMetaData($id, $slotsQuery);

            return view('Frontend::profile/doctor_profile')
                ->with(
                    compact(
                        'doctordata',
                        'consultations',
                        'languages',
                        'languageData',
                        'languageList',
                        'specialization',
                        'metadata',
                        'slots',
                        'allCTypes'
                    )
                )
                ->with(['doctorMetaTypes' => $doctorMetaTypes, 'docMetaList' => $docMetaList, 'doctorInfo' => $doctorInfo]);
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function editDoctorProfile(Request $request, $id)
    {
        try {
            list($doctorInfo, $doctordata) = $this->loadDoctorInfo($id);

            if ($doctordata) {
                if (isset($doctordata[0]->phone) && $doctordata[0]->phone != '') {
                    $phoneDetails = explode('-', $doctordata[0]->phone);
                    $doctordata[0]->phoneCode = isset($phoneDetails[0]) ? $phoneDetails[0] : '';
                    $doctordata[0]->phoneNumber = isset($phoneDetails[1]) ? $phoneDetails[1] : '';
                }
            }
            //consultations
            list($consultations, $allctypes) = $this->constructConsultations($id);

            $allctypes = json_encode($allctypes);

            $languageData = Languages::all()->where('is_delete', 0);
            //languages
            $languages = DB::table('lang_mapping')
                ->where('lang_mapping.module_mapping_type', 'Doctor')
                ->where('doctors.doctorcode', $id)
                ->leftjoin('doctors', 'lang_mapping.module_mapping_type_id', '=', 'doctors.id')
                ->leftjoin('languages', DB::raw('CAST(languages.id AS varchar)'), '=', 'lang_mapping.lang_mapping_id')
                ->get()->toArray();
            list($languageList, $specialization, $metadata, $slotsquery) = $this->slotService->buildSlots($languages, $id);


            $doctorMetaTypes = DoctorMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            list($docMetaList, $slots) = $this->docMetaData($id, $slotsquery);

            return view('Frontend::profile/editdoctorprofile')
                ->with(compact('doctordata', 'consultations', 'languages', 'languageData', 'languageList', 'specialization', 'metadata', 'slots', 'allctypes'))
                ->with(['doctorMetaTypes' => $doctorMetaTypes, 'docMetaList' => $docMetaList, 'doctorInfo' => $doctorInfo]);
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function updateDoctorProfile(UpdateDoctorRequest $request)
    {
        dd($request->validated());
        try {
            $requestParams = $this->filterParameters($request->validated());
            Log::info('we are herer ' . __FUNCTION__ . ' ' . __LINE__);
            Log::info($requestParams);
            $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
            $max = DB::table('doctors')->max('id');
            if ($max == '') {
                $max = 1;
            } else {
                $max++;
            }
            if ($id != 0) {
                $doctors = Doctor::where('id', $id)->where('is_delete', 0)->first();
                $doctors->title = $request->title;
                $doctors->firstname = $request->firstname;
                $doctors->lastname = $request->lastname;
                $doctors->phone = $request->phonecode . '-' . $request->phone;
                $doctors->email = $request->email;
                $doctors->licence = $request->licence;
                $doctors->terms = $request->terms;
                $doctors->dob = $request->dob;

                if ($request->hasFile('photo')) {
                    if ($request->file('photo')->isValid()) {
                        try {
                            $this->validate($request, [
                                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);

                            $file = $request->file('photo');
                            $name = $file->getClientOriginalName();
                            $request->file('photo')->move("uploads", $name);
                            $doctors->photo = $name;
                        } catch (FileNotFoundException $e) {
                            Log::error($e->getMessage());
                        }
                    }
                }

                if ($request->hasFile('licence_file')) {
                    if ($request->file('licence_file')->isValid()) {
                        try {
                            $this->validate($request, [
                                'licence_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);

                            $file = $request->file('licence_file');
                            $name = $file->getClientOriginalName();
                            $request->file('licence_file')->move("uploads", $name);
                            $doctors->licence_file = $name;
                        } catch (FileNotFoundException $e) {
                            Log::error($e->getMessage());
                        }
                    }
                }

                $doctors->address_line1 = $request->address_line1;
                $doctors->address_line2 = $request->address_line2;
                $doctors->address_city = $request->address_city;
                $doctors->address_state = $request->address_state;
                $doctors->address_country = $request->address_country;
                $doctors->address_postcode = $request->address_postcode;
                $doctors->visitor = $this->getUserIpAddr();
                $doctors->updated_by = $id;
                dd($doctory);
                $doctors->save();
            }
            if (isset($requestParams['languages']) && count($requestParams['languages']) > 0) {
                foreach ($requestParams['languages'] as $langId) {
                    if ($langId != '') {
                        $langDetails = LanguageMapping::where('module_mapping_type', 'Doctor')
                            ->where('module_mapping_type_id', $id)
                            ->where('lang_mapping_id', $langId)->get()->all();
                        if (!$langDetails) {
                            $langData = new LanguageMapping();
                            $langData->module_mapping_type = 'Doctor';
                            $langData->module_mapping_type_id = $id;
                            $langData->lang_mapping_id = $langId;
                            $langData->created_by = $id;
                            $langData->updated_by = 0;
                            $langData->save();
                        }
                    }
                }
            } else {
                LanguageMapping::where('module_mapping_type', 'Doctor')
                    ->where('module_mapping_type_id', $id)->delete();
            }
            return redirect()->back()->withSuccess('Updated successfully!');
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    public function updateDoctorMetaData(Request $request)
    {
        try {
            $requestParams = $this->filterParameters($request->all());
            $doctorId = $request->docId;
            $metaId = $request->metaId;
            $metaDataValue = $requestParams['metaValue'];
            $metaData = MetatypeData::where('metatype_data.mapping_type', 'Doctor')
                ->where('metatype_data.is_active', 1)
                ->where('metatype_data.mapping_type_id', $doctorId)
                ->where('metatype_data.mapping_type_data_id', $metaId)
                ->first();
            if ($metaData) {
                $metaData->mapping_type_data_value = $metaDataValue;
                $metaData->save();
            } else {
                $metaTypeData = new MetatypeData();
                $metaTypeData->mapping_type = 'Doctor';
                $metaTypeData->mapping_type_id = $doctorId;
                $metaTypeData->mapping_type_data_id = $metaId;
                $metaTypeData->mapping_type_data_value = $metaDataValue;
                $metaTypeData->created_by = 1;
                $metaTypeData->updated_by = 0;
                $metaTypeData->save();
            }
            return json_encode(['status' => 'success', 'message' => 'Updated successfully!']);
        } catch (Exception $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
            return json_encode(['status' => 'falied', 'message' => 'Unable to updated']);
        }
    }

    public function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    public function getHospitalDoctorsList(Request $request)
    {

        try {
            $data = $request->all();
            $term = isset($data['term']) ? $data['term'] : '';
            $result = DB::select("SELECT id,name,label,code,category,type FROM view_home_search where LOWER(name) like LOWER('%" . $term . "%') ");
            return json_encode($result);
        } catch (ErrorException $ex) {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }
    }

    public function forgot()
    {
        return view('Frontend::forgot');
    }

    public function homecontactsave(ContactSaveRequest $request)
    {
        $input = $request->all();

        $check = true;
        // $check = Post::create($input);
        $input = $request->all();
        $user = Contact::create($input);
        Mail::send('Frontend::contact_email', array(
            'firstname'   => $request->get('firstname'),
            'lastname'    => $request->get('lastname'),
            'phone'       => $request->get('phone'),
            'email'       => $request->get('email'),
            'description' => $request->get('description'),
        ), function ($message) use ($request) {
            $message->subject('Contact Information.');
            $message->from('admin@doctored.com');
            $message->to($request->email);
        });

        $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
        if ($user) {
            $arr = array('msg' => 'Thank you for contacting us', 'status' => true);
        }

        return response()->json($arr);
    }

    public function contactus(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'firstname' => 'required', 'phone' => 'phone:GB', 'email' => 'required|email', 'description' => 'required'
            ], ['firstname.required' => 'First Name is required', 'phone.required' => 'Phone Number  is required', 'email.required' => 'Emai Address is required ', 'description.required' => 'Message is required']);

            $input = $request->all();
            $user = Contact::create($input);
            if ($user) {
                Mail::send('Frontend::contact_email', array(
                    'firstname'   => $request->get('firstname'),
                    'lastname'    => $request->get('lastname'),
                    'phone'       => $request->get('phone'),
                    'email'       => $request->get('email'),
                    'description' => $request->get('description'),
                ), function ($message) use ($request) {
                    $message->from('admin@doctored.dev');
                    $message->to($request->email);
                });
            } else {
                return back()
                    ->with('errors', 'Could not save contact');
            }

            return back()
                ->with('success', 'Thank you for contacting us!');
        }

        return view('Frontend::contactus');
    }

    public function show($page)
    {
        $pagedata = DB::table('pages')->where('slug', $page)->first();
        if (isset($pagedata->id)) {
            $pid = $pagedata->id;
            $page_elements = DB::table('page_elements')->where('page_id', $pid)->get();
        } else {
            $page_elements = array();
        }
        return view('Frontend::show', ['pagedata' => $pagedata, 'page_elements' => $page_elements]);
    }

    public function managePrescription()
    {
        auth()->guard('auth:doctor');
        try {
            $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
            return view('Frontend::bookingappointment/manage_prescription')->with(['doctorInfo' => $doctorInfo]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function manageReports()
    {
        die('xxxx');
        Auth::guard('auth:doctor');
        try {
            $doctorInfo = json_decode(json_encode(Auth::guard('auth:doctor')->user()), 1);
            return view('Frontend::bookingappointment/manage_reports')->with(['doctorInfo' => $doctorInfo]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function doctorConsultation($slotId)
    {
        try {
            list($slotData, $languageData, $consultationTypesObj, $consultationTypesDataObj, $consultationTypeDataList) = $this->slotService->buildConsultationTypes($slotId);
            $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
            return view('Frontend::bookingappointment/doctor_consultation')->with([
                'doctorInfo'               => $doctorInfo, 'slotData' => $slotData,
                'languageData'             => $languageData, 'consultationTypesObj' => $consultationTypesObj, 'consultationTypesDataObj' => $consultationTypesDataObj,
                'consultationTypeDataList' => $consultationTypeDataList
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    public function updateDoctorConsultationData(Request $request)
    {
        try {
            $requestParams = $this->filterParameters($request->all());
            $doctorId = $requestParams['doctorId'];
            $patientId = $requestParams['patientId'];
            $hospitalId = $requestParams['hospitalId'];
            $slotId = $requestParams['slotId'];
            $consultationDataType = $requestParams['consultationDataType'];
            $consultationData = $requestParams['data'];
            $metaData = ConsultationData::where('consultation_data.doctor_id', $doctorId)
                ->where('consultation_data.patient_id', $patientId)
                ->where('consultation_data.hospital_id', $hospitalId)
                ->where('consultation_data.slot_id', $slotId)
                ->where('consultation_data.consultation_type', $consultationDataType)
                ->first();
            if ($metaData) {
                $metaData->consultation_type_data = $consultationData;
                $metaData->save();
            } else {
                $metatypeData = new ConsultationData();
                $metatypeData->doctor_id = $doctorId;
                $metatypeData->patient_id = $patientId;
                $metatypeData->hospital_id = $hospitalId;
                $metatypeData->slot_id = $slotId;
                $metatypeData->consultation_type = $consultationDataType;
                $metatypeData->consultation_type_data = $consultationData;
                $metatypeData->created_by = 1;
                $metatypeData->updated_by = 0;
                $metatypeData->save();
            }
            return json_encode(['status' => 'success', 'message' => 'Updated successfully!']);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return json_encode(['status' => 'failed', 'message' => $ex->getMessage()]);
        }
    }

    public function confirmDoctorConsultationData(Request $request)
    {
        try {
            $requestParams = $this->filterParameters($request->all());
            $doctorId = $requestParams['doctor_id'];
            $patientId = $requestParams['patient_id'];
            $hospitalId = $requestParams['hospital_id'];
            $slotId = $requestParams['slotid'];
            $tempArray = ['severity', 'doctor_notes', 'Prescription', 'Reports'];
            $fileArray = ['doctor_notes_file', 'prescriptions_file', 'reports_file'];
            foreach ($tempArray as $consultationDataType) {
                $consultationData = isset($requestParams[$consultationDataType]) ? $requestParams[$consultationDataType] : '';
                $metaData = ConsultationData::where('consultation_data.doctor_id', $doctorId)
                    ->where('consultation_data.patient_id', $patientId)
                    ->where('consultation_data.hospital_id', $hospitalId)
                    ->where('consultation_data.slot_id', $slotId)
                    ->where('consultation_data.consultation_type', $consultationDataType)
                    ->first();
                if ($metaData) {
                    $metaData->consultation_type_data = $consultationData;
                    $metaData->save();
                } else {
                    $metatypeData = new ConsultationData();
                    $metatypeData->doctor_id = $doctorId;
                    $metatypeData->patient_id = $patientId;
                    $metatypeData->hospital_id = $hospitalId;
                    $metatypeData->slot_id = $slotId;
                    $metatypeData->is_lock = 1;
                    $metatypeData->consultation_type = $consultationDataType;
                    $metatypeData->consultation_type_data = $consultationData;
                    $metatypeData->created_by = $doctorId;
                    $metatypeData->updated_by = 0;
                    $metatypeData->save();
                }
            }
            foreach ($fileArray as $fileName) {
                if ($request->hasFile($fileName)) {
                    foreach ($request->$fileName as $fileData) {
                        if ($fileData->isValid()) {
                            try {
                                $file = $fileData;
                                $name = $file->getClientOriginalName();

                                $file_name = $file->getClientOriginalName();
                                $file_ext = $file->getClientOriginalExtension();

                                $fileInfo = pathinfo($file_name);
                                $filename = $fileInfo['filename'];
                                $newName = '#' . $slotId . '_' . $fileName . '_' . strtotime(date('Y-m-d H:i:s')) . "." . $file_ext;
                                $destinationPath = 'uploads/frontend/consultations/';
                                $file->move($destinationPath, $newName);

                                $metatypeData = new ConsultationData();
                                $metatypeData->doctor_id = $doctorId;
                                $metatypeData->patient_id = $patientId;
                                $metatypeData->hospital_id = $hospitalId;
                                $metatypeData->slot_id = $slotId;
                                $metatypeData->is_lock = 1;
                                $metatypeData->consultation_type = $fileName;
                                $metatypeData->consultation_type_data = $destinationPath . $newName;
                                $metatypeData->created_by = $doctorId;
                                $metatypeData->updated_by = 0;
                                $metatypeData->save();
                            } catch (Illuminate\Filesystem\FileNotFoundException $ex) {
                                Log::error($ex->getMessage());
                                Log::error($ex->getTraceAsString());
                                return redirect()->back()->withError($ex->getMessage());
                            }
                        }
                    }
                }
            }
            return redirect()->route('doctor.dashboard')
                ->withSuccess('Consultation Completed');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return array
     */
    private function loadDoctorInfo($id): array
    {
        $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
        $docselect = [
            'doctors.id', 'doctors.doctorcode', 'doctors.phone', 'doctors.email', 'licence', 'gender', 'dob', 'photo', 'summary', 'timezone',
            'address_line1', 'address_line2', 'address_line3', 'address_postcode', 'title', 'licence_file',
            'address_city', 'address_state', 'address_country',
            'address_place', 'address_lat', 'address_long', 'firstname', 'lastname',
            DB::raw("CONCAT(doctors.firstname, ' ' ,doctors.lastname) as dname")
            , 'cities.name as cityname', 'states.name as statename', 'countries.name as countryname'
        ];
        $doctordata = DB::table('doctors')->select($docselect)->where('doctorcode', $id)
            ->leftjoin('cities', DB::raw('CAST(cities.id AS varchar)'), 'address_city')
            ->leftjoin('states', DB::raw('CAST(states.id AS varchar)'), 'address_state')
            ->leftjoin('countries', 'countries.sortname', 'address_country')
            ->get()->toArray();
        return array($doctorInfo, $doctordata);
    }

    /**
     * @param $id
     * @param Builder $slotsquery
     * @return array
     */
    private function docMetaData($id, Builder $slotsquery): array
    {
        $docMetaData = MetatypeData::leftjoin('doctors', 'doctors.id', '=', 'metatype_data.mapping_type_id')
            ->where('metatype_data.mapping_type', 'Doctor')
            ->where('doctors.doctorcode', $id)->get()->all();
        $docMetaList = [];
        if ($docMetaData) {
            foreach ($docMetaData as $docMetaInfo) {
                $docMetaList[$docMetaInfo->mapping_type_data_id] = $docMetaInfo->mapping_type_data_value;
            }
        }

        $slots = $slotsquery->get()->toArray();
        return array($docMetaList, $slots);
    }

}
