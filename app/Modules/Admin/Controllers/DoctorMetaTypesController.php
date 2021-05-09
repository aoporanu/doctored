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
use App\Modules\Admin\Models\DoctorMetaTypes as DoctorMetaTypes;

/**
 * Description of DoctorMetaTypesController
 *
 * @author Narendra Oruganti
 */
class DoctorMetaTypesController extends AdminIndexController {
    private $_url_key = '/admin/settings/doctorsmetatypes';
    private $_mapping_key = 'DM';
    private $_mapping_type = 'DoctorMetaType';
    public function doctorMetaTypes() {
        try {
            $this->setData($this->_url_key, 'view');
            $metatypes = DoctorMetaTypes::where('is_delete', 0)->paginate(10);
            return view('Admin::doctors/doctormetatypes')->with(['metatypes' => $metatypes,
                    'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key, 'mappingType' => $this->_mapping_type]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createDoctorMetaType() {
        try {
            $this->setData($this->_url_key, 'add');
            $metatypes = DoctorMetaTypes::where('is_delete', 0)->get()->all();
            return view('Admin::doctors/create_doctormetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addDoctorMetaType(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $this->validate($request, [
                'dmetaname' => ['required'],
                'dmetakey' => ['required']
                    ], [
                'dmetaname.required' => 'Doctor meta Name is required',
                'dmetakey.required' => 'Doctor meta Key is required'
            ]);

            $requestParams = $this->filterParameters($request->all());
            $dmeta_id = isset($requestParams['dmeta_id']) ? $requestParams['dmeta_id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($dmeta_id != 0) {
                $metatypes = DoctorMetaTypes::where('dmeta_id', $dmeta_id)->where('is_delete', 0)->first();
                $metatypes->dmetaname = $request->dmetaname;
                $metatypes->dmetakey = $request->dmetakey;
                $metatypes->dmeta_lang_code = $request->dmeta_lang_code;
                $metatypes->dmeta_icon = $request->dmeta_icon;
                $metatypes->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $metaData = new DoctorMetaTypes();
                $metaData->dmetaname = $request->dmetaname;
                $metaData->dmetakey = $request->dmetakey;
                $metaData->dmeta_lang_code = $request->dmeta_lang_code;
                $metaData->dmeta_icon = $request->dmeta_icon;
                $metaData->save();
            }
            return Redirect::to('admin/settings/doctorsmetatypes')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editDoctorMetaType($dmetaId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $dmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($dmetaId);
            $dmeta_id = str_replace($this->_mapping_key, '', $dmetaIdData);
            $metatypes = [];
            if ($dmeta_id) {
                $metatypes = DoctorMetaTypes::where('dmeta_id', $dmeta_id)->where('is_delete', 0)->first();
            }else{
                return Redirect::back()->with('error', 'Data not found');
            }
            return view('Admin::doctors/create_doctormetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewDoctorMetaType($dmetaId) {
        try {
            $this->setData($this->_url_key, 'view');
            $dmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($dmetaId);
            $dmeta_id = str_replace($this->_mapping_key, '', $dmetaIdData);
            $metatypes = [];
            if ($dmeta_id) {
                $metatypes = DoctorMetaTypes::where('dmeta_id', $dmeta_id)->where('is_delete', 0)->first();
            }else{
                return Redirect::back()->with('error', 'Data not found');
            }
            return view('Admin::doctors/view_doctormetatypes')->with(['metatypes' => $metatypes, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteDoctorMetaType($dmetaId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $dmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($dmetaId);
            $dmeta_id = str_replace($this->_mapping_key, '', $dmetaIdData);
            if ($dmeta_id) {
                if ($dmeta_id)
                    $menuDetails = DoctorMetaTypes::where('dmeta_id', $dmeta_id)->where('is_delete', 0)->first();
                $menuDetails->is_delete = 1;
                $menuDetails->save();
                return Redirect::to('admin/settings/doctorsmetatypes')->with('success', 'Deleted Successfully');
            }else{
                return Redirect::back()->with('error', 'Data not found');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
