<?php

namespace App\Modules\Frontend\Services;

use Illuminate\Support\Facades\DB;

class HospitalService
{

    /**
     * @param $id
     * @return array
     */
    public function buildHospitalProfile($id): array
    {
        $hospitals = DB::table('hospitals')
            ->select(
                'hospitals.hospital_id',
                'hospitals.hospital_name',
                'hospitals.hospitalcode',
                'hospitals.hospital_business_name',
                'hospitals.hospital_type',
                'hospitals.logo as hlogo',
                'hospitals.phone as hphone',
                'hospitals.email as hemail',
                'hospitals.address_line1 as haddress1',
                'hospitals.address_line2 as haddress2',
                'hospitals.address_city as hcity',
                'hospitals.address_state as hstate',
                'hospitals.address_country as hcountry',
                'hospitals.location as hlocation',
                'hospitals.address_place as hplace',
                'hospitals.address_lat as haddress_lat',
                'hospitals.address_long as haddress_long',
                'hospitals.summary as hsummary',
                'doctors.id',
                'doctors.title',
                'doctors.firstname',
                'doctors.photo',
                'doctors.lastname',
                'doctors.doctorcode',
                'doctors.phone as dphone',
                'doctors.email as demail',
                'doctors.summary as dsummary',
                'doctors.address_line1 as dadd1',
                'doctors.address_line2 as dadd2',
                'doctors.address_city as daddress_city',
                'doctors.address_state as daddress_state',
                'doctors.address_country as daddress_country',
                'doctors.address_postcode as daddress_postcode',
                'doctors.address_place as daddress_place',
                'doctors.address_lat as daddress_lat',
                'doctors.address_long as daddress_long'
            )
            ->leftjoin('hospital_doctor_mapping', 'hospital_doctor_mapping.hospital_id', '=', 'hospitals.hospital_id')
            ->leftjoin('doctors', 'doctors.id', '=', 'hospital_doctor_mapping.doctor_id')

            //->join('follows', 'follows.user_id', '=', 'users.id')
            ->where('hospitals.hospitalcode', '=', $id)
            ->get();
        $hdata = array();
        foreach ($hospitals as $hkey => $hval) {
            $hdata['hospital_id'] = $hval->hospital_id;
            $hdata['hospital_name'] = $hval->hospital_name;
            $hdata['hospitalcode'] = $hval->hospitalcode;
            $hdata['hospital_business_name'] = $hval->hospital_business_name;
            $hdata['hospital_type'] = $hval->hospital_type;
            $hdata['hlogo'] = $hval->hlogo;
            $hdata['hphone'] = $hval->hphone;
            $hdata['hemail'] = $hval->hemail;
            $hdata['haddress1'] = $hval->haddress1;
            $hdata['hcity'] = $hval->hcity;
            $hdata['hstate'] = $hval->hstate;
            $hdata['hcountry'] = $hval->hcountry;
            $hdata['hlocation'] = $hval->hlocation;
            $hdata['hplace'] = $hval->hplace;
            $hdata['haddress_lat'] = $hval->haddress_lat;
            $hdata['haddress_long'] = $hval->haddress_long;
            $hdata['hsummary'] = $hval->hsummary;
            $hdata['doctors'][] = array(
                'title'             => $hval->title,
                'firstname'         => $hval->firstname,
                'lastname'          => $hval->lastname,
                'dphone'            => $hval->dphone,
                'demail'            => $hval->demail,
                'dsummary'          => $hval->dsummary,
                'doctorcode'        => $hval->doctorcode,
                'dadd1'             => $hval->dadd1,
                'dadd2'             => $hval->dadd2,
                'daddress_city'     => $hval->daddress_city,
                'daddress_state'    => $hval->daddress_state,
                'daddress_country'  => $hval->daddress_country,
                'daddress_postcode' => $hval->daddress_postcode,
                'daddress_place'    => $hval->daddress_place,
                'daddress_lat'      => $hval->daddress_lat,
                'daddress_long'     => $hval->daddress_long,
                'photo'             => $hval->photo
            );
        }
        return $hdata;
    }
}
