<?php

namespace App\Modules\Frontend\Services;

use App\Modules\Admin\Models\ConsultationTypes;
use App\Modules\Admin\Models\LanguageMapping;
use App\Modules\Frontend\Models\ConsultationData;
use Illuminate\Support\Facades\DB;

class SlotsService
{

    /**
     * @param array $languages
     * @param $id
     * @return array
     */
    public function buildSlots(array $languages, $id): array
    {
        $languageList = [];
        if ($languages) {
            foreach ($languages as $langInfo) {
                $languageList[] = trim($langInfo->lang_mapping_id);
            }
        }

        //specialization
        $specialization = DB::table('specialization_mapping')
            ->select('specialization_types.specialization_shortcode')
            ->where('specialization_mapping.mapping_type', 'Doctor')
            ->where('doctors.doctorcode', $id)
            ->leftjoin('doctors', 'specialization_mapping.mapping_type_id', 'doctors.id')
            ->leftjoin('specialization_types', 'specialization_types.id', 'specialization_mapping.specialization_id')
            ->get()->toArray();

        //meta data
        $metadata = DB::table('metatype_data')
            ->select('metatype_data.mapping_type_data_value', 'doctor_metatypes.dmetaname')
            ->where('metatype_data.mapping_type', 'Doctor')
            ->where('doctors.doctorcode', $id)
            ->leftjoin('doctors', 'metatype_data.mapping_type_id', 'doctors.id')
            ->leftjoin('doctor_metatypes', 'doctor_metatypes.dmeta_id', 'metatype_data.mapping_type_data_id')
            ->get()->toArray();

        $slotsquery = DB::table('slots')
            ->select('slots.hospital_id', 'booking_start_time', 'slots.id as slotid', 'screen_id', 'hospital_name', 'shift', 'booking_date', 'booking_time_long', 'available_types')
            ->where('slots.is_delete', '0')
            ->where('slots.is_active', '1')
            ->where('booking_date', '>=', date('d-m-Y'))
            ->where('doctors.doctorcode', $id)
            ->leftjoin('doctors', 'slots.doctor_id', 'doctors.id')
            ->leftjoin('hospitals', 'slots.hospital_id', 'hospitals.hospital_id');

        if (isset($_REQUEST['h']) && $_REQUEST['h'] != '') {
            $slotsquery->where('slots.hospital_id', $_REQUEST['h']);
        }
        return array($languageList, $specialization, $metadata, $slotsquery);
    }

    /**
     * @param $slots
     * @param array $dates
     * @param string $design
     * @return string
     */
    public function restructureSlots($slots, array $dates, string $design): string
    {
        $restructure = [];

        foreach ($slots as $sl_key => $sl_val) {
            $dates[] = $sl_val['booking_date'];
            $restructure[$sl_val['doctor_id']][$sl_val['booking_date']][$sl_val['hospital_id']][] = $sl_val['booking_time_long'];
        }
        $dates = array_unique($dates);
        $design .= "<p>";
        foreach ($dates as $d_k => $d_v) {
            $booking_date = str_replace('-', '', $d_v);

            $design .= '<a data-toggle="collapse" data-target="#date_' . $booking_date . '" aria-expanded="false" aria-controls="date_' . $booking_date . '">
		  <span class="badge badge-pill badge-primary sort_bage norm_bad2">' . $d_v . '</span></a>';
        }
        foreach ($restructure as $rk => $rv) {
            foreach ($rv as $rrk => $rrv) {
                $booking_dates = str_replace('-', '', $rrk);
                $design .= '<div id="date_' . $booking_dates . '" class="collapse multi-collapse">';
                foreach ($rrv as $k => $v) {
                    foreach ($v as $finalkey => $finalval) {
                        $design .= "<a class='btn btn-sm' href='/book-appointment?doctor_id=" . $rk . "&hospital_id=" . $k . "'>" . $finalval . "</a>";
                    }
                }
                $design .= '</div>';
            }
        }

        $design .= "</p>";
        return $design;
    }

    /**
     * @param $slotId
     * @return array
     */
    public function buildConsultationTypes($slotId): array
    {
        $slotsquery = DB::table('appointments')
            ->select(
                DB::raw('doctors.id as doctor_id'),
                'hospitals.hospital_id',
                DB::raw('patients.id as patient_id'),
                'appointments.slotid',
                'appointments.title',
                'appointments.description',
                'doctors.doctorcode',
                DB::raw(DB::raw("CONCAT(doctors.firstname, ' ' ,doctors.lastname) as doctor_name")),
                'doctors.doctorcode',
                'appointments.booking_date',
                DB::raw(DB::raw("CONCAT(patients.firstname, ' ' ,patients.lastname) as patient_name")),
                'appointments.booking_type',
                'consultation_types.ctype_name',
                'consultation_types.ctype_icon',
                'patients.patientcode',
                'patients.photo',
                'patients.email',
                'appointments.booking_time_long',
                'appointments.booking_status'
            )
            ->where('appointments.slotid', $slotId)
            ->leftjoin('doctors', 'appointments.doctor_id', 'doctors.id')
            ->leftjoin('hospitals', 'appointments.hospital_id', 'hospitals.hospital_id')
            ->leftjoin('consultation_types', DB::raw('CAST(appointments.booking_type as int)'), 'consultation_types.ctype_id')
            ->leftjoin('patients', 'appointments.patient_id', 'patients.id');
        $slotData = $slotsquery->first();
        $languageData = LanguageMapping::
        join('languages', 'languages.id', '=', 'lang_mapping.lang_mapping_id')
            ->where('lang_mapping.module_mapping_type', 'Doctor')
            ->where('lang_mapping.module_mapping_type_id', $slotData->doctor_id)->get()->all();
        $consultationTypesObj = ConsultationTypes::select('ctype_name', 'ctype_id')->whereIn('ctype_id', (explode(',', $slotData->booking_type)))->where('is_delete', 0)->get()->all();
        if (count($consultationTypesObj) == 1) {
            $consultationTypesObj = [];
        }
        $consultationTypesDataObj = ConsultationData::
        where('consultation_data.doctor_id', $slotData->doctor_id)
            ->where('consultation_data.patient_id', $slotData->patient_id)
            ->where('consultation_data.hospital_id', $slotData->hospital_id)
            ->where('consultation_data.slot_id', $slotData->slotid)
            ->where('is_delete', 0)->get()->all();
        $consultationTypeDataList = [];
        if ($consultationTypesObj) {
            foreach ($consultationTypesDataObj as $consultationData) {
                $consultationTypeDataList[$consultationData->consultation_type] = $consultationData->consultation_type_data;
            }
        }
        return array($slotData, $languageData, $consultationTypesObj, $consultationTypesDataObj, $consultationTypeDataList);
    }
}
