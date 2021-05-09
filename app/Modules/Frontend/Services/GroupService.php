<?php


namespace App\Modules\Frontend\Services;


use Illuminate\Support\Facades\DB;

class GroupService
{

    /**
     * @param $id
     * @return array
     */
    public function buildGroupProfile($id): array
    {
        $groups = DB::table('group')
            ->select(
                'group.gid',
                'group.group_name',
                'group.logo as glogo',
                'group.group_description',
                'group.group_business_name',
                'group.address as gaddress',
                'group.address_place as gplace',
                'group.address_long as glong',
                'group.address_lat as glat',
                'group.phone as gphone',
                'group.email as gemail',
                'hospitals.*'
            )
            ->leftjoin('group_hospital_mapping', 'group_hospital_mapping.group_id', '=', 'group.gid')
            ->leftjoin('hospitals', 'hospitals.hospital_id', '=', 'group_hospital_mapping.hospital_id')

            //->join('follows', 'follows.user_id', '=', 'users.id')
            ->where('group.gid', '=', $id)
            ->get();
        $groupData = array();
        $hospitals = array();
        foreach ($groups as $gk => $gv) {
            $groupData['gid'] = $gv->gid;
            $groupData['group_name'] = $gv->group_name;
            $groupData['glogo'] = $gv->glogo;
            $groupData['group_description'] = $gv->group_description;
            $groupData['group_business_name'] = $gv->group_business_name;
            $groupData['gaddress'] = $gv->gaddress;
            $groupData['gplace'] = $gv->gplace;
            $groupData['glong'] = $gv->glong;
            $groupData['glat'] = $gv->glat;
            $groupData['gphone'] = $gv->gphone;
            $groupData['gemail'] = $gv->gemail;
            $groupData['hospitals'][] = array(
                'hospital_id'            => $gv->hospital_id,
                'hospital_name'          => $gv->hospital_name,
                'hospitalcode'           => $gv->hospitalcode,
                'hospital_business_name' => $gv->hospital_business_name,
                'hospital_type'          => $gv->hospital_type,
                'logo'                   => $gv->logo,
                'banner'                 => $gv->banner,
                'phone'                  => $gv->phone,
                'email'                  => $gv->email,
                'fax'                    => $gv->fax,
                'licence'                => $gv->licence,
                'address_line1'          => $gv->address_line1,
                'address_line2'          => $gv->address_line2,
                'address_city'           => $gv->address_city,
                'address_country'        => $gv->address_country,
                'location'               => $gv->location,
                'address_place'          => $gv->address_place,
                'address_lat'            => $gv->address_lat,
                'address_long'           => $gv->address_long,
                'summary'                => $gv->summary,
                'address_state'          => $gv->address_state,
                'address_postcode'       => $gv->address_postcode,
            );
        }
        return $groupData;
    }
}
