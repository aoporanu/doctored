<?php

namespace App\Http\Controllers;

use App\Modules\Admin\Models\ConsultationMapping;
use App\Modules\Admin\Models\ConsultationTypes;
use App\Modules\Admin\Models\Specialization;
use App\Modules\Admin\Models\SpecializationMapping;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct()
    {
        $info = json_decode(json_encode(Auth::guard('patient')->user()), 1);
        $doctor_info = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
    }

    public function filterParameters($params)
    {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (is_array($params[$key])) {
                    $params[$key] = self::filterParameters($value);
                }
                if (is_string($value)) {
                    $params[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }
            }
        }
        if (is_string($params)) {
            $params = htmlspecialchars($params, ENT_QUOTES, 'UTF-8');
        }
        return $params;
    }

    /**
     * @param Request $request
     * @param $doctors
     * @throws ValidationException
     */
    protected function setProfilePhoto(Request $request, $doctors): void
    {
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
                }
            }
        }
    }

    /**
     * @param mixed $requestParams
     * @param mixed $id
     * @param string $mappingType
     * @param int $userId
     * @return mixed
     */
    protected function setSpecialization(
        mixed $requestParams,
        mixed $id,
        string $mappingType,
        int $userId
    ) {
        if (isset($requestParams['specialization']) && count($requestParams['specialization']) > 0) {
            foreach ($requestParams['specialization'] as $specilizationId) {
                if ($specilizationId > 0) {
                    $specializationDetails = SpecializationMapping
                        ::where('mapping_type', $mappingType)
                        ->where('mapping_type_id', $id)
                        ->where('specialization_id', $specilizationId)
                        ->get()->all();
                    if (!$specializationDetails) {
                        $specializationData = new SpecializationMapping();
                        $specializationData->mapping_type = $mappingType;
                        $specializationData->mapping_type_id = $id;
                        $specializationData->specialization_id = $specilizationId;
                        $specializationData->created_by = $userId;
                        $specializationData->updated_by = 0;
                        $specializationData->save();
                    }
                }
            }
            $specializationList = SpecializationMapping::where(
                'mapping_type',
                $mappingType
            )->where('mapping_type_id', $id)->get()
                ->all();
            foreach ($specializationList as $specializationInfo) {
                if (!in_array($specializationInfo->specialization_id, $requestParams['specialization'])) {
                    $specializationInfo->delete();
                }
            }
        } else {
            SpecializationMapping::where('mapping_type', $mappingType)->where('mapping_type_id', $id)->delete();
        }
        if (isset($requestParams['consultation_types']) && count($requestParams['consultation_types']) > 0) {
            foreach ($requestParams['consultation_types'] as $consultationId) {
                if ($consultationId > 0) {
                    $consultationDetails = ConsultationMapping
                        ::where('mapping_type', $mappingType)
                        ->where('mapping_type_id', $id)
                        ->where('consultation_id', $consultationId)
                        ->get()->all();
                    if (!$consultationDetails) {
                        $consultationData = new ConsultationMapping();
                        $consultationData->mapping_type = $mappingType;
                        $consultationData->mapping_type_id = $id;
                        $consultationData->consultation_id = $consultationId;
                        $consultationData->created_by = $userId;
                        $consultationData->updated_by = 0;
                        $consultationData->save();
                    }
                }
            }
            $consultationData = ConsultationMapping::where(
                'mapping_type',
                $mappingType
            )->where('mapping_type_id', $id)->get()->all();
            foreach ($consultationData as $consultationInfo) {
                if (!in_array($consultationInfo->consultation_id, $requestParams['consultation_types'])) {
                    $consultationInfo->delete();
                }
            }
        } else {
            ConsultationMapping::where('mapping_type', $mappingType)->where('mapping_type_id', $id)->delete();
        }
        return $requestParams;
    }

    /**
     * @param array|string $hospital_id
     * @return array
     */
    protected function setSpecializationToConsultation(array | string $hospital_id): array
    {
        $specializations = Specialization::all()->where('is_delete', 0);
        $specializationData = SpecializationMapping::where('mapping_type', $this->_mapping_type)
            ->where('mapping_type_id', $hospital_id)->get()->all();
        $specializationList = [];
        if ($specializationData) {
            foreach ($specializationData as $specializationInfo) {
                $specializationList[] = $specializationInfo->specialization_id;
            }
        }
        $consultationTypes = ConsultationTypes::all()->where('is_delete', 0);
        $consultationData = ConsultationMapping::where('mapping_type', $this->_mapping_type)
            ->where('mapping_type_id', $hospital_id)->get()->all();
        $consultationList = [];
        if ($consultationData) {
            foreach ($consultationData as $consultationInfo) {
                $consultationList[] = $consultationInfo->consultation_id;
            }
        }
        return array($specializations, $specializationList,
            $consultationTypes, $consultationList, $consultationData);
    }

    /**
     * @param $hospitals
     * @param string $phone
     * @return array
     */
    protected function setPhoneForHospital($hospitals, $phone = ''): array
    {
        $phoneCode = '';
        $phoneNumber = '';
        if (!empty($hospitals) && isset($hospitals->phone) && $phone != '') {
            $phoneDetails = explode('-', $phone);
            $phoneCode = isset($phoneDetails[0]) ? $phoneDetails[0] : '';
            $phoneNumber = isset($phoneDetails[1]) ? $phoneDetails[1] : '';
        }
        return array($phoneCode, $phoneNumber);
    }

    /**
     * @param mixed $id
     * @return array
     */
    protected function constructConsultations(mixed $id): array
    {
        $consultations = DB::table('consultation_mapping')
            ->where('doctors.doctorcode', $id)
            ->select('consultation_types.ctype_name', 'consultation_types.ctype_icon', 'consultation_types.ctype_id')
            ->leftjoin('consultation_types', 'consultation_types.ctype_id', 'consultation_mapping.consultation_id')
            ->leftjoin('doctors', 'consultation_mapping.mapping_type_id', 'doctors.id')
            ->get()->toArray();

        $allctype = DB::table('consultation_types')->select('ctype_id', 'ctype_name', 'ctype_icon')->get()->toArray();
        $allctypes = array();

        foreach ($allctype as $akey => $aval) {

            $allctypes[$aval->ctype_id] = array($aval->ctype_name, $aval->ctype_icon);

        }
        return array($consultations, $allctypes);
    }
}
