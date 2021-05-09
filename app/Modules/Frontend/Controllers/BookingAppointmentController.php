<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Hospitals;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Log;
use Mail;
use Redirect;
use View;
use Session;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Doctors as Doctors;
use App\Modules\Frontend\Models\Patient as Patient;
use App\Modules\Admin\Models\Appointments as Appointments;
use App\Modules\Frontend\Models\Slots as Slots;
use App\Modules\Admin\Models\ConsultationTypes as ConsultationTypes;
use \App\Modules\Admin\Models\SpecializationMapping as SpecializationMapping;
use Auth;

class BookingAppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:patient'); //Use in every method as index need not require any login
    }

    public function managebookings(Request $request)
    {
        $info = json_decode(json_encode(Auth::guard('patient')->user()), 1);
        $requestParams = $request->all();
        return view('Frontend::bookingappointment/managebookings')
            ->with(compact('info'));

    }

    /**
     * @param Request $request
     */
    public function initiateBooking(Request $request)
    {
        try {
            $requestParams = $request->all();
            unset($requestParams['atime']);
            unset($requestParams['divdates']);
            unset($requestParams['available_types']);
            //	 print_r($requestParams); exit;


            $appointmentData = new Appointments();
            $appointmentData->booking_id = $this->getrandomString(15);
            if ($requestParams['doctor_id'] != '') {
                $appointmentData->doctor_id = $requestParams['doctor_id'];
            }
            if ($requestParams['patient_id'] != '') {
                $appointmentData->patient_id = $requestParams['patient_id'];
            }
            if ($requestParams['inputStatehospital'] != '') {
                $appointmentData->hospital_id = $requestParams['inputStatehospital'];
            }
            if ($requestParams['inputStateDates'] != '') {
                $appointmentData->booking_date = $requestParams['inputStateDates'];
            }
            if ($requestParams['inputStateAppTime'] != '') {
                $appointmentData->booking_time_long = base64_decode($requestParams['inputStateAppTime']);
                $stime = explode(' ', base64_decode($requestParams['inputStateAppTime']));
                $time = $stime[0] . ' ' . $stime[1];
                $chunks = explode(':', $time);
                if (strpos($time, 'AM') === false && $chunks[0] !== '12') {
                    $chunks[0] = $chunks[0] + 12;
                } else if (strpos($time, 'PM') === false && $chunks[0] == '12') {
                    $chunks[0] = '00';
                }

                $datesele = preg_replace('/\s[A-Z]+/s', '', implode(':', $chunks));
                $datesele = explode('-', $datesele);
                $datesele = $datesele[0];

                $appointmentData->booking_start_time = $datesele; //temp
            }
            if ($requestParams['inputStateAppTime'] != '') {
                $appointmentData->booking_type = $requestParams['inputStateCtype'];

            }
            if ($requestParams['screen_id'] != '') {
                $appointmentData->screen_id = $requestParams['screen_id'];
            }
            if ($requestParams['slotid'] != '') {
                $appointmentData->slotid = $requestParams['slotid'];
            }
            if ($requestParams['atitle'] != '') {
                $appointmentData->title = $requestParams['atitle'];
            }
            if ($requestParams['email'] != '') {
                $appointmentData->email = $requestParams['email'];
            }
            if ($requestParams['phone'] != '') {
                $appointmentData->phone = $requestParams['phone'];
            }

            if ($requestParams['description'] != '') {
                $appointmentData->description = $requestParams['description'];
            }
            if ($requestParams['country'] != '') {
                $appointmentData->booking_from_country = $requestParams['country'];
                $timezone = DB::table('timezones')->select('timezone', 'utc_offset')->
                where('countrycode', $appointmentData->booking_from_country)
                    //->where('comments','')
                    ->get()->first();
                //	print_r( $timezone);exit;
                $total_timezone = "(" . $timezone->utc_offset . ")" . $timezone->timezone;
                $appointmentData->booking_timezone = $total_timezone;
            }
            if ($requestParams['doctor_concent'] != '') {
                $appointmentData->doctor_concent = $requestParams['doctor_concent'];
            }
            if ($requestParams['patien_concent'] != '') {
                $appointmentData->patien_concent = $requestParams['patien_concent'];
            }
            if ($requestParams['sysip'] != '') {
                $appointmentData->booking_sysip = $requestParams['sysip'];
            }


            $appointmentData->payment_status = 'Pending';
            $appointmentData->booking_status = 'confirmed';
            $appointmentData->appointment_status = 'booked';

            //print_r($appointmentData->toArray());exit;

            $doctorName = $this->getDoctorPatientName($appointmentData->doctor_id, 'Doctor');
            $patientName = $this->getDoctorPatientName($appointmentData->patient_id, 'Patient');
            $hopitalName = $this->getHospitalName($appointmentData->hospital_id);
            $booking_type = DB::table('consultation_types')->select('ctype_name')->where('ctype_id', $appointmentData->booking_type)->get()->first();
            //print_r($booking_type->ctype_name);exit;
            if ($appointmentData->save()) {
                Mail::send('Frontend::slot_confirmation_doctor_email',
                    array(
                        'patientName' => $patientName,
                        'doctorName' => $doctorName,
                        'hospitalName' => $hopitalName,
                        'type' => $booking_type->ctype_name,
                        'data' => $appointmentData->toArray()
                    ), function ($message) use ($request) {
                        $message->subject('Booking Information ');
                        $message->from(getenv('MAIL_FROM_ADDRESS'));
                        $message->to($request->email);
                    });

                Mail::send('Frontend::slot_confirmation_patient_email',
                    array(
                        'patientName' => $patientName,
                        'doctorName' => $doctorName,
                        'hospitalName' => $hopitalName,
                        'type' => $booking_type->ctype_name,
                        'data' => $appointmentData->toArray()
                    ), function ($message) use ($request) {
                        $message->subject('Appointment Booking Successful.');
                        $message->from(getenv('MAIL_FROM_ADDRESS'));
                        $message->to($request->email);
                    });
                $query = DB::table('slots')
                    ->where('id', $requestParams['slotid'])
                    ->update(['booking_status' => 'booked']);
                if ($query) {
                    echo "success";
                } else {
                    echo "failed";
                }
                // return back()->with('success', 'Booking Confirmed');

            }


        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }


    }

    public function index(Request $request)
    {
        $info = json_decode(json_encode(Auth::guard('patient')->user()), 1);
        $requestParams = $request->all();

        //print_r($requestParams); exit;
        /* Check is able to fetch data from doctor profile or Not */
        if (isset($requestParams['docid']) && $requestParams['docid'] != "") {

            $id = $requestParams['docid'];
            if (isset($requestParams['hid'])) {
                $hid = $requestParams['hid'];
            }
            $docselect = ['doctors.id', 'doctors.doctorcode', 'doctors.phone', 'doctors.email', 'licence', 'gender', 'dob', 'photo', 'summary', 'timezone',
                'address_line1', 'address_line2', 'address_line3', 'address_postcode',
                //'address_city', 'address_state','address_country',
                'address_place', 'address_lat', 'address_long',
                DB::raw("CONCAT(doctors.firstname, ' ' ,doctors.lastname) as dname")
                , 'cities.name as cityname', 'states.name as statename', 'countries.name as countryname'
            ];
            $doctordata = DB::table('doctors')->select($docselect)->where('doctorcode', $id)
                ->leftjoin('cities', DB::raw('CAST(cities.id AS varchar)'), 'address_city')
                ->leftjoin('states', DB::raw('CAST(states.id AS varchar)'), 'address_state')
                ->leftjoin('countries', 'countries.sortname', 'address_country')
                ->get()->toArray();
            list($consultations, $allctypes) = $this->constructConsultations($id);
            // $allctypes = json_encode($allctypes);
            //print_r($allctypes);exit;
            //languages
            $languages = DB::table('lang_mapping')
                ->select('languages.*')
                ->where('lang_mapping.module_mapping_type', 'Doctor')
                ->where('doctors.doctorcode', $id)
                ->leftjoin('doctors', 'lang_mapping.module_mapping_type_id', 'doctors.id')
                ->leftjoin('languages', 'languages.id', 'lang_mapping.lang_mapping_id')
                ->get()->toArray();

            //specialization
            $specialization = DB::table('specialization_mapping')
                ->select('specialization_types.specialization_shortcode')
                ->where('specialization_mapping.mapping_type', 'Doctor')
                ->where('doctors.doctorcode', $id)
                ->leftjoin('doctors', 'specialization_mapping.mapping_type_id', 'doctors.id')
                ->leftjoin('specialization_types', 'specialization_types.id', 'specialization_mapping.specialization_id')
                ->get()->toArray();
            $slotsquery = DB::table('slots')
                ->select('hospitals.hospital_name', 'slots.hospital_id', 'booking_start_time', 'slots.id as slotid', 'screen_id', 'hospital_name', 'shift', 'booking_date', 'booking_time_long', 'available_types')
                ->where('slots.is_delete', '0')
                ->where('slots.is_active', '1')
                ->where('booking_date', '>=', date('d-m-Y'))
                ->where('doctors.doctorcode', $id)
                ->leftjoin('doctors', 'slots.doctor_id', 'doctors.id')
                ->leftjoin('hospitals', 'slots.hospital_id', 'hospitals.hospital_id');

            if (isset($hid) && $hid != '') {
                //	$slotsquery->where('slots.hospital_id',$hid);
            }


            $slots = $slotsquery->get()->toArray();
            return view('Frontend::bookingappointment/bookingappointment')
                ->with(compact('doctordata', 'consultations', 'languages', 'specialization', 'slots', 'allctypes', 'requestParams', 'info'));


        } else {
            return back()->with('success', 'Welecome to booking processs..please try again');
        }
        /* End of Check is able to fetch data from doctor profile or Not */


    }

    /**
     * @param Request $request
     */
    public function fetchSlotTimesByDate(Request $request)
    {
        $requestParams = $request->all();
        $hid = $requestParams['hid'];
        $id = $requestParams['docid'];
        $sdate = $requestParams['sdate'];
        $selected_time = base64_encode($requestParams['app_time']);
        $slots = DB::table('slots')
            ->select('booking_time_long as stime')
            ->distinct('booking_start_time')
            ->orderBy('booking_start_time', 'asc')
            ->where('slots.is_delete', '0')
            ->where('slots.is_active', '1')
            ->where('booking_date', $sdate)
            ->where('slots.hospital_id', $hid)
            ->where('slots.booking_status', 'available')
            ->where('slots.doctor_id', $id)->get()->toArray();

        $totalSlots = array();
        foreach ($slots as $sk => $sv) {
            $totalSlots[] = $sv->stime;
        }
        $totalSlots = array_unique($totalSlots);
        $design = '<option value="">Choose..</option>';
        $selected = '';
        foreach ($totalSlots as $ts_key => $ts_val) {
            if ($selected_time == base64_encode($ts_val)) {
                $selected = ' selected ';
            } else {
                $selected = '';
            }
            $design .= '<option ' . $selected . ' value="' . base64_encode($ts_val) . '">' . $ts_val . '</option>';
        }
        echo $design;
    }

    /**
     * @param Request $request
     */
    public function fetchConsulationsByDate(Request $request)
    {
        $requestParams = $request->all();
        $hid = $requestParams['hid'];
        $id = $requestParams['docid'];
        $sdate = $requestParams['sdate'];
        $time = base64_decode($requestParams['time']);
        $selectedtype = $requestParams['selectedtype'];
        $slots = DB::table('slots')
            ->select('available_types', 'screen_id', 'id')
            ->where('slots.is_delete', '0')
            ->where('slots.is_active', '1')
            ->where('booking_time_long', $time)
            ->where('booking_date', $sdate)
            ->where('slots.hospital_id', $hid)
            ->where('slots.doctor_id', $id)
            ->where('slots.booking_status', 'available')
            ->get()->toArray();


        $totalSlots = array();
        $otherdata = array();
        foreach ($slots as $sk => $sv) {
            $totalSlots[] = $sv->available_types;
            $otherdata['screen_id'] = $sv->screen_id;
            $otherdata['id'] = $sv->id;
        }
        //print_r($otherdata);exit;
        $totalSlots = array_unique($totalSlots);

        $types = explode(',', $totalSlots[0]);

        $Consultation_types = DB::table('consultation_types')
            ->select('ctype_id', 'ctype_name')->whereIn('ctype_id', $types)->get()->toArray();

        $design = '<option value="">Choose..</option>';
        foreach ($Consultation_types as $ts_key => $ts_val) {
            if ($selectedtype == $ts_val->ctype_id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $design .= '<option ' . $select . ' value="' . $ts_val->ctype_id . '">' . ucfirst($ts_val->ctype_name) . '</option>';
        }
        $complete = array('design' => $design, 'otherdetails' => $otherdata);
        echo json_encode($complete);


    }

    /**
     * @param Request $request
     */
    public function fetchSlotDetailsByHospital(Request $request)
    {
        $requestParams = $request->all();
        $hid = $requestParams['hid'];
        $id = $requestParams['docid'];

        $slots = DB::table('slots')
            ->select('slots.hospital_id', 'slots.booking_status', 'booking_start_time', 'slots.id as slotid', 'screen_id', 'shift', 'booking_date', 'booking_time_long', 'available_types')
            ->where('slots.is_delete', '0')
            ->where('slots.is_active', '1')
            ->where('booking_date', '>=', date('d-m-Y'))
            ->where('slots.hospital_id', $hid)
            ->where('slots.doctor_id', $id)->get()->toArray();
        //->leftjoin('doctors',  'slots.doctor_id', 'doctors.id')
        //->leftjoin('hospitals',  'slots.hospital_id', 'hospitals.hospital_id')->toSql();

        //->get()->toArray();;
        $allctype = DB::table('consultation_types')->select('ctype_id', 'ctype_name', 'ctype_icon')->get()->toArray();
        $allctypes = array();

        foreach ($allctype as $akey => $aval) {

            $allctypes[$aval->ctype_id] = array($aval->ctype_name, $aval->ctype_icon);

        }
        $structure = array();
        if (count($slots) == 0) {
            echo "<h5>No Slots available</h5>";
        }
        $hospitals = array();
        $booking_dates = array();
        $hospitals_ids = array();
        foreach ($slots as $skey => $sval) {

            //if(($sval->booking_date>=date('d-m-Y')) && ($sval->booking_start_time > date('H:i'))){
            if (($sval->booking_date == date('d-m-Y')) && ($sval->booking_start_time <= date('H:i'))) {
                //should not be add
            } else {

                //$structure[$sval->hospital_id]['hospital']= $sval->hospital_name;
                // $hospitals[] =  $sval->hospital_name;
                //$hospitals_ids[$sval->hospital_id] =  $sval->hospital_name;
                //$booking_dates[] =$sval->booking_date;
                $structure[$sval->hospital_id]['values'][$sval->screen_id][$sval->booking_date][$sval->shift][] = array(
                    'time' => $sval->booking_time_long,
                    'type' => $sval->available_types,
                    'slotid' => $sval->slotid,
                    'time_start' => $sval->booking_start_time,
                    'available_types' => $sval->available_types,
                    'booking_status' => $sval->booking_status
                );
            }

        }

        // $booking_dates = array_unique($booking_dates);
        ///STRUCTURE DESIGN
        $design = '';
        foreach ($structure as $skey => $sval) {
            $i = 1;
            foreach ($sval['values'] as $vkey => $vval) {
                foreach ($vval as $datekey => $dateval) {
                    if ($i == 1) {
                        $ac = "active";
                    } else {
                        $ac = '';
                    }
                    $design .= '<div class=" filterme_' . $datekey . ' carousel-item  ' . $ac . '" id="selectme_' . base64_encode($datekey) . '">';
                    $design .= '<div class="d-flex"><div class="col-12 d-flex flex-column card pl-0 pr-0">';
                    $design .= ' <div class="introduce card-body" ><h5 class="post-02__title pl-2 pr-2 mt-1">';
                    $design .= date('l jS M,Y', strtotime($datekey)) . '</h5> ';
                    $design .= '<input type="hidden" class="divdates" name="divdates" value="' . $datekey . '">';
                    $design .= '<div class="flex-column-1 p-1">';
                    $design .= '<div class="tabs-x tabs-left tab-sideways tab-bordered tabs-krajee">';
                    $design .= '<ul id="myTab-kv-' . $datekey . '" class="nav nav-tabs subtabmenu" role="tablist" style="font-size:13px;font-weight:bold;text-align:center">';
                    foreach ($dateval as $shiftkey => $shiftval) {
                        $design .= '<li class="clicktab" style="margin-left:4px" id="' . $shiftkey . '_' . base64_encode($datekey) . '" >';
                        $design .= '<a style="padding:2px 4px"href="#home-kv-' . $shiftkey . '_' . $datekey . '" role="tab" data-toggle="tab" aria-expanded="false">';
                        $design .= ucfirst($shiftkey) . ' </a></li>';
                    }
                    $design .= '</ul>';
                    $ii = 1;
                    $m = '';
                    $design .= '<div id="myTabContent-kv-' . $datekey . '" class="tab-content" >';
                    foreach ($dateval as $shiftkey => $shiftval) {
                        if ($ii == 1) {
                            $m = " show ";
                        } else {
                            $m = '';
                        }
                        // echo ucfirst($shiftkey);
                        $design .= '<div class="tab-pane fade active ' . $m . '" id="home-kv-' . $shiftkey . '_' . $datekey . '">';
                        $design .= '<div class="row">';
                        foreach ($shiftval as $timekey => $timeval) {
                            $design .= '<div class="col-lg-3 col-md-3 col-sm-6 col-6 p-1" style="font-size:12px">';
                            $design .= '<div class="slot-box">';
                            $design .= '<p><i class="fa fa-clock-o" aria-hidden="true"></i> ' . $timeval['time_start'] . "</p>";
                            $design .= '<p>';
                            $av = explode(',', $timeval['available_types']);
                            foreach ($av as $ak => $aval) {
                                $design .= '<img src="' . $allctypes[$aval][1] . '" height="15px" >';


                            }
                            $design .= '</p>';
                            $design .= '<p>' . $timeval['time'] . '</p>';

                            $design .= '<input type="hidden" name="atime" class="atime atype_' . base64_encode($timeval['available_types']) . '" value="' . base64_encode("(" . $timeval['time'] . "_" . $timeval['time_start'] . ")") . '">';
                            $design .= '<input type="hidden" name="available_types" class="available_types " value="' . base64_encode(str_replace(',', '_', $timeval['available_types'])) . '">';
                            if ($timeval['booking_status'] != 'available') {
                                $design .= '<p><a href="javascript:void(0);" class="unavail">Booked</a></p>';
                            } else {
                                $design .= '<p><a href="javascript:void(0);"class="book-app">Available</a></p>';
                            }
                            $design .= '</div></div>';
                            $ii++;

                        }
                        $design .= '</div></div>';
                    }
                    $design .= '</div></div></div></div></div></div></div>';
                    $i++;

                }


            }

        }
        ///END OF STRUCTURE DESIGN
        echo $design;
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|void
     */
    public function getAppointmentTimes(Request $request)
    {
        $requestParams = $request->all();
        $doctorId = isset($requestParams['doctor_id']) ? $requestParams['doctor_id'] : 0;
        $hospitalId = isset($requestParams['hospital_id']) ? $requestParams['hospital_id'] : 0;
        $appointmentDate = isset($requestParams['appointmentDate']) ? $requestParams['appointmentDate'] : 0;
        if ($doctorId == 0 || $hospitalId == 0) {
            return redirect('/search');
        }
        $appointmentDetails = Slots::select('slots.id', 'slots.booking_start_time')
            ->where('slots.booking_date', $appointmentDate)
            ->where('slots.doctor_id', $doctorId)
            ->where('slots.hospital_id', $hospitalId)
            ->where('slots.booking_status', 'available')
            ->where("booking_date", '>', date('Y-m-d'))
            ->get()->all();
        echo json_encode($appointmentDetails);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function createAppointment(Request $request)
    {
        //NOT USING BECAUSE OF THE OLD STRUCTURE DOESN'T CONTAINI ALLL REQUIRED
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'doctor_concent' => 'required|in:on',
                'patien_concent' => 'required|in:on',
            ], [
                'email.required' => 'Email required',
                'doctor_concent.required' => 'Doctor concent is required',
                'patien_concent.required' => 'Patient concent is required',
            ]);
            $message = 'Booking successfull';
            $requestParams = $request->all();
            echo "<pre>";
            print_r($requestParams);
            die;


            if (!empty($requestParams)) {
                $doctorId = isset($requestParams['doctor_id']) ? $requestParams['doctor_id'] : 0;
                $hospitalId = isset($requestParams['inputStatehospital']) ? $requestParams['inputStatehospital'] : 0;
                $patientId = isset($requestParams['patient_id']) ? $requestParams['patient_id'] : 1;
                $appointmentDate = isset($requestParams['appointmentDate']) ? $requestParams['appointmentDate'] : 0;
                $appointmentTime = isset($requestParams['appointmentTime']) ? $requestParams['appointmentTime'] : 0;
                $appointmentDetails = Appointments::select('id')
                    ->where('slot_id', $appointmentTime)
                    ->first();
                if (!$appointmentDetails) {
                    $appointmentData = new Appointments();
                    $appointmentData->patient_id = $patientId;
                    $appointmentData->slot_id = $appointmentTime;
                    $appointmentData->save();
                    $doctorName = $this->getDoctorPatientName($doctorId, 'Doctor');
                    $patientName = $this->getDoctorPatientName($patientId, 'Patient');
                    $hopitalName = $this->getHospitalName($hospitalId);
                    $slotTimings = $appointmentDetails = Slots::select('booking_time_long')->where('id', $appointmentTime)->first();
                    $dateTime = $appointmentDate . ' ' . $slotTimings->booking_time_long;
                    Log::info('doctorName => ' . $doctorName . ' patientName => ' . $patientName . '  hopitalName => ' . $hopitalName . '  dateTime => ' . $dateTime);
                    Mail::send('Frontend::slot_confirmation_doctor_email',
                        array(
                            'patientName' => $patientName,
                            'doctorName' => $doctorName,
                            'hospitalName' => $hopitalName,
                            'dateTime' => $dateTime
                        ), function ($message) use ($request) {
                            $message->subject('Appointment Booking Successful.');
                            $message->from(getenv('MAIL_FROM_ADDRESS'));
                            $message->to($request->email);
                        });
                    Mail::send('Frontend::slot_confirmation_patient_email',
                        array(
                            'patientName' => $patientName,
                            'doctorName' => $doctorName,
                            'hospitalName' => $hopitalName,
                            'dateTime' => $dateTime
                        ), function ($message) use ($request) {
                            $message->subject('Appointment Booking Successful.');
                            $message->from(getenv('MAIL_FROM_ADDRESS'));
                            $message->to($request->email);
                        });
                } else {
                    $message = 'Slot already booked';
                }
            }
            return Redirect::to('/?message=' . $message);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
    }

    /**
     * @param $doctorId
     * @param $tableName
     * @return string
     */
    public function getDoctorPatientName($doctorId, $tableName)
    {
        try {
            $doctorName = '';
            if ($doctorId > 0) {
                if ($tableName == 'Doctor') {
                    $doctorDetails = Doctors::where('id', $doctorId)->select('title', 'firstname', 'lastname')->first();
                } elseif ($tableName == 'Patient') {
                    $doctorDetails = Patient::where('id', $doctorId)->select('title', 'firstname', 'lastname')->first();
                }
                if (!empty($doctorDetails)) {
                    $doctorName = $doctorDetails->title . ' ' . $doctorDetails->firstname . ' ' . $doctorDetails->lastname;
                }
            }
            return $doctorName;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $doctorName;
        }
    }

    /**
     * @param $hospitalId
     * @return string
     */
    public function getHospitalName($hospitalId)
    {
        try {
            $hospitalName = '';
            if ($hospitalId > 0) {
                $hospitalDetails = Hospitals::where('hospital_id', $hospitalId)->select('hospital_name')->first();
                if (!empty($hospitalDetails)) {
                    $hospitalName = $hospitalDetails->hospital_name;
                }
            }
            return $hospitalName;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $hospitalName;
        }
    }

    /**
     * @param $n
     * @return string
     */
    public function getrandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

}
