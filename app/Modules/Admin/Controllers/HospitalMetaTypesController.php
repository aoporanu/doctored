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
use App\Modules\Admin\Models\HospitalMetaTypes as HospitalMetaTypes;

/**
 * Description of HospitalMetaTypesController
 *
 * @author Narendra Oruganti
 */
class HospitalMetaTypesController extends AdminIndexController {
    private $_url_key = '/admin/settings/hospitalmetatypes';
    private $_mapping_key = 'DM';
    public function HospitalMetaTypes() {
        try {
            $this->setData($this->_url_key, 'view');
            $metatypes = HospitalMetaTypes::where('is_delete', 0)->paginate(10);
            return view('Admin::hospitals/hospitalmetatypes')->with(['metatypes' => $metatypes,
                    'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createHospitalMetaType() {
        try {
            $this->setData($this->_url_key, 'add');
            $metatypes = HospitalMetaTypes::where('is_delete', 0)->get()->all();
            return view('Admin::hospitals/create_hospitalmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addHospitalMetaType(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $this->validate($request, [
                'hmetaname' => ['required'],
                'hmetakey' => ['required']
                    ], [
                'hmetaname.required' => 'Hospital meta Name is required',
                'hmetakey.required' => 'Hospital meta Key is required'
            ]);

            $requestParams = $this->filterParameters($request->all());
            $hmeta_id = isset($requestParams['hmeta_id']) ? $requestParams['hmeta_id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($hmeta_id != 0) {
                $metatypes = HospitalMetaTypes::where('hmeta_id', $hmeta_id)->where('is_delete', 0)->first();
                $metatypes->hmetaname = $request->hmetaname;
                $metatypes->hmetakey = $request->hmetakey;
                $metatypes->hmeta_lang_code = $request->hmeta_lang_code;
                $metatypes->hmeta_icon = $request->hmeta_icon;
                $metatypes->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $metaData = new HospitalMetaTypes();
                $metaData->hmetaname = $request->hmetaname;
                $metaData->hmetakey = $request->hmetakey;
                $metaData->hmeta_lang_code = $request->hmeta_lang_code;
                $metaData->hmeta_icon = $request->hmeta_icon;
                $metaData->save();
            }
            return Redirect::to('admin/settings/hospitalmetatypes')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editHospitalMetaType($hmetaId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $hmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($hmetaId);
            $hmeta_id = str_replace($this->_mapping_key, '', $hmetaIdData);
            $metatypes = [];
            if ($hmeta_id) {
                $metatypes = HospitalMetaTypes::where('hmeta_id', $hmeta_id)->where('is_delete', 0)->first();
            }else{
                return Redirect::back()->with('error', 'Data not found');
            }
            return view('Admin::hospitals/create_hospitalmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewHospitalMetaType($hmetaId) {
        try {
            $this->setData($this->_url_key, 'view');
            $hmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($hmetaId);
            $hmeta_id = str_replace($this->_mapping_key, '', $hmetaIdData);
            $metatypes = [];
            if ($hmeta_id) {
                $metatypes = HospitalMetaTypes::where('hmeta_id', $hmeta_id)->where('is_delete', 0)->first();
            }else{
                return Redirect::back()->with('error', 'Data not found');
            }
            return view('Admin::hospitals/view_hospitalmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteHospitalMetaType($hmetaId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $hmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($hmetaId);
            $hmeta_id = str_replace($this->_mapping_key, '', $hmetaIdData);
            if ($hmeta_id) {
                if ($hmeta_id)
                    $menuDetails = HospitalMetaTypes::where('hmeta_id', $hmeta_id)->where('is_delete', 0)->first();
                $menuDetails->is_delete = 1;
                $menuDetails->save();
                return Redirect::to('admin/settings/hospitalmetatypes')->with('success', 'Deleted Successfully');
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
