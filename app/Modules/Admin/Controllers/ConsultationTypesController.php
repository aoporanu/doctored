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
use App\Modules\Admin\Models\ConsultationTypes as ConsultationTypes;

/**
 * Description of ConsultationTypesController
 *
 * @author narendraoruganti
 */
class ConsultationTypesController extends AdminIndexController {

    private $_url_key = '/admin/consultationtypes';
    private $_mapping_key = 'CT';

    public function consultationtypes() {
        try {
            $this->setData($this->_url_key, 'view');
            $consultationtypes = ConsultationTypes::where('is_delete', 0)->paginate(10);
            return view('Admin::consultationtypes/consultationtypes')->with(['consultationtypes' => $consultationtypes,
                'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createConsultationTypes() {
        try {
            $this->setData($this->_url_key, 'add');
            $consultationtypes = ConsultationTypes::all();
            return view('Admin::consultationtypes/create_consultationtypes')->with(['consultationtypes' => $consultationtypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addConsultationTypes(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $request->validate([
                'ctype_name' => ['required']
                    ], [
                'ctype_name.required' => 'Consultation Type Name is required'
            ]);

            $requestParams = $this->filterParameters($request->all());
            $successMessage = 'Added suceessfully';
            $ctype_id = isset($requestParams['ctype_id']) ? $requestParams['ctype_id'] : 0;
            if ($ctype_id != 0) {
                $consultationtypes = ConsultationTypes::where('ctype_id', $ctype_id)->where('is_delete', 0)->first();
                $consultationtypes->ctype_name = $request->ctype_name;
                $consultationtypes->ctype_icon = $request->ctype_icon;
                $consultationtypes->ctype_descrption = $request->ctype_descrption;
                $consultationtypes->updated_by = Session::get('user_id');

                $consultationtypes->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $consultationtypesData = new ConsultationTypes();
                $consultationtypesData->ctype_name = $request->ctype_name;
                $consultationtypesData->ctype_icon = $request->ctype_icon;
                $consultationtypesData->ctype_descrption = $request->ctype_descrption;
                $consultationtypesData->created_by = Session::get('user_id');

                $consultationtypesData->save();
            }
            return Redirect::to('/admin/consultationtypes')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editConsultationTypes($ctypeId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $ctypeIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($ctypeId);
            $ctype_id = str_replace($this->_mapping_key, '', $ctypeIdData);
            $consultationtypesDetails = [];
            $consultationtypes = ConsultationTypes::all();
            if ($ctype_id) {
                $consultationtypes = ConsultationTypes::where('ctype_id', $ctype_id)->where('is_delete', 0)->first();
            }
            return view('Admin::consultationtypes/create_consultationtypes')->with(['consultationtypes' => $consultationtypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewConsultationTypes($ctypeId) {
        try {
            $this->setData($this->_url_key, 'view');
            $ctypeIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($ctypeId);
            $ctype_id = str_replace($this->_mapping_key, '', $ctypeIdData);
            $consultationtypesDetails = [];
            $consultationtypes = ConsultationTypes::all();
            if ($ctype_id) {
                $consultationtypes = ConsultationTypes::where('ctype_id', $ctype_id)->where('is_delete', 0)->first();
            }

            return view('Admin::consultationtypes/view_consultationtypes')->with(['consultationtypes' => $consultationtypes, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteConsultationTypes($ctypeId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $ctypeIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($ctypeId);
            $ctype_id = str_replace($this->_mapping_key, '', $ctypeIdData);
            if ($ctype_id) {
                if ($ctype_id)
                    $consultationtypesDetails = ConsultationTypes::where('ctype_id', $ctype_id)->where('is_delete', 0)->first();
                $consultationtypesDetails->is_delete = 1;
                $consultationtypesDetails->save();
                return Redirect::to('/admin/consultationtypes')->with('success', 'Deleted Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
