<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use App\Http\Middleware\EncryptUrlParams;
use App\Http\Requests\AddMemberRequest;
use App\Modules\Admin\Controllers\AdminIndexController as AdminIndexController;
use App\Modules\Admin\Models\MetatypeData;
use App\Modules\Admin\Models\PatientMetaTypes;
use App\Modules\Admin\Models\Patients as Patients;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

/**
 * Description of PatientsController
 *
 * @author Narendra Oruganti
 */
class PatientsController extends AdminIndexController
{

    private string $url_key = '/admin/members';
    private string $mappingType = 'Patient';
    private string $mapping_key = 'P';

    public function members()
    {
        try {
            $this->setData($this->url_key, 'view');
            $patients = Patients::where('is_delete', 0)->paginate(10);
            return view('Admin::patients/patients')->with(['patients' => $patients,
                    'accessDetails' => $this->accessDetails, 'mapping_key' => $this->mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addMember(AddMemberRequest $request)
    {
        try {
            $this->setData($this->url_key, 'add');
            $requestParams = $this->filterParameters($request->validated());

            $patient_id = isset($requestParams['patient_id']) ? $requestParams['patient_id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($patient_id != 0) {
                $patients = Patients::where('id', $patient_id)->where('is_delete', 0)->first();
                $patients->title = $request->title;
                $patients->firstname = $request->firstname;
                $patients->lastname = $request->lastname;
                $patients->gender = $request->gender;
                $patients->dob = $request->dob;
                $this->setProfilePhoto($request, $patients);
                $patients->phone = $request->phone;
                $patients->email = $request->email;
                $patients->password = Hash::make($request->email);
                $patients->address_line1 = $request->address_line1;
                $patients->address_line2 = $request->address_line2;
                $patients->address_line3 = $request->address_line3;
                $patients->address_city = $request->address_city;
                $patients->address_state = $request->address_state;
                $patients->address_country = $request->address_country;
                $patients->address_postcode = $request->address_postcode;

                $patients->last_screening = $request->last_screening;

                $patients->emer_firstname = $request->emer_firstname;
                $patients->emer_lastname = $request->emer_lastname;
                $patients->emer_phone = $request->emer_phone;
                $patients->emer_email = $request->emer_email;
                $patients->terms = $request->terms;
                $patients->visitor = $this->getUserIpAddr();
                $patients->save();
                $successMessage = 'Updated suceessfully';
            }
            $patienMetaTypes = PatientMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $this->saveMetaTypeData(
                $patient_id,
                $this->mappingType,
                $patienMetaTypes,
                $requestParams,
                'pmetaname',
                'pmeta_id'
            );
            return Redirect::to('/admin/members')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editMember($patientId)
    {
        try {
            $this->setData($this->url_key, 'edit');
            $patientIdData = EncryptUrlParams::decrypt($patientId);
            $patient_id = str_replace($this->mapping_key, '', $patientIdData);
            $patients = [];

            if ($patient_id) {
                $patients = Patients::where('id', $patient_id)->where('is_delete', 0)->first();
            }
            $patienMetaTypes = PatientMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $patienMetaData = MetatypeData::where('mapping_type', $this->mappingType)
                            ->where('mapping_type_id', $patient_id)->get()->all();
            $patientMetaList = [];
            if ($patienMetaData) {
                foreach ($patienMetaData as $patientMetaInfo) {
                    $patientMetaList[$patientMetaInfo->mapping_type_data_id] =
                        $patientMetaInfo->mapping_type_data_value;
                }
            }
            return view('Admin::patients/create_patients')->with([
                'patients' => $patients,
                'patienMetaTypes' => $patienMetaTypes,
                'patientMetaList' => $patientMetaList
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewMember($patientId)
    {
        try {
            $this->setData($this->url_key, 'view');
            $patientIdData = EncryptUrlParams::decrypt($patientId);
            $patient_id = str_replace($this->mapping_key, '', $patientIdData);
            $patients = [];

            if ($patient_id) {
                $patients = Patients::where('id', $patient_id)->where('is_delete', 0)->first();
            }

            return view('Admin::patients/view_patients')->with(['patients' => $patients]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteMember($patientId)
    {
        try {
            $this->setData($this->url_key, 'delete');
            $patientIdData = EncryptUrlParams::decrypt($patientId);
            $patient_id = str_replace($this->mapping_key, '', $patientIdData);
            if ($patient_id) {
                $patientDetails = Patients::where('id', $patient_id)->where('is_delete', 0)->first();
                $patientDetails->is_delete = 1;
                $patientDetails->save();
                return Redirect::to('admin/members')->with('success', 'Deleted Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
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
}
