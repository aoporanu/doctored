<?php
namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ConsultationTypes;
use App\Modules\Admin\Models\Hospitals;
use App\Modules\Frontend\Models\HospitalDoctorMapping;
use App\Modules\Frontend\Models\SlotConfigurations as SlotConfiguration;
use App\Modules\Frontend\Models\Slots;
use Exception;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JsonException;

class SlotConfigurationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:doctor');
        parent::__construct();
    }

    public function updateSlotConfiguration(Request $request)
    {
        $data = $request->all();
        if ($data['savetype'] === 'update') {
            if (!isset($data['typeopt']) || $data['typeopt'] === '') {
                return back()->with('error', 'Please select Consultation type');
            }
        }
        $selected_array = $data['selectedvalues'];
        $selected_array = (array)json_decode($selected_array, true, 512, JSON_THROW_ON_ERROR);
        $subQuery = "";
        if ($data['savetype'] === 'delete') {
            $subQuery .= "update slots set is_delete='1'";
        }
        if ($data['savetype'] === 'update') {
            $subQuery .= "update slots set available_types='" . implode(',', $data['typeopt']) . "'";
        }
        $subQuery .= " where screen_id ='" . $data["screen_id"] . "' and  ( ";
        $i = 1;
        foreach ($selected_array as $sa_key => $sa_val) {
            foreach ($sa_val as $sak => $sav) {
                if ($i === 1) {
                    $addand = '';
                } else {
                    $addand = ' or  ';
                }
                $subQuery .= $addand . "(booking_date = '" . $sa_key . "' and booking_time_long = '" . $sav . "')";
                $i++;
            }

        }
        $subQuery .= ")";
        if (DB::statement($subQuery)) {
            return back()->with('success', 'updated successfully');
        }

        return back()
            ->with('error', 'updated failed');
    }

    public function slotsDetails(Request $request)
    {
        $data = $request->all();
        $screen_id = $data['s'];

        try {
            $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user(), JSON_THROW_ON_ERROR), 1, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            Log::info($e->getLine() . ':' . $e->getMessage());
        }
        $select_array = ['hospital_name', 'slot_days', 'timezone', 'timezone_value', 'consultaions', 'slot_startdate', 'slot_enddate', 'userip', 'cons_duration']; //,'selected_date_values','ready_slots'
        $slotConfiguration = SlotConfiguration::select('conf_value', 'conf_key')
            ->where('screen_id', $screen_id)
            ->whereIn('conf_key', $select_array)
            ->get()
            ->toArray();
        $slots = Slots::select('id', 'screen_id', 'shift', 'booking_date', 'booking_start_time', 'booking_time_long', 'available_types')
            ->where('screen_id', $screen_id)->where('is_delete', '!=', 1)
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();
        $unique_shift_times = array();
        $uniqueDates = array();
        foreach ($slots as $sk => $sv) {
            $uniqueDates[] = $sv['booking_date'];
            $unique_shift_times[$sv['shift']][] = $sv['booking_time_long'];
        }

        $clean_unique_shifts = array();
        foreach ($unique_shift_times as $ustkey => $ust_val) {
            $clean_unique_shifts[$ustkey] = array_unique($ust_val);
        }
        $uniqueDates = array_unique($uniqueDates);
        return view('Frontend::slots/slotdetails')->with(compact('doctorInfo', 'slotConfiguration', 'slots', 'uniqueDates', 'clean_unique_shifts'));

    }

    public function manage(Request $request)
    {
        $he = $request->all();
        if (isset($he['h'])) {
            $h = base64_decode($he['h']);
        }

        try {
            $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user(), JSON_THROW_ON_ERROR), 1, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            Log::info($e->getLine() . $e->getMessage());
        }
        $did = $doctorInfo['id'];
        /* TEMPORARY FIX NEED TO CHECK DATA WITH IS_ACTIVE ,THIS IS IMPACTS ON DRAFT FUNCTIONLITY */
        DB::statement("delete from slot_configurations where screen_id in (
select distinct(screen_id) from slot_configurations s where is_delete!=1 and doctor_id='" . $did . "' and screen_id not in (
select distinct(screen_id) from slots where is_delete!=1 and doctor_id='" . $did . "'))");
        /* TEMPORARY FIX NEED TO CHECK DATA WITH IS_ACTIVE ,THIS IS IMPACTS ON DRAFT FUNCTIONLITY */
        if (!isset($h)) {
            $configurations = SlotConfiguration::where('doctor_id', $did)->select('screen_id')
                ->distinct('screen_id')
                ->get()
                ->toArray();
        } else {
            $configurations = SlotConfiguration::where('doctor_id', $did)->where('hospital_id', $h)->select('screen_id')
                ->distinct('screen_id')
                ->get()
                ->toArray();
        }
        $screen_data = array();

        $i = 0;
        foreach ($configurations as $conf_key => $conf_val) {
            $screen_data[$conf_key]['screen_id'] = $conf_val;

            $data = Slots::selectRaw('MAX(slots.booking_date) AS enddate')->selectRaw('MIN(slots.booking_date) AS startdate')
                ->selectRaw('count(slots.*) AS total')
                ->join('hospitals', 'slots.hospital_id', '=', 'hospitals.hospital_id')
                ->where('slots.screen_id', $conf_val)->get()
                ->toArray();
            $screen_data[$conf_key]['hid'] = Slots::select('hospital_id')->distinct()
                ->where('slots.screen_id', $conf_val)->get()
                ->toArray();
            $hid = $screen_data[$conf_key]['hid'][0]['hospital_id'];

            $hid_details = Hospitals::select('hospital_name', 'hospital_id')->where('hospital_id', $hid)->get()
                ->toArray();
            $screen_data[$conf_key]['startdate'] = $data[0]['startdate'];
            $screen_data[$conf_key]['enddate'] = $data[0]['enddate'];
            $screen_data[$conf_key]['total'] = $data[0]['total'];

            $screen_data[$conf_key]['hospital_id'] = $hid_details[0]['hospital_id'];
            $screen_data[$conf_key]['hospital_name'] = $hid_details[0]['hospital_name'];
            $i++;
        }

        // $hospitals = array_unique($hospitals);
        $hquery = "select hospital_id,hospital_name from hospitals where hospital_id in (select hospital_id from hospital_doctor_mapping where doctor_id=" . $did . " )";
        $hospitals = DB::select($hquery);
        return view('Frontend::slots/manage')->with(compact('doctorInfo', 'screen_data', 'hospitals'));
    }

    public function fetchSlotConfiguration(Request $request)
    {
        //Before review
        $data = $request->all();
        $screen_id = $data['screen_id'];
        //Temp setting
        if ($screen_id === '') {
            dd("ScreenID required")
        }
        $slotconfiguration = SlotConfiguration::select('conf_value', 'conf_key')->where('screen_id', $screen_id)->get()
            ->toArray();

        $selected = array();
        $details = array();
        $selecetedcons = array();
        $hospital_id = array();
        $slot_startdate = '';
        $slot_enddate = '';

        foreach ($slotconfiguration as $skey => $sval) {
            if ($sval['conf_key'] === 'ready_date_values') {
                $selected_datas = $sval['conf_value'];
                $details['selected']['dates'] = explode(',', str_replace('[', '', str_replace(']', '', $selected_datas)));

            }
            if ($sval['conf_key'] === 'consultaions' || $sval['conf_key'] === 'ready_slots') {
                $details['selected'][$sval['conf_key']] = $sval['conf_value'];

            }
            if ($sval['conf_key'] === 'hospital_name') {
                $hospital_id[] = $sval['conf_value'];
            }
            if ($sval['conf_key'] === 'slot_startdate') {
                $slot_startdate = $sval['conf_value'];
            }
            if ($sval['conf_key'] === 'slot_enddate') {
                $slot_enddate = $sval['conf_value'];
            }

        }

        if (isset($hospital_id[0])) {
            $hospital = Hospitals::where('hospital_id', $hospital_id[0])->get()
                ->toArray();
            // print_r($slotconfiguration); exit;
            $hospital_name = $hospital[0]['hospital_name'];
        } else {
            $hospital_name = 'Not Selected ';
        }

        $structure = array(); //restructuring array for easy templating.
        foreach ($details['selected']['dates'] as $dt_key => $dt_val) {

            $structure[$dt_val]['ready_slots'] = $details['selected']['ready_slots'];
            $structure[$dt_val]['consultaions'] = $details['selected']['consultaions'];
        }

        $count = 1;
        $add_collapse = '';
        //Page design
        $design = '<div class="row"><div class="col-9">
				Please Review details and click on Complete
				</div>
				<div class="col-3">
		<button type="button" class="btn btn-success"  onClick="javascript:generateSlots()"> Complete Configuration </button>
						<br>
				</div>
				</div></div>';
        foreach ($structure as $st_key => $st_val) {
            $st_key = str_replace('"', '', $st_key);
            $day = date('l ', strtotime($st_key));
            $design .= "<div class='card' id='dayitem_" . $count . "' style='float:left;width:24.5%;margin:0px;border:1px solid #214214'>";

            $design .= "<div class='card-header' style='background:#edf9e9;font-weight:bold;;border:1px;background:#214214;color:#fff' >" . $st_key . "&nbsp;(" . $day . ") " . $add_collapse . "</div>";
            $design .= "<div class='card-body' id='dayitem_content_" . $count . "'  style='font-size:10px;font-weight:bold;'>";
            $subbutton = 1;

            $ready = (array)json_decode($st_val['ready_slots']);
            foreach ($ready as $rd_key => $r_val) {

                $design .= "<div class='row'><div class='col-sm-12  badge badge-secondary'>" . ucfirst($rd_key) . "</div></div>";

                $design .= "<div class='row'><div class='col-sm-12' >";

                foreach ($r_val as $rv_key => $rv_val) {
                    $rowtimes = $r_val[0];

                    foreach ($rowtimes as $rowtimes_key => $rowtimes_val) {
                        $rowtimes_val = explode('-', $rowtimes_val);
                        $new_rowtimes_val = $rowtimes_val[0];
                        $design .= "<span id='dayitem_buton_" . $count . "_" . $subbutton . "' class='badge' style='font-size:10px;color:#000;border:1px solid #ccc;background:#edf9e9;font-weight:normal;float:left;margin:1px'>" . $new_rowtimes_val . "</span>";
                        $subbutton++;
                    }
                }
                $design .= "</div></div>";

            }
            $design .= "</div>";
            $design .= "</div>";

            $count++;
        }

        echo $design;

    }

    public function deletedetails(Request $request)
    {
        $data = $request->all();
        if (isset($data['s'])) {
            DB::delete('DELETE FROM slots WHERE screen_id = ?', [$data['s']]);
            DB::delete('DELETE FROM slot_configurations WHERE screen_id = ?', [$data['s']]);
            return back()->with('success', 'Record deleted successfully!');
        }
        print_r($data);
        exit;

    }

    //-------------------------------------------------------------------------------------------------------------------------------------
    public function generateAppointments(Request $request)
    {
        $data = $request->all();
        $screen_id = $data['screen_id'];
        //$screen_id = 'vtjyCEe41gdAkbi';
        if ($screen_id === '') {
            echo "ScreenID required";
            exit;
        }
        $slotconfiguration = SlotConfiguration::select('conf_value', 'conf_key')->where('screen_id', $screen_id)->whereIn('conf_key', array(
            'ready_slots',
            'consultaions',
            'hospital_name',
            'ready_date_values'
        ))
            ->get()
            ->toArray();
        $details = array();
        foreach ($slotconfiguration as $skey => $sval) {
            if ($sval['conf_key'] === 'ready_date_values') {
                $selected_datas = $sval['conf_value'];
                $details['dates'] = explode(',', str_replace('[', '', str_replace(']', '', $selected_datas)));

            }
            if ($sval['conf_key'] === 'consultaions' || $sval['conf_key'] === 'ready_slots' || $sval['conf_key'] === 'hospital_name') {
                if ($sval['conf_key'] === 'ready_slots') {
                    $details[$sval['conf_key']] = json_decode($sval['conf_value'], true, 512, JSON_THROW_ON_ERROR);
                } else {
                    $details[$sval['conf_key']] = $sval['conf_value'];
                }

            }

        }
        $details['consultaions'] = str_replace('"', '', str_replace(']', '', str_replace('[', '', $details['consultaions'])));

        $auth = Auth::guard('doctor')->user();

        //--------------------
        $restructure = array();
        $slot = new Slots();
        foreach ($details['dates'] as $rs_key => $rs_val) {
            $restructure[$rs_val]['date'] = $rs_val;
            $restructure[$rs_val]['hid'] = $details['hospital_name'];
            $restructure[$rs_val]['consultaions'] = $details['consultaions'];
            foreach ($details['ready_slots'] as $ds_key => $ds_val) {
                foreach ($ds_val as $ds_sub_key => $ds_sub_value) {
                    foreach ($ds_sub_value as $ds_final_key => $ds_final_val) {
                        $restructure['complete'][] = ['doctor_id' => $auth->id, 'hospital_id' => $restructure[$rs_val]['hid'], 'shift' => $ds_key, 'booking_date' => $this->stripQuotes($restructure[$rs_val]['date']), 'booking_start_time' => $ds_final_key, 'booking_time_long' => $ds_final_val, 'available_types' => $restructure[$rs_val]['consultaions'], 'screen_id' => $screen_id, 'created_at' => $slot->freshTimestamp(), 'updated_at' => $slot->freshTimestamp()];
                    }
                }
            }

        }

        $slot->insert($restructure['complete']);
    }

    //-------------------------------------------------------------------------------------------------------------------------------------

    public function stripQuotes($text): array|string|null
    {
        return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $text);
    }

    public function saveSlotConfiguration(Request $request): void
    {

        $data = $request->all();
        //print_r($data);exit;
        $cons_duration = $data['cons_duration'];
        $hospital_id = $data['hospital_name'];
        unset($data['failed']);
        if (isset($data['consultaions'])) {
            $consultations = $data['consultaions'];
        }
        $screen_id = $data['screen_id'];
        $selected_datas = $data['ready_date_values']; // selected_date_values
        $exclud_slotdate = $data['exclud_slotdate'];
        $custom_extention_date = $data['custom_extention_date'];

        $durations = DB::table('durations')->select('id', 'shift', 's_start', 's_end')
            ->orderBy('id')
            ->get()
            ->toArray();
        /*
        [morning_time_start] => 09:00 [morning_time_end] => 09:15
        [morning_break_start] => [morning_break_end] =>
        [afternoon_time_start] => [afternoon_time_end] =>
        [evening_time_start] => 17:00 [evening_time_end] =>
        17:30 [evening_break_start] => [evening_break_end] => )
        */
        $timings = array();
        $onlyslots = array();
        foreach ($durations as $dur_key => $dur_val) {
            $shift = strtolower(str_replace(' ', '', $dur_val->shift));

            if (isset($data[$shift . "_time_start"], $data[$shift . "_time_end"])) {
                //ONLY AVAILABLE DATA WILL SET FOR NEXT PROCESS
                $timings[$shift]['start'] = $data[$shift . "_time_start"];
                $timings[$shift]['start_decimal'] = $this->time_to_decimal($data[$shift . "_time_start"] . ":00") * 60;
                $timings[$shift]['end'] = $data[$shift . "_time_end"];
                $timings[$shift]['end_decimal'] = $this->time_to_decimal($data[$shift . "_time_end"] . ":00") * 60;

                //----------
                $timings[$shift]['selected'] = $this->hoursRange($timings[$shift]['start_decimal'], $timings[$shift]['end_decimal'], 60 * $cons_duration, 'h:i A');

                //-----------
                if (isset($data[$shift . "_break_start"], $data[$shift . "_break_end"])) {
                    $timings[$shift]['breakstart'] = $data[$shift . "_break_start"];
                    $timings[$shift]['breakstart_decimal'] = $this->time_to_decimal($data[$shift . "_break_start"] . ":00") * 60;
                    $timings[$shift]['breakend'] = $data[$shift . "_break_end"];
                    $timings[$shift]['breakend_decimal'] = $this->time_to_decimal($data[$shift . "_break_end"] . ":00") * 60;
                    //fetching all durations in above
                    $breaks = $this->hoursRange($timings[$shift]['breakstart_decimal'], $timings[$shift]['breakend_decimal'], 60 * $cons_duration, 'h:i A');
                    //LOGIC TO REMOVE LAST INDEX FROM BREAKS BECAUSE THE CURRENT LOGIC IS EXCLUDING REQUIRED SLOT ITEM
                    if (count($breaks) > 1) {
                        $last_required_key = array_key_last($breaks); //this accepted slot
                        unset($breaks[$last_required_key]);
                    }
                    // END OF LOGIC TO REMOVE LAST INDEX FROM BREAKS BECAUSE THE CURRENT LOGIC IS EXCLUDING REQUIRED SLOT ITEM
                    $timings[$shift]['breaks'] = $breaks;
                }

                //Filter only clean slots
                if (isset($timings[$shift]['breaks'])) {
                    //unset last data
                    $timings[$shift]['available'] = array_diff($timings[$shift]['selected'], $timings[$shift]['breaks']);
                } else {
                    $timings[$shift]['available'] = $timings[$shift]['selected'];
                }
                //	$timings[$shift]['available']=  array_chunk($timings[$shift]['available'],2);
                $i = 0;
                $len = count($timings[$shift]['available']);
                foreach ($timings[$shift]['available'] as $tm_key => $tm_val) {
                    if ($i !== $len - 1) {
                        $timings[$shift]['slots'][$tm_key] = $tm_val . "-" . date('h:i A', (($this->time_to_decimal($tm_key . ":00") * 60) + (60 * $cons_duration)));
                    }

                    $i++;
                }
                //$onlyslots[] = $timings[$shift]['slots']; //MODIFiying due to  shift requirment , Important 27/12/2020
                $onlyslots[$shift][] = $timings[$shift]['slots'];
            }

        }
        $data['timings'] = $timings;
        $data['ready_slots'] = $onlyslots;
        $auth = Auth::guard('doctor')->user();
        $previous_records = SlotConfiguration::where('screen_id', $screen_id)->get();
        $SlotConfiguration = array();
        $sc = new SlotConfiguration();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_THROW_ON_ERROR);
            }
            $iteration = 1;
            if (count($previous_records) > 0) {
                $last_iteration = SlotConfiguration::where('screen_id', $screen_id)->select('iteration')
                    ->distinct('iteration')
                    ->get()
                    ->toArray();
                $last_iteration = $last_iteration[0]['iteration'];
                $iteration = $last_iteration + 1;
            }
            $SlotConfiguration[] = array(
                'screen_id' => $screen_id,
                'doctor_id' => $auth->id,
                'hospital_id' => $hospital_id,
                'conf_key' => $key,
                'conf_value' => $value,
                'iteration' => $iteration,
                'created_at' => $sc->freshTimestamp(),
                'updated_at' => $sc->freshTimestamp()
            );

        }
        //echo \Request::fullUrl();


        if (count($previous_records) > 0) {
            //important removing temporarly but need to update with empty start_end
            if (DB::delete('delete from slot_configurations where screen_id = ?', [$screen_id])) {
                $sc->insert($SlotConfiguration);
            }

        } else {
            $sc->insert($SlotConfiguration);

        }

    }

    public function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        return ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);
    }

    /**
     * @throws Exception
     */
    public function hoursRange($lower = 0, $upper = 86400, $step = 3600, $format = ''): array
    {
        $times = array();

        if (empty($format)) {
            $format = 'g:i a';
        }

        foreach (range($lower, $upper, $step) as $increment) {
            $increment = gmdate('H:i', $increment);

            [$hour, $minutes] = explode(':', $increment);

            $date = new DateTime($hour . ':' . $minutes);

            $times[$increment] = $date->format($format);
        }

        return $times;
    }

    public function slotConfigure()
    {
        try {
            $doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user(), JSON_THROW_ON_ERROR), 1, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            Log::info($e->getLine(). ':' . $e->getMessage());
        }

        $hospital_doctor_mapping = new HospitalDoctorMapping();
        $doctors_hospitals = $hospital_doctor_mapping->where('doctor_id', $doctorInfo['id'])->select('hospital_id')
            ->get()
            ->toArray();
        $doctors_hospitals_ids = array();
        foreach ($doctors_hospitals as $dh) {
            $doctors_hospitals_ids[] = $dh['hospital_id'];
        }
        //$doctors_hospitals_ids =  implode(',',$doctors_hospitals_ids);
        $hospitals = new Hospitals();
        //$consultation_types = new ConsultationTypes();
        $consultation_types = ConsultationTypes::all();
        $consultation_types_list = [];
        $fetch_durations = $this->fetchdurations();
        $hospitals_list = $hospitals->select('hospital_id', 'hospital_name')
            ->whereIn('hospital_id', $doctors_hospitals_ids)->get()
            ->toArray();
        //print_r($hospitals_list);
        return view('Frontend::slots/slotConfiguration')
            ->with(compact('doctorInfo', 'hospitals_list', 'consultation_types', 'consultation_types_list', 'fetch_durations'));
    }

    public function fetchdurations(): array
    {
        $duration_val = 15;
        $duration = Auth::user()->toArray();
        $duration_val = $duration['duration'];
        $durations = DB::table('durations')->select('id', 'shift', 's_start', 's_end')
            ->orderBy('id')
            ->get()
            ->toArray();
        $result['duration_val'] = $duration_val;
        $result['durations'] = $durations;

        $complete = array();
        foreach ($durations as $dur) {
            $complete[$dur->shift]['complete'] = $dur;
            $complete[$dur->shift]['start'] = $this->time_to_decimal($dur->s_start) * 60; //25200
            $complete[$dur->shift]['end'] = $this->time_to_decimal($dur->s_end) * 60; //43200
            $complete[$dur->shift]['minutes_total'] = $this->hoursRange($complete[$dur->shift]['start'], $complete[$dur->shift]['end'], 60 * $duration_val, 'h:i A'); //'H:i (h:i A)'
            $complete[$dur->shift]['minutes_start'] = $this->hoursRange($complete[$dur->shift]['start'], ($complete[$dur->shift]['end'] - (1 * $duration_val * 60)), 60 * $duration_val, 'h:i A');
            try {
                $complete[$dur->shift]['minutes_end'] = $this->hoursRange(($complete[$dur->shift]['start'] + (1 * $duration_val * 60)), $complete[$dur->shift]['end'], 60 * $duration_val, 'h:i A');
            } catch (Exception $e) {
                Log::info($e->getLine() . ':' . $e->getMessage());
            }

        }
        return $complete;

    }
}
