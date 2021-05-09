<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Controllers\AdminIndexController as AdminIndexController;
use Redirect;
use View;
use Log;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Modules\Admin\Models\PatientMetaTypes as PatientMetaTypes;

/**
 * Description of PatientMetaTypesController
 *
 * @author Narendra Oruganti
 */
class PatientMetaTypesController extends AdminIndexController {

    private $_url_key = '/admin/settings/patientsmetatypes';
    private $_mapping_key = 'PM';

    public function patientMetaTypes() {
        try {
            $this->setData($this->_url_key, 'view');
            $metatypes = PatientMetaTypes::where('is_delete', 0)->paginate(10);
            return view('Admin::patients/patientmetatypes')->with(['metatypes' => $metatypes,
                    'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createPatientMetaType() {
        try {
            $this->setData($this->_url_key, 'add');
            $metatypes = PatientMetaTypes::all();
            return view('Admin::patients/create_patientmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addPatientMetaType(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $this->validate($request, [
                'pmetaname' => ['required'],
                'pmetakey' => ['required']
                    ], [
                'pmetaname.required' => 'Patient meta Name is required',
                'pmetakey.required' => 'Patient meta Key is required'
            ]);

            $requestParams = $this->filterParameters($request->all());
            $pmeta_id = isset($requestParams['pmeta_id']) ? $requestParams['pmeta_id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($pmeta_id != 0) {
                $metatypes = PatientMetaTypes::where('pmeta_id', $pmeta_id)->where('is_delete', 0)->first();
                $metatypes->pmetaname = $request->pmetaname;
                $metatypes->pmetakey = $request->pmetakey;
                $metatypes->pmeta_lang_code = $request->pmeta_lang_code;
                $metatypes->pmeta_icon = $request->pmeta_icon;

                $metatypes->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $metaData = new PatientMetaTypes();
                $metaData->pmetaname = $request->pmetaname;

                $metaData->pmetakey = $request->pmetakey;
                $metaData->pmeta_lang_code = $request->pmeta_lang_code;
                $metaData->pmeta_icon = $request->pmeta_icon;
                $metaData->is_active = 1;

                $metaData->save();
            }
            return Redirect::to('admin/settings/patientsmetatypes')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editPatientMetaType($pmetaId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $pmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($pmetaId);
            $pmeta_id = str_replace($this->_mapping_key, '', $pmetaIdData);
            $metatypes = [];

            if ($pmeta_id) {
                $metatypes = PatientMetaTypes::where('pmeta_id', $pmeta_id)->where('is_delete', 0)->first();
            }

            return view('Admin::patients/create_patientmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewPatientMetaType($pmetaId) {
        try {
            $this->setData($this->_url_key, 'view');
            $pmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($pmetaId);
            $pmeta_id = str_replace($this->_mapping_key, '', $pmetaIdData);
            $metatypes = [];

            if ($pmeta_id) {
                $metatypes = PatientMetaTypes::where('pmeta_id', $pmeta_id)->where('is_delete', 0)->first();
            }

            return view('Admin::patients/view_patientmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deletePatientMetaType($pmetaId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $pmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($pmetaId);
            $pmeta_id = str_replace($this->_mapping_key, '', $pmetaIdData);
            if ($pmeta_id) {
                if ($pmeta_id)
                    $menuDetails = PatientMetaTypes::where('pmeta_id', $pmeta_id)->where('is_delete', 0)->first();
                $menuDetails->is_delete = 1;
                $menuDetails->save();
                return Redirect::to('admin/settings/patientsmetatypes')->with('success', 'Deleted Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
