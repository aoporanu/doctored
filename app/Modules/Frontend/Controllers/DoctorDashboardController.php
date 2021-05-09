<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\GroupHospitalMapping as GroupHospitalMapping;
use App\Modules\Admin\Models\Groups as Group;
use App\Modules\Admin\Models\Hospitals as Hospitals;
use App\Modules\Admin\Models\ProcessLogs as ProcessLog;
use App\Modules\Frontend\Models\HospitalDoctorMapping as HospitalDoctorMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function doctorDashboard()
    {
        $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
        $date = date('d-m-Y');
        $dateString = strtotime($date);
        $nextDateString = strtotime("+7 day", $dateString);
        $nextDate = date('d-m-Y', $nextDateString);
        $availableSlotsQuery = DB::table('slots')
            ->select(
                'slots.id',
                'slots.booking_start_time',
                'slots.booking_date',
                'appointments.appointment_status',
                'slots.hospital_id',
                'slots.doctor_id',
                'appointments.patient_id',
                'appointments.slotid'
            )
            ->where('slots.is_delete', '0')
            ->where('slots.is_active', '1')
            ->where('slots.booking_date', '>=', date('d-m-Y'))
            ->where('slots.booking_date', '<=', $nextDate)
            ->where('doctors.id', $doctorInfo['id'])
            ->leftjoin('appointments', DB::raw('CAST(appointments.slotid AS integer)'), 'slots.id')
            ->leftjoin('doctors', 'slots.doctor_id', 'doctors.id')
            ->leftjoin('hospitals', 'slots.hospital_id', 'hospitals.hospital_id');

        if (isset($_REQUEST['h']) && $_REQUEST['h'] != '') {
            $availableSlotsQuery->where('slots.hospital_id', $_REQUEST['h']);
        }
        $availableSlotsQuery->orderBy('slots.booking_date', 'ASC');
        $availableSlotsQuery->orderBy('slots.booking_start_time', 'ASC');
        $availableSlotsQuery->groupBy(
            'slots.id',
            'slots.booking_date',
            'slots.booking_start_time',
            'appointments.appointment_status',
            'slots.hospital_id',
            'slots.doctor_id',
            'appointments.patient_id',
            'appointments.slotid'
        );
        $availableSlots = $availableSlotsQuery->get()->toArray();
        $availableSlotDates = [];
        $todayBookings = 0;
        $todayCancellations = 0;
        foreach ($availableSlots as $avaSlots) {
            if (
                $avaSlots->booking_date == date('d-m-Y') &&
                $avaSlots->appointment_status == 'booked'
            ) {
                $todayBookings++;
            }
            if (
                $avaSlots->booking_date == date('d-m-Y') &&
                $avaSlots->appointment_status == 'canceled'
            ) {
                $todayCancellations++;
            }
            if (!in_array($avaSlots->booking_date, $availableSlotDates)) {
                $availableSlotDates[] = $avaSlots->booking_date;
            }
        }
//        $availableSlots = $availableSlotsData;
//        echo "<pre>";print_r($availableSlotDates);
//        echo "<pre>";print_r($availableSlots);
//        die;
//        $slotsquery = DB::table('appointments')
//                    ->where(DB::raw('CAST(booking_date AS date)'), '>=', date('d-m-Y'))
//                    ->where(DB::raw('CAST(booking_date AS date)'), '<=', $nextDate)
//                    ->where('doctor_id', $doctorInfo['id'])
//                    ->leftjoin('doctors', 'appointments.doctor_id', 'doctors.id')
//                    ->leftjoin('hospitals', 'appointments.hospital_id', 'hospitals.hospital_id')
//                    ->leftjoin('patients', 'appointments.patient_id', 'patients.id');
//            if (isset($_REQUEST['h']) && $_REQUEST['h'] != '') {
//                $slotsquery->where('appointments.hospital_id', $_REQUEST['h']);
//            }
//            $slots = $slotsquery->get()->toArray();
// //            echo __METHOD__;
// //            echo "<pre>";print_r($slots);
// //            exit;

//            $docMetaData = \App\Modules\Admin\Models\MetatypeData::leftjoin('doctors', 'doctors.id', '=', 'metatype_data.mapping_type_id')
//                    ->where('metatype_data.mapping_type', 'Doctor')
//                    ->where('doctors.doctorcode', $doctorInfo['doctorcode'])->get()->all();
//            $docMetaList = [];
//            if ($docMetaData) {
//                foreach ($docMetaData as $docMetaInfo) {
//                    $docMetaList[$docMetaInfo->mapping_type_data_id] = $docMetaInfo->mapping_type_data_value;
//                }
//            }
        return view('Frontend::doctor_dashboard')
            ->with([
                'doctorInfo'     => $doctorInfo,
                'todayBookings'  => $todayBookings, 'todayCancellations' => $todayCancellations,
                'availableSlots' => $availableSlots, 'availableSlotDates' => $availableSlotDates
            ]);
    }

    public function clinicInfo()
    {
        $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
        $doctor_id = $doctorInfo['id'];
        $hospitalMap = HospitalDoctorMapping::where('doctor_id', $doctor_id)->first();
        $hospital_id = isset($hospitalMap->hospital_id) ? $hospitalMap->hospital_id : 0;
        $hospitalInfo = Hospitals::where('hospital_id', $hospital_id)->first();
        $hospitalInfo = json_decode(json_encode($hospitalInfo), 1);
        return view('Frontend::doctor_clinicInfo')
            ->with('doctorInfo', $doctorInfo)
            ->with('clinicInfo', $hospitalInfo);
    }

    public function clinicSave(Request $request)
    {

        $request->validate([
            'name'        => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'phone'       => 'required|numeric|digits_between:10,12|unique:hospitals',
            'email'       => 'required|email|unique:hospitals',
            'addr1'       => 'required',
            'addr2'       => 'required',
            'city'        => 'required',
            'state'       => 'required',
            'country'     => 'required',
            'searchInMap' => 'required',
            'postcode'    => 'required',//|postal_code_for:country
        ], [
            'name.required'        => 'Clinic Name is required',
            'addr1.required'       => 'Address1 is required',
            'addr2.required'       => 'Address2 is required',
            'searchInMap.required' => 'Geo location is required'
        ]);

        $input = $request->all();

        $process_log = array();
        $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
        $doctor_id = $doctorInfo['id'];
        $hospitalInfo = HospitalDoctorMapping::where('doctor_id', $doctor_id)->first();
        $hospital_id = isset($hospitalInfo->hospital_id) ? $hospitalInfo->hospital_id : 0;

        $hospitalData = new Hospitals();
        if ($hospital_id != 0) {
            $hospital = Hospitals::where('hospital_id', $hospital_id)->first();
            $hospital->hospital_name = $request->name;
            $hospital->phone = "+" . $request->phonecode . "-" . $request->phone;
            $hospital->email = $request->email;
            //$hospital->fax =  $request->fax;
            $hospital->address_line1 = $request->addr1;
            $hospital->address_line2 = $request->addr2;
            $hospital->address_line3 = $request->addr3;
            $hospital->address_city = $request->city;
            $hospital->address_state = $request->state;
            $hospital->address_country = $request->country;
            $hospital->address_postcode = $request->postcode;
            $hospital->address_lat = $request->latitude;
            $hospital->address_long = $request->longitude;
            $hospital->address_place = $request->searchInMap;
            $hospital->summary = $request->summary;
            $hospital->updated_by = $doctor_id;
            $hospital->save();
            $process_log['hospital_data'] = $hospital;
        } else {
            $hospitalData->hospital_name = $request->name;
            $hospitalData->hospital_business_name = $request->name;
            $hospitalData->licence = rand(1, 99999999);
            $hospitalData->dateofregistration = date('Y-m-d');
            $hospitalData->hospital_type = 'C';
            $hospitalData->phone = "+" . $request->phonecode . "-" . $request->phone;
            $hospitalData->email = $request->email;
            //$hospitalData->fax =  $request->fax;
            $hospitalData->address_line1 = $request->addr1;
            $hospitalData->address_line2 = $request->addr2;
            $hospitalData->address_line3 = $request->addr3;
            $hospitalData->address_city = $request->city;
            $hospitalData->address_state = $request->state;
            $hospitalData->address_country = $request->country;
            $hospitalData->address_postcode = $request->postcode;
            $hospitalData->address_lat = $request->latitude;
            $hospitalData->address_long = $request->longitude;
            $hospitalData->address_place = $request->searchInMap;
            $hospitalData->summary = $request->summary;
            $hospitalData->created_by = $doctor_id;
            $hospitalData->updated_by = $doctor_id;

            $hmax = Hospitals::max('hospital_id');
            if ($hmax == '') {
                $hmax = 1;
            } else {
                $hmax++;
            }
            $hospitalcode = 'HSPFR' . date('y') . (10000 + $hmax);
            $hospitalData->hospitalcode = $hospitalcode;
            if ($hospitalData->save()) {
                $process_log['hospital_data'] = $hospitalData;
                $hospitalId = $hospitalData->hospital_id;
                $hospitalDoctorMap = new HospitalDoctorMapping();
                $hospitalDoctorMap->hospital_id = $hospitalId;
                $hospitalDoctorMap->doctor_id = $doctor_id;
                if ($hospitalDoctorMap->save()) {
                    $process_log['doctor_hospital_map_data'] = $hospitalDoctorMap;

                    $groupData = new Group();
                    $gmax = DB::table('group')->max('group_id');
                    if ($gmax == '') {
                        $gmax = 1;
                    } else {
                        $gmax++;
                    }
                    $groupData->gid = (10000 + $gmax);
                    $groupData->group_name = 'CLIGRP-' . $groupData->gid;

                    if ($groupData->save()) {
                        $process_log['group_data'] = $groupData;
                        $groupHospitalMapping = new GroupHospitalMapping();
                        $groupHospitalMapping->hospital_id = $hospitalId;
                        $groupHospitalMapping->group_id = $groupData->gid;
                        $groupHospitalMapping->created_by = $doctor_id;
                        $groupHospitalMapping->updated_by = $doctor_id;
                        $groupHospitalMapping->save();
                        $process_log['group_role_map_data'] = $groupHospitalMapping;
                    }
                }
            }
        }

        if (count($process_log) > 0) {
            $this->logProcess(0, 'register_doctor', 'Notify', json_encode($process_log));
        }
        return redirect()->route('clinic.info');
    }

    public function logProcess($userid, $method, $type, $data)
    {
        $ProcessLogData = new ProcessLog();
        $ProcessLogData->user_id = $userid;
        $ProcessLogData->method = $method;

        $ProcessLogData->log_type = $type;
        $ProcessLogData->log = $data;
        $ProcessLogData->save();
    }
}
